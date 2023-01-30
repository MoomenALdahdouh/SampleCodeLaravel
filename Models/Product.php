<?php
/*TODO:: By Eng. Moomen Sameer Aldahdouh 0599124279, moomenaldahdouh@gmail.com*/
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    //use HasFactory;
    use HasTranslations;

    public $translatable = ['name', 'description'];
    protected $table = "products";
    protected $guarded = [];
    public $timestamps = false;

    public function meta()
    {
        return $this->hasOne(MetaTag::class, 'item_fk_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany(ProductCategories::class, 'product_fk_id', 'id');
    }

    public function discount()
    {
        return $this->hasOne(ProductDiscount::class, 'product_fk_id', 'id');
    }

    public function media()
    {
        return $this->hasMany(ProductMedia::class, 'product_fk_id', 'id');
    }

    public function options()
    {
        return $this->hasMany(ProductOptions::class, 'product_fk_id', 'id');
    }
}
