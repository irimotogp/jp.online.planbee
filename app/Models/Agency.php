<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Enums\SexType;
use App\Enums\DesireContacType;
use App\Enums\DesireDateTimeType;
use App\Enums\BasicFeeType;
use App\Enums\CommercialPrivacyType;
use App\Enums\DirectionType;
use App\Enums\MonthlyPaymentType;
use App\Enums\PaymentNumberType;

class Agency extends Model
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
        
        'sex_type',
        
        'kanji_sei',
        'kanji_mei',
        'kata_sei',
        'kata_mei',

        'corp_kanji',
        'corp_kata',
        'rep_kanji_sei',
        'rep_kanji_mei',
        'rep_kata_sei',
        'rep_kata_mei',

        'birthday',
        'zip1',
        'pref1',
        'city1',
        'addr1',

        'home_phone',
        'fax',
        'mobile_phone',
        'mobile_phone2',

        'sinsei_email',
        'phone_email',
        'work_place_name',
        'work_place_phone',
        
        'contract_type',

        'syoukai_id',
        'syoukai_name',
        'eva_id',
        'eva_name',

        'shipping_address_type',

        'zip2',
        'pref2',
        'city2',
        'addr2',

        'receiver_name',
        'receiver_phone',

        'initial_payment_type', 
        'payment_number_type',
        'card_company_type',
        'card_number',
        'card_name',
        'expiration_date',

        'monthly_payment_type',

        'product_id',
        
        'bank_name',
        'bank_code',
        'branch_name',
        'branch_code',

        'deposit_id',
         
        'account_number',
        'account_name',
        'identity_doc',
        'identity_doc2',

        'desire_month',
        'desire_contact_type',
        'desire_datetime_type',
        'desire_auth_month',
        'desire_auth_day',
        'desire_start_h',
        'desire_start_m',
        'desire_end_h',
        'desire_end_m',

        'product_option_id',
        'basic_fee_type',
        'initial_price',
        'month_price',

        'commercial_privacy_type',

        'note'
    ];
    
    protected $appends = [
        'kanji',
        'kata',
        'display_type',
        'introducer_type',
        'isd_name_text',
        'product_buy_num_text',
        'identity_doc_url',
        'identity_doc2_url',
        'custom_note',
        'work_place',
        'direction_type_text'
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

    public function product_options() {
        return $this->belongsToMany(ProductOption::class, 'agency_product_options');
    }
    
    public function shipping_address() {
        return $this->belongsTo(ShippingAddress::class);
    }
    
    public function getKanjiAttribute() {
        if($this->sex_type != SexType::CORPORATION) {
            return $this->kanji_sei . " " .  $this->kanji_mei;
        } else {
            return $this->corp_kanji . $this->rep_kanji_sei .  $this->rep_kanji_mei;
        }
    }
    
    public function getKataAttribute() {
        if($this->sex_type != SexType::CORPORATION) {
            return $this->kata_sei . " " .  $this->kata_mei;
        } else {
            return $this->corp_kata . $this->rep_kata_sei .  $this->rep_kata_mei;
        }
    }

    public function getCustomNoteAttribute() {
        $text = "送信日時: " . $this->created_at->format('Y/m/d H:i:s');
        if($this->payment_number_type) {
            $payment_number_type_text = PaymentNumberType::getAllValues()[$this->payment_number_type];
            $text .= "<br>支払回数: {$payment_number_type_text}";
        }
        $text .= "<br>希望登録月: {$this->desire_month}月";
        if($this->desire_contact_type) {
            $desire_contact_type_text = DesireContacType::getAllValues()[$this->desire_contact_type];
            $text .= "<br>本人確認の希望連絡先: {$desire_contact_type_text}";
        }
        if($this->desire_datetime_type == DesireDateTimeType::ALL) {
            $desire_datetime_type_text = DesireDateTimeType::getAllValues()[$this->desire_datetime_type];
            $text .= "<br>希望日時: {$desire_datetime_type_text}";
        } else {
            $text .= "<br>希望日時: {$this->desire_auth_month}月{$this->desire_auth_day}日 {$this->desire_start_h}時{$this->desire_start_m}分" . " ~ " . 
                "{$this->desire_end_h}時{$this->desire_end_m}分";
        }
        if(count($this->product_options) > 0) {
            $text .="<br>オプション品: <br>・";
            $text .= $this->product_options->implode('name_price', '<br>・');
        }
        if($this->basic_fee_type) {
            $basic_fee_type = BasicFeeType::getAllValues()[$this->basic_fee_type];
            $text .= "<br>基本取付工賃: {$basic_fee_type}";
        }
        if($this->commercial_privacy_type) {
            $commercial_privacy_type = CommercialPrivacyType::getAllValues()[$this->commercial_privacy_type];
            $text .= "<br>概要書面の交付: {$commercial_privacy_type}";
        }
        if($this->note) {
            $text .= "<br>備考（通信欄）: {$this->note}";
        }
        return $text;
    }
    
    public function getIntroducerTypeAttribute() {
        return "取次店";
    }

    public function getDisplayTypeAttribute() {
        return "通常表示";
    }

    public function getProductBuyNumTextAttribute() {
        return "1";
    }

    public function getWorkPlaceAttribute() {
        if($this->work_place_name || $this->work_place_phone) {
            return $this->work_place_name . "_" . $this->work_place_phone;
        }
        return "";
    }

    public function getDirectionTypeTextAttribute() {
        if($direction_type = $this->introducer->direction_type) {
            return DirectionType::getLabelAllValues()[$direction_type];
        }
        return null;
    }

    public function getIdentityDocUrlAttribute() {
        return $this->getImage($this->identity_doc);
    }

    public function getIdentityDoc2UrlAttribute($value) {
        return $this->getImage($this->identity_doc2);
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
            config('app.url') . '/' . config('filesystems.image_upload_path') . '/none.jpg';
    }

    public function setImage($attribute_name, $file_str)
    {
        // or use your own disk, defined in config/file_strsystems.php
        $disk = config('backpack.base.root_disk_name');
        // destination path relative to the disk above
        $destination_path = 'public/' . config('filesystems.image_upload_path');

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
