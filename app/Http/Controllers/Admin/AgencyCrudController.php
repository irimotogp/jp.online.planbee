<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AgencyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Enums\SexType;
use App\Enums\ContractType;
use App\Enums\DepositType;
use App\Enums\ShippingAddressType;

/**
 * Class AgencyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AgencyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Agency::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/agency');
        CRUD::setEntityNameStrings('', 'オンライン登録申請');
        $this->crud->denyAccess(['show', 'create', 'delete', 'update']);
        $this->crud->enableExportButtons();
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->disableResponsiveTable();
        $this->crud->addColumn([
            'label'     => '会員ID',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '主番号',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '枝番号',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '入会日',
            'type'      => 'text',
        ]);

        $this->crud->addColumn([
            'label'     => '会員名漢字',
            'type'      => 'text',
            'name'      => 'kanji'
        ]);
        $this->crud->addColumn([
            'label'     => '会員名ｶﾅ',
            'type'      => 'text',
            'name'      => 'kata'
        ]);
        $this->crud->addColumn([
            'label'     => 'ﾆｯｸﾈｰﾑ',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '表示区分',
            'type'      => 'text',
            'name'      => 'display_type'
        ]);

        $this->crud->addColumn([
            'label' => '性別',
            'type' => 'select_from_array',
            'name' => 'sex_type',
            'options' => \App\Enums\SexType::getAllValues(),
        ]);

        $this->crud->addColumn([
            'label'     => '生年月日',
            'type'      => 'date',
            'name'      => 'birthday',
            'format' => 'YYYY/MM/DD'
        ]);
        $this->crud->addColumn([
            'label'     => '郵便番号',
            'type'      => 'text',
            'name'      => 'zip1'
        ]);
        $this->crud->addColumn([
            'label'     => '都道府県',
            'type'      => 'text',
            'name'      => 'pref1'
        ]);
        $this->crud->addColumn([
            'label'     => '住所１',
            'type'      => 'text',
            'name'      => 'city1'
        ]);
        $this->crud->addColumn([
            'label'     => '住所２',
            'type'      => 'text',
            'name'      => 'addr1'
        ]);

        $this->crud->addColumn([
            'label'     => '電話番号',
            'type'      => 'text',
            'name'      => 'home_phone'
        ]);
        $this->crud->addColumn([
            'label'     => 'FAX番号',
            'type'      => 'text',
            'name'      => 'fax'
        ]);
        $this->crud->addColumn([
            'label'     => '携帯電話',
            'type'      => 'text',
            'name'      => 'mobile_phone'
        ]);
        $this->crud->addColumn([
            'label'     => '携帯番号2',
            'type'      => 'text',
            'name'      => 'mobile_phone2'
        ]);
        $this->crud->addColumn([
            'label'     => 'ﾒｰﾙPC',
            'type'      => 'text',
            'name'      => 'sinsei_email'
        ]);
        $this->crud->addColumn([
            'label'     => 'ﾒｰﾙ携帯',
            'type'      => 'text',
            'name'      => 'phone_email'
        ]);
        $this->crud->addColumn([
            'label'     => 'WEBID',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => 'WEBﾊﾟｽﾜｰﾄﾞ',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '勤務先',
            'type'      => 'text',
            'name'      => 'work_place_name'
        ]);

        $this->crud->addColumn([
            'label' => '発送先指定',
            'type' => 'select_from_array',
            'name' => 'shipping_address_type',
            'options' => \App\Enums\ShippingAddressType::getAllValues(),
        ]);
        $this->crud->addColumn([
            'label'     => 'H郵便番号',
            'type'      => 'text',
            'name'      => 'zip2'
        ]);
        $this->crud->addColumn([
            'label'     => 'H住所1',
            'type'      => 'text',
            'name'      => 'city2'
        ]);
        $this->crud->addColumn([
            'label'     => 'H住所2',
            'type'      => 'text',
            'name'      => 'addr2'
        ]);

        $this->crud->addColumn([
            'label'     => 'H宛名',
            'type'      => 'text',
            'name'      => 'receiver_name'
        ]);
        $this->crud->addColumn([
            'label'     => 'H電話番号',
            'type'      => 'text',
            'name'      => 'receiver_phone'
        ]);
        $this->crud->addColumn([
            'label'     => 'H携帯番号',
            'type'      => 'text',
        ]);

        $this->crud->addColumn([
            'label'     => 'ｶｰﾄﾞ会社',
            'type'      => 'text',
            'name'      => 'receiver_phone'
        ]);

        $this->crud->addColumn([
            'label' => 'ｶｰﾄﾞ会社',
            'type' => 'select_from_array',
            'name' => 'card_company_type',
            'options' => \App\Enums\CardCompanyType::getAllValues(),
        ]);
        $this->crud->addColumn([
            'label'     => 'ｶｰﾄﾞ番号',
            'type'      => 'text',
            'name'      => 'card_number'
        ]);
        $this->crud->addColumn([
            'label'     => 'ｶｰﾄﾞ名義',
            'type'      => 'text',
            'name'      => 'card_name'
        ]);
        $this->crud->addColumn([
            'label'     => '有効期限',
            'type'      => 'text',
            'name'      => 'expiration_date'
        ]);
        $this->crud->addColumn([
            'label'     => '会員区分',
            'type'      => 'text',
            'name'      => 'introducer_type'
        ]);
        $this->crud->addColumn([
            'label'     => 'CPN区分',
            'type'      => 'text',
        ]);

        $this->crud->addColumn([
            'label'     => '紹介者ID',
            'type'      => 'text',
            'name'      => 'syoukai_id'
        ]);
        $this->crud->addColumn([
            'label'     => '紹介者名',
            'type'      => 'text',
            'name'      => 'syoukai_name'
        ]);
        $this->crud->addColumn([
            'label'     => 'SUｻﾎﾟｰﾀｰID',
            'type'      => 'text',
            'name'      => 'eva_id'
        ]);
        $this->crud->addColumn([
            'label'     => 'SUｻﾎﾟｰﾀｰ名',
            'type'      => 'text',
            'name'      => 'eva_name'
        ]);
        $this->crud->addColumn([
            'label'     => '直上者ID',
            'type'      => 'text',
            'name'      => 'isd_id_text'
        ]);
        $this->crud->addColumn([
            'label'     => '直上者名',
            'type'      => 'text',
            'name'      => 'isd_name_text'
        ]);

        $this->crud->addColumn([
            'label'     => 'ﾗｲﾝ',
            'type'      => 'text',
            'name'      => 'line_text'
        ]);
        $this->crud->addColumn([
            'label'     => '位置指定',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '指定者ID',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => 'ﾀｲﾄﾙ',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '昇格日',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '資格区分',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '昇格区分',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '書類到着日',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '初回売上日',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '初回入金法',
            'type'      => 'text',
        ]);

        $this->crud->addColumn([
            'label' => '購入ｺｰｽ',
            'type' => 'select',
            'name' => 'product_id',
            'attribute' => 'contract_type_text',
            'key' => 'contract_type_text',
            'entity' => 'product',
            'model' => "App\Models\Product",
        ]);
        $this->crud->addColumn([
            'label'     => '継続入金法',
            'type'      => 'text',
            'name'      => 'continue_payment_law_text'
        ]);
        $this->crud->addColumn([
            'label'     => 'BN相殺',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label' => '購入商品1',
            'type'  => 'select',
            'name' => 'product_id',
            'attribute' => 'display_name',
            'key' => 'display_name',
            'entity' => 'product',
            'model' => "App\Models\Product",
        ]);
        $this->crud->addColumn([
            'label'     => '購入個数1',
            'type'      => 'text',
            'name'      => 'product_buy_num_text'
        ]);
        $this->crud->addColumn([
            'label'     => '購入商品2',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '購入個数2',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '購入商品3',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '購入個数3',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '購入商品4',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '購入個数4',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '購入商品5',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '購入個数5',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '購入商品6',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '購入個数6',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '通知発行',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '退会日',
            'type'      => 'text',
        ]);

        $this->crud->addColumn([
            'label'     => '銀行ｺｰﾄﾞ',
            'type'      => 'text',
            'name'      => 'bank_code'
        ]);
        $this->crud->addColumn([
            'label'     => '支店ｺｰﾄﾞ',
            'type'      => 'text',
            'name'      => 'branch_code'
        ]);
        $this->crud->addColumn([
            'label'     => '銀行名',
            'type'      => 'text',
            'name'      => 'bank_name'
        ]);
        $this->crud->addColumn([
            'label'     => '支店名',
            'type'      => 'text',
            'name'      => 'branch_name'
        ]);
        
        $this->crud->addColumn([
            'label'     => '預金種目',
            'type'      => 'select',
            'name'      => 'deposit_id',
            'attribute' => 'name',
            'entity'    => 'deposit',
            'model'     => "App\Models\Deposit",
        ]);
        $this->crud->addColumn([
            'label'     => '口座番号',
            'type'      => 'text',
            'name'      => 'account_number'
        ]);
        
        $this->crud->addColumn([
            'label'     => '口座名義（ｶﾅ）',
            'type'      => 'text',
            'name'      => 'account_name'
        ]);
        $this->crud->addColumn([
            'label'     => '名義漢字',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '製造番号',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '汎用2',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '備考',
            'type'      => 'text',
            'name'      => 'custom_note',
            'limit' => 1000,
            'escaped'   => false,
        ]);
        $this->crud->addColumn([
            'label'     => '備考',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '郵便番号',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '都道府県',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label'     => '住所1',
            'type'      => 'text',
        ]);
        $this->crud->addColumn([
            'label' => "本人確認書類",
            'name' => "identity_doc",
            'type' => 'image',
        ]);
        $this->crud->addColumn([
            'label' => "本人確認書類",
            'name' => "identity_doc2",
            'type' => 'image',
        ]);
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(AgencyRequest::class);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
