<?php
/*TODO:: By Eng. Moomen Sameer Aldahdouh 0599124279, moomenaldahdouh@gmail.com*/
namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\AddressTypes;
use App\Models\Cart;
use App\Models\CartOption;
use App\Models\Coupon;
use App\Models\Guest;
use App\Models\GuestAddress;
use App\Models\Location;
use App\Models\Order;
use App\Models\OrderDeliveryAddress;
use App\Models\OrderItems;
use App\Models\OrderOptions;
use App\Models\OrderPayment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Facades\Agent;

class CheckoutController extends Controller
{
    public function index()
    {
        if (auth()->guard("web")->user())
            return redirect(env("APP_URL") . "/checkout/user");
        else
            return view("cart-checkout");
    }

    public function note(Request $request)
    {
        if ($request->ajax()) {
            Session::put("cart_note", $request->note);
            return response()->json(['success' => "success"]);
        }
        return response()->json(['error' => "error"]);
    }

    public function checkout_guest()
    {
        if (Session::has("guest_id")) {
            $address_types = AddressTypes::query()->where("status", 1)->get();
            $areas = Location::query()->where("type", 0)->where("status", 1)->get();
            $cities = Location::query()->where("type", 1)->where("status", 1)->get();
            $promo = $this->promo();
            $carts = Session::get('cart');
            $cart_options = [];
            if (Session::has('cart_options'))
                $cart_options = Session::get('cart_options');
            $note = "";
            if (Session::has("cart_note"))
                $note = Session::get("cart_note");
            return view("cart-checkout-step-2", compact("address_types", "areas", "cities", "promo", "note", "carts", "cart_options"));

        } else {
            return redirect(env("APP_URL") . "/checkout");
        }
    }

    public function checkout_user()
    {
        $address_types = AddressTypes::query()->where("status", 1)->get();
        $areas = Location::query()->where("type", 0)->where("status", 1)->get();
        $cities = Location::query()->where("type", 1)->where("status", 1)->get();
        $promo = $this->promo();
        $carts = Session::get('cart');
        $cart_options = [];
        if (Session::has('cart_options'))
            $cart_options = Session::get('cart_options');
        $note = "";
        if (Session::has("cart_note"))
            $note = Session::get("cart_note");
        if (auth()->guard("web")->user()) {
            $user = auth()->guard("web")->user();
            return view("cart-checkout-step-2-user", compact("address_types", "areas", "cities", "promo", "user", "note", "carts", "cart_options"));
        } else
            return redirect(env("APP_URL") . "/checkout");
    }

    public function guest_email(Request $request)
    {
        if ($request->ajax()) {
            //dd($request);
            $validator = Validator::make($request->all(), [
                'email_guest' => 'required|email',
            ], [
                'email_guest.required' => trans("sts.This field is required")
            ]);
            if ($validator->passes()) {
                $guest_id = time();
                $guest = new Guest();
                $guest->id = $guest_id;
                $guest->email = $request->email_guest;
                $guest->created_at = Carbon::now();
                $guest->updated_at = Carbon::now();
                $guest->save();
                if ($guest) {
                    Session::put("guest_id", $guest_id);
                    Session::put("guest_email", $guest->email);
                }
                return response()->json(['success' => "success"]);
            }
            return response()->json(['error' => $validator->errors()->toArray()]);
        }
    }

    public function promo()
    {
        $promo = 0;
        if (Session::has("promo"))
            $promo = Coupon::query()->where("id", Session::get("promo")->id)->where("status", 1)->get()->first();
        return $promo;
    }

    public function promosdc()
    {
        $promo = 0;
        if (Session::has("promo"))
            $promo = Coupon::query()->where("id", Session::get("promo")->id)->where("status", 1)->get()->first();
        if ($promo)
            return response()->json(['success' => $promo]);
        else
            return response()->json(['error' => "error"]);
    }

    public function discount_promo(Request $request, $id)
    {
        if ($request->ajax()) {
            $promo = Coupon::query()->where("id", $id)->where("status", 1)->get()->first();
            if ($promo)
                return response()->json(['success' => $promo]);
            else
                return response()->json(['error' => "error"]);
        }
    }

    public function cities_area(Request $request, $id)
    {
        if ($request->ajax()) {
            $cities = Location::query()->where("area_fk_id", $id)->where("status", 1)->get();
            if ($cities)
                return view("cities_area", compact("cities"))->render();
        }
    }

    public function city(Request $request, $id)
    {
        if ($request->ajax()) {
            $city = Location::query()->where("id", $id)->where("status", 1)->get()->first();
            if ($city) {
                $price = $city->price;
                return $price;
            }
            return 0;
        }
    }

    public function order(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'total' => 'required',
                'payment_method' => 'required',
                'order_address_fk_id' => 'required',
            ], [
                'total.required' => trans("sts.This field is required"),
                'payment_method.required' => trans("sts.This field is required"),
                'order_address_fk_id.required' => trans("sts.This field is required"),
            ]);
            if ($validator->passes()) {
                $cart_items = $request->cart_items;
                $cart_options = $request->cart_options;
                $cart_delivery_address = $request->order_address_fk_id;
                $user_id = "";
                $user_address = "";
                $user_type = $request->user_type;
                if ($user_type == 1) {
                    $user_id = Session::get("guest_id");
                    $user_address = GuestAddress::query()->find($cart_delivery_address);
                } else {
                    $user_id = auth()->guard("web")->user()->id;
                    $user_address = Address::query()->find($cart_delivery_address);
                }
                $order_id = "10" . substr(time(), 0, -2);
                //Save Order
                $save_order = $this->save_order($user_id, $order_id, $request);
                //Save Delivery Address
                $save_delivery_address = $this->save_delivery_address($order_id, $user_id, $user_address);
                //Save Order items
                $save_order_items = $this->save_order_items($cart_items, $user_id, $order_id);
                //if success forgot Note, Discount code, Cart, and Options session
                if ($save_order && $save_delivery_address && $save_order_items) {
                    Session::put("order_id", $order_id);
                    //ob_end_clean();
                    if (ob_get_length()) ob_end_clean();
                    return response()->json(['success' => $order_id]);
                } else {
                    return response()->json(['failed' => "failed"]);
                }
            }
            return response()->json(['error' => $validator->errors()->toArray()]);
        }
    }

    public function user_order($request, $payment_id)
    {
        $cart_items = $request["cart_items"];
        $cart_delivery_address = $request["order_address_fk_id"];
        $user_id = "";
        $user_email = "";
        $user_address = "";
        $user_type = $request["user_type"];
        if ($user_type == 1) {
            $user_id = Session::get("guest_id");
            $user_address = GuestAddress::query()->find($cart_delivery_address);
            $user_email = $user_address->email;
        } else {
            $user_id = auth()->guard("web")->user()->id;
            $user_address = Address::query()->find($cart_delivery_address);
            $user_email = auth()->guard("web")->user()->email;
        }
        $order_id = "10" . substr(time(), 0, -2);
        //Send Email
        $email = $this->send_email($user_email, $order_id, $user_type,$user_id);
        //Save Order
        $save_order = $this->save_order_user($user_id, $order_id, $request, $payment_id);
        //Save Delivery Address
        $save_delivery_address = $this->save_delivery_address($order_id, $user_id, $user_address);
        //Save Order items
        $save_order_items = $this->save_order_items($cart_items, $user_id, $order_id);
        //if success forgot Note, Discount code, Cart, and Options session
        Session::put("order_id", $order_id);
        //ob_end_clean();
        if (ob_get_length()) ob_end_clean();
    }

    public
    function save_order($user_id, $order_id, $request)
    {
        $order = new Order();
        $order->id = $order_id;
        $order->user_fk_id = $user_id;
        $order->sub_total = $request->sub_total;
        $order->coupons_fk_id = $request->coupons_fk_id;
        $order->discount = $request->discount;
        $order->discount_type = $request->discount_type;
        $order->delivery_charges = $request->delivery_charges;
        $order->total = $request->total;
        $order->note = $request->note;
        $order->payment_method = $request->payment_method;
        $order->order_address_fk_id = $request->order_address_fk_id;
        $order->user_type = $request->user_type;
        if ($request->payment_method == 0) {
            $order->payment_fk_id = $request->payment_fk_id;
            $order->payment_status = $request->payment_status;
        }
        $order->created_at = Carbon::now();
        $order->updated_at = Carbon::now();
        $order->save();
        return $order;
    }

    public function save_order_user($user_id, $order_id, $request, $payment_id)
    {
        $order = new Order();
        $order->id = $order_id;
        $order->user_fk_id = $user_id;
        $order->sub_total = $request["sub_total"];
        $order->coupons_fk_id = $request["coupons_fk_id"];
        $order->discount = $request["discount"];
        $order->delivery_charges = $request["delivery_charges"];
        $order->total = $request["total"];
        $order->note = $request["note"];
        $order->payment_method = $request["payment_method"];
        $order->order_address_fk_id = $request["order_address_fk_id"];
        $order->user_type = $request["user_type"];
        $order->payment_fk_id = $payment_id;
        $order->payment_status = $request["payment_status"];
        $order->created_at = Carbon::now();
        $order->updated_at = Carbon::now();
        $order->save();
        return $order;
    }

    public
    function save_delivery_address($order_id, $user_id, $user_address)
    {
        //$agent = new Agent();
        $delivery_address = new OrderDeliveryAddress();
        $delivery_address->user_fk_id = $user_id;
        $delivery_address->address_fk_id = $user_address->id;
        $delivery_address->order_fk_id = $order_id;
        $delivery_address->area_fk_id = $user_address->area_fk_id;
        $delivery_address->city_fk_id = $user_address->city_fk_id;
        $delivery_address->address_type_fk_id = $user_address->address_type_fk_id;
        $delivery_address->name = $user_address->name;
        $delivery_address->mobile = $user_address->mobile;
        $delivery_address->block = $user_address->block;
        $delivery_address->street = $user_address->street;
        $delivery_address->avenue = $user_address->avenue;
        $delivery_address->house = $user_address->house;
        $delivery_address->floor = $user_address->floor;
        $delivery_address->apartment = $user_address->apartment;
        $delivery_address->note = $user_address->note;
        $delivery_address->created_at = Carbon::now();
        $delivery_address->updated_at = Carbon::now();
        $delivery_address->save();
        return $delivery_address;
    }

    public
    function save_order_items($cart_items, $user_id, $order_id)
    {
        foreach (json_decode($cart_items) as $item) {
            $cart_item = Cart::query()->where("cart_key", $item->cart_key)->get()->first();
            $cart_options = $cart_item->options;
            $order_item = new OrderItems();
            $order_item->user_fk_id = $user_id;
            $order_item->product_fk_id = $cart_item->product_fk_id;
            $order_item->image = $cart_item->image;
            $order_item->name = $cart_item->name;
            $order_item->description = $cart_item->description;
            $order_item->order_fk_id = $order_id;
            $order_item->orders_items_key = $cart_item->cart_key;
            $order_item->quantity = $cart_item->quantity;
            $order_item->price = $cart_item->price;
            $order_item->created_at = Carbon::now();
            $order_item->updated_at = Carbon::now();
            $order_item->save();
            if ($order_item) {
                //Reduce quantity product
                $product = Product::query()->find($cart_item->product_fk_id);
                $product->quantity = $product->quantity - $cart_item->quantity;
                $product->save();
                //Save options
                $order_options = $this->save_order_options($order_item->id, $cart_options, $user_id, $order_id);
                $delete_cart_item = Cart::query()->find($cart_item->id)->delete();
            }
        }
        Session::forget("cart");
        return true;
    }

    public
    function save_order_options($orders_items_fk_id, $cart_options, $user_id, $order_id)
    {
        foreach (json_decode($cart_options) as $option) {
            $cart_option = CartOption::query()->where("cart_key", $option->cart_key)->where("option_fk_id", $option->option_fk_id)->get()->first();
            $order_option = new OrderOptions();
            $order_option->name = $cart_option->name;
            $order_option->option_fk_id = $cart_option->option_fk_id;
            $order_option->user_fk_id = $user_id;
            $order_option->order_fk_id = $order_id;
            $order_option->product_fk_id = $cart_option->product_fk_id;
            $order_option->orders_items_fk_id = $orders_items_fk_id;
            $order_option->cart_key = $cart_option->cart_key;
            $order_option->price = $cart_option->price;
            $order_option->created_at = Carbon::now();
            $order_option->updated_at = Carbon::now();
            $order_option->save();
            if ($order_option)
                $delete_order_option = CartOption::query()->find($cart_option->id)->delete();
        }
        Session::forget("cart_options");
        return true;
    }

    public
    function myfatoorah()
    {
        return view("myfatoorah");
    }

    public
    function paid(Request $request)
    {
        $payment = new OrderPayment();
        $payment->id = time();
        $user_id = "";
        if (auth()->guard("web")->user())
            $user_id = auth()->guard("web")->user()->id;
        else
            $user_id = Session::get("guest_id");
        $payment->user_fk_id = $user_id;
        $payment->payment_id = $request->paymentId;
        $payment->transaction_id = time();
        $payment->status = 1;
        $payment->created_at = Carbon::now();
        $payment->updated_at = Carbon::now();
        $payment->save();
        if ($payment) {
            Session::put("payment_id", $payment->id);
            if (Session::has("request_order")) {

                $request_order = Session::get("request_order");
                $place_order = $this->user_order($request_order, $payment->id);
            }
            return true;
        }
        return false;
    }

    public
    function done_paid(Request $request)
    {
        $paid = $this->paid($request);
        $payment_id = Session::get("payment_id");
        $order_id = Session::get("order_id");
        $order = Order::query()->find($order_id);
        $order_payment = OrderPayment::query()->find($payment_id);
        $request_order = Session::get("request_order");
        if (Session::has("request_order"))
            if ($request_order["user_type"] == 0)
                return view("cart-checkout-success", compact("order_payment", "order"));
            else
                return view("cart-checkout-success-confirm", compact("order_id"));
        return view("cart-checkout-error", compact("order_id"));
    }

    public
    function error_paid(Request $request)
    {
        return view("cart-checkout-error");
    }

    public
    function done(Request $request)
    {
        //when cash on delivery
        $order_id = Session::get("order_id");
        Session::forget("promo");
        Session::forget("cart_note");
        Session::forget("guest_id");
        Session::forget("guest_email");
        return view("cart-checkout-success-confirm", compact("order_id"));
    }


    public function send_email($user_email, $order_id, $user_type)
    {
        $link = env("APP_URL") . '/user/order/' . $order_id;
        $data = [
            'recipient' => $user_email,
            'fromEmail' => 'mmsss875@gmail.com',
            'fromName' => 'HajiKarak.com',
            'subject' => 'Successfully Payment',
            'body' => [$user_email, $link,$order_id],
        ];
        if ($user_type == 1)//guest
            Mail::send('admin.emails.email_payment_order_guest', $data, function ($message) use ($data) {
                $message->to($data['recipient'])
                    ->from($data['fromEmail'], $data['fromName'])
                    ->subject($data['subject']);
            });
        else
            Mail::send('admin.emails.email_payment_order', $data, function ($message) use ($data) {
                $message->to($data['recipient'])
                    ->from($data['fromEmail'], $data['fromName'])
                    ->subject($data['subject']);
            });
        //return 'Email sent Successfully';
        return response()->json(['success' => $link]);
        //return view("about");
    }

    function unique_code($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

    public
    function create()
    {
        //
    }

    public
    function store(Request $request)
    {
        //
    }

    public
    function show($id)
    {
        //
    }

    public
    function edit($id)
    {
        //
    }

    public
    function update(Request $request, $id)
    {
        //
    }

    public
    function destroy($id)
    {
        //
    }
}
