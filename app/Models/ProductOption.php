<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'price',
    ];

    protected $appends = [
        'name_price',
    ];

    public function agency() {
        return $this->hasMany(Agency::class);
    }
    
    public function product_fields() {
        return $this->belongsToMany(ProductField::class, 'product_field_options');
    }
    
    public function agencies() {
        return $this->belongsToMany(Agency::class, 'agency_product_options');
    }
    
    public function customers() {
        return $this->belongsToMany(Customer::class, 'customer_product_options');
    }

    public function getNamePriceAttribute() {
        return $this->price > 0 ? 
            $this->name . "　" . $this->price . "円" : 
            $this->name . "　" . "無料";
    }
}
