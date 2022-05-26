<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\ContractType;

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
        'cashback',
        'contract_type',
        'introducer_type',
        'product_field_id',
        'initial_price',
        'month_price',
    ];

    protected $appends = [
        'cashback_text',
        'product_field_option_ids',
        'contract_type_text'
    ];

    public function agency() {
        return $this->hasMany(Agency::class);
    }

    public function getCashBackTextAttribute() {
        return $this->cashback ? 'ON' : 'OFF';
    }
    
    public function product_field() {
        return $this->belongsTo(ProductField::class);
    }

    public function getProductFieldOptionIdsAttribute() {
        return $this->product_field->product_options->pluck('id');
    }

    public function getContractTypeTextAttribute() {
        return ContractType::getPurchaseOptions()[$this->contract_type];
    }
}
