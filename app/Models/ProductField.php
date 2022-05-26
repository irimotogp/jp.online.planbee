<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductField extends Model
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
        'name'
    ];
    
    public function product_options() {
        return $this->belongsToMany(ProductOption::class, 'product_field_options');
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}
