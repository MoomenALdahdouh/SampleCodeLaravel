$(function () {
    const sub_total_tr = $("#sub_total"),
        total_tr = $("#total"),
        carts = $("#carts_item"),
        place_order_button = $("#place_order"),
        discount_tr = $("#discount"),
        promo_id = $("#promo_id").val(),
        app_url = $("#app_url").val(),
        note = $("#note_order").val(),
        areas = $(".areas"),
        language = $('#language').val(),
        cities_area_select = $(".cities_area"),
        radio_address = $(".radio_address "),
        delivery_charges_tr = $("#delivery_charges"),
        cart_options = $("#cart_options").val(),
        errors = $(".errors"),
        cart_size = $("#cart_size"),
        cart_empty_error = $("#cart_empty_error"),
        total_error = $("#total_error");

    let discount_value = 0,
        discount_type = 1,//fixed
        promo_value = 0,//fixed
        total_value = 0,
        delivery_charges_value = 0,
        sub_total_value = 0,
        area_id = 0,
        city_id = 0,
        cart_items = carts.val(),
        options_value = 0,
        radio_address_checked = 0;

    $(document).ready(function () {
        if (parseInt(cart_size.val()) > 0) {
            discount();
            sub_total();
            cities_area();
            delivery_charges();
            delivery_address_charges();
            total();
            place_order();
        } else {
            window.location.replace(app_url + "/categories");
            cart_empty_error.html(language == "en" ? "Your Cart it's Empty!, Please add some product" : "عربة التسوق الخاصة بك فارغة !، الرجاء إضافة بعض المنتجات");
            return;
        }

    });

    function place_order() {
        place_order_button.click(function () {
            place_order_button.disabled = true;
            //Show myfatoorah modal and paid
            errors.html("");
            const payment_method = $('input[name="flexRadioDefaultPayment"]:checked').val(),
                order_address_fk_id = $('input[name="flexRadioDefault"]:checked').val();
            if (parseFloat(total_value) > 0) {
                if (payment_method == 0) {
                    //Show loading animation
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "get",
                        url: app_url + "/myfatoorah/pay",
                        data: {
                            user_data: order_address_fk_id,
                            sub_total: sub_total_value,
                            coupons_fk_id: promo_id,
                            discount: discount_value,
                            delivery_charges: delivery_charges_value,
                            total: total_value,
                            note: note,
                            payment_method: payment_method,
                            order_address_fk_id: order_address_fk_id,
                            cart_items: cart_items,
                            cart_options: cart_options,
                            status: 0,
                            user_type: 0,
                            payment_fk_id: "",
                            payment_status: 1,
                        },
                        success: function (response) {
                            if ($.isEmptyObject(response.error)) {
                                const payment_data = response["Data"],
                                    is_success = response["IsSuccess"],
                                    payment_message = response["Message"],
                                    payment_validation_error = response["ValidationErrors"];
                                const payment_data_customer = payment_data["CustomerReference"],
                                    invoice_id = payment_data["InvoiceId"],
                                    invoice_url = payment_data["InvoiceURL"],
                                    user_defined_field = payment_data["UserDefinedField"];
                                if (is_success == true) {
                                    window.location.replace(invoice_url);
                                } else {
                                    window.location.replace(app_url + "/checkout/error_paid");
                                }
                                //Hide loading animation
                                //get response paid paymentId
                                //const payment_fk_id = response["success"];
                                //Place order
                                /*                                $.ajax({
                                                                    headers: {
                                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                    },
                                                                    type: "POST",
                                                                    url: app_url + "/checkout/order",
                                                                    data: {
                                                                        sub_total: sub_total_value,
                                                                        coupons_fk_id: promo_id,
                                                                        discount: promo_value,
                                                                        discount_type: discount_type,
                                                                        delivery_charges: delivery_charges_value,
                                                                        total: total_value,
                                                                        note: note,
                                                                        payment_method: payment_method,
                                                                        order_address_fk_id: order_address_fk_id,
                                                                        cart_items: cart_items,
                                                                        cart_options: cart_options,
                                                                        status: 0,
                                                                        user_type: 0,
                                                                        payment_fk_id: payment_fk_id,
                                                                        payment_status: 1,
                                                                    },
                                                                    success: function (response) {
                                                                        if ($.isEmptyObject(response.error)) {

                                                                        } else {
                                                                            place_order_button.disabled = false;
                                                                            print_error(response.error);
                                                                        }
                                                                    }
                                                                });*/
                            } else {
                                place_order_button.disabled = false;
                                print_error(response.error);
                            }
                        }
                    });
                } else {//Cash on delivery
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: app_url + "/checkout/order",
                        data: {
                            sub_total: sub_total_value,
                            coupons_fk_id: promo_id,
                            discount: promo_value,
                            discount_type: discount_type,
                            delivery_charges: delivery_charges_value,
                            total: total_value,
                            note: note,
                            payment_method: payment_method,
                            order_address_fk_id: order_address_fk_id,
                            cart_items: cart_items,
                            cart_options: cart_options,
                            status: 0,
                            user_type: 0,
                        },
                        success: function (response) {
                            if ($.isEmptyObject(response.error)) {
                                $("#cart_icon").html("")
                                window.location.replace(app_url + "/checkout/done");
                            } else {
                                print_error(response.error);
                            }
                        }
                    });
                }
            } else
                total_error.html("Your cart it's empty, place some orders!");

        });
    }

    function options(cart_key, quantity) {
        options_value = 0;
        $.each(JSON.parse(cart_options), function (index, value) {
            let price = value["price"];
            let option_cart_key = value["cart_key"];
            let product_id = value["product_fk_id"];
            if (cart_key == option_cart_key) {
                options_value = parseFloat(options_value) + (parseFloat(price) * quantity);
            }
        });
        return parseFloat(options_value);
    }

    function total() {
        total_value = 0;
        total_value = (sub_total_value + delivery_charges_value) - discount_value;
        total_value = parseFloat(total_value);
        total_tr.html(total_value + " KD");
        return total_value;
    }

    function sub_total() {
        sub_total_value = 0;
        $.each(JSON.parse(cart_items), function (index, value) {
            const item = value;
            let quantity = item["quantity"];
            let price = item["price"];
            let product_id = item["product_fk_id"];
            let cart_key = item["cart_key"];
            sub_total_value = sub_total_value + ((quantity * price) + options(cart_key, quantity));
            sub_total_value = parseFloat(sub_total_value);
        });
        sub_total_tr.html(sub_total_value + " KD");
        return sub_total_value;
    }

    function discount() {
        discount_value = 0;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: app_url + "/checkout/discount/promo/" + promo_id,
            success: function (response) {
                if (response.success) {
                    let promo = response.success;
                    let type = " KD";
                    discount_value = parseFloat(promo.value);
                    discount_type = promo.type;
                    promo_value = promo.value;
                    if (discount_type == 0) {//Percentage
                        discount_value = sub_total() * (parseFloat(promo.value) / 100);
                        type = " %";
                    }
                    discount_tr.html(promo.value + type);
                    total();
                } else {
                    discount_tr.html(0 + " KD");
                }
            }
        });
    }

    function cities_area() {
        areas.on("change", (function (t) {
            area_id = t.target.value;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: app_url + "/checkout/cities_area/" + area_id,
                success: function (response) {
                    cities_area_select.html(response);
                }
            });
        }));
    }

    function delivery_charges() {
        cities_area_select.on("change", (function (t) {
            if (radio_address_checked === 0) {
                delivery_charges_value = 0;
                city_id = t.target.value;
                city_price(city_id);
            }
        }));
    }

    function delivery_address_charges() {
        radio_address.click(function () {
            radio_address_checked = 1;
            delivery_charges_value = 0;
            city_id = $(this).data("id");
            city_price(city_id);
        });
    }

    function city_price(city_id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: app_url + "/checkout/city/" + city_id,
            success: function (response) {
                delivery_charges_value = parseFloat(response);
                delivery_charges_tr.html(delivery_charges_value + " KD");
                total();
            }
        });
    }

    function print_error(errors) {
        $.each(errors, function (index, val) {
            $("#" + index + "_error").html(val);
            $("#" + index).focus();
        });
    }

});
