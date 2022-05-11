<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\IntroducerType;

class Introducer extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sinsei_name',
        'sinsei_email',
        'introducer_type',
        'syoukai_id',
        'syoukai_name',
        'eva_id',
        'eva_name',
        'nth_type',
        'isd_type',
        'isd_id',
        'isd_name',
        'uuid',
        'created_at'
    ];

    public function agency() {
        return $this->hasMany(Agency::class);
    }

    public function customer() {
        return $this->hasMany(Customer::class);
    }

    public function getAccessUrl() {
        if($this->introducer_type == IntroducerType::AGENCY) {
            return config('app.url') . '/agency/' . $this->uuid;
        } elseif($this->introducer_type == IntroducerType::CUSTOMER) {
            return config('app.url') . '/customer/' . $this->uuid;
        }
        return false;
    }
}
