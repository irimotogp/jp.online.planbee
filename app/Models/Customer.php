<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
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
        'introducer_id',
        'kanji_sei',
        'kanji_mei',
        'kata_sei',
        'kata_mei',
        'sex_type',
        'birthday',
        'zip1',
        'pref1',
        'city1',
        'addr1',
        'home_phone',
        'fax',
        'mobile_phone',
        'mobile_phone2',
        'pc_email',
        'phone_email',
        'work_place_name',
        'shipping_address_id',
        'zip2',
        'pref2',
        'city2',
        'addr2',
        'receiver_name',
        'receiver_phone',
        'contract_type',
        'product_id',
        'bank_name',
        'bank_code',
        'branch_name',
        'branch_code',
        'deposit_id',
        'account_number',
        'identity_doc',
        'identity_doc2',
    ];
    
    protected $appends = [
        'kanji',
        'kata',
        'introducer_type',
        'syoukai_id_text',
        'syoukai_name_text',
        'eva_id_text',
        'eva_name_text',
        'isd_id_text',
        'isd_name_text',
    ];
    
    public function introducer() {
        return $this->belongsTo(Introducer::class);
    }
    
    public function deposit() {
        return $this->belongsTo(Deposit::class);
    }
    
    public function product() {
        return $this->belongsTo(Product::class);
    }
    
    public function shipping_address() {
        return $this->belongsTo(ShippingAddress::class);
    }
    
    public function getKanjiAttribute($value) {
        return $this->kanji_sei . " " .  $this->kanji_mei;
    }
    
    public function getKataAttribute($value) {
        return $this->kata_sei . " " .  $this->kata_mei;
    }
    
    public function getIntroducerTypeAttribute($value) {
        return "取次店";
    }

    public function getIdentityDocAttribute($value) {
        return $this->getImage($value);
    }

    public function getIdentityDoc2Attribute($value) {
        return $this->getImage($value);
    }

    public function getSyoukaiIdTextAttribute($value) {
        return $this->introducer->syoukai_id;
    }

    public function getSyoukaiNameTextAttribute($value) {
        return $this->introducer->syoukai_name;
    }

    public function getEvaIdTextAttribute($value) {
        return $this->introducer->eva_id;
    }

    public function getEvaNameTextAttribute($value) {
        return $this->introducer->eva_name;
    }

    public function setIdentityDocAttribute($value) {
        $this->setImage('identity_doc', $value);
    }

    public function setIdentityDoc2Attribute($value) {
        $this->setImage('identity_doc2', $value);
    }
    
    public function getImage($value) 
    {
        return $value ?
            config('app.url') . '/' . $value :
            config('app.url') . '/' . config('values.image_upload_path') . '/none.jpg';
    }

    public function setImage($attribute_name, $file_str)
    {
        // or use your own disk, defined in config/file_strsystems.php
        $disk = config('backpack.base.root_disk_name');
        // destination path relative to the disk above
        $destination_path = 'public/' . config('values.image_upload_path');

        // if the image was erased
        if ($file_str==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (Str::startsWith($file_str, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($file_str);

            // 1. Generate a filename.
            $filename = $attribute_name . time().'.' . explode('/', explode(':', substr($file_str, 0, strpos($file_str, ';')))[1])[1];
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

            // 3. Delete the previous image, if there was one.
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // 4. Save the public path to the database
            // but first, remove "public/" from the path, since we're pointing to it
            // from the root folder; that way, what gets saved in the db
            // is the public URL (everything that comes after the domain name)
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = $public_destination_path.'/'.$filename;
        }
    }
}
