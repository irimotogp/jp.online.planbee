<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
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
        'code',
        'product_name',
        'display_name',
        'introducer_type',
        'cashback'
    ];

    protected $appends = [
        'cashback_text',
    ];

    public function agency() {
        return $this->hasMany(Agency::class);
    }

    public function getCashBackTextAttribute() {
        return $this->cashback ? 'ON' : 'OFF';
    }
}
