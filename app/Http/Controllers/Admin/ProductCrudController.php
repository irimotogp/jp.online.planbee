<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Enums\ContractType;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('', '商品');
        $this->crud->denyAccess(['show']);
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
            'label'     => 'CODE',
            'type'      => 'text',
            'name'      => 'code', 
        ]);
        $this->crud->addColumn([
            'label'     => '商品名',
            'type'      => 'text',
            'name'      => 'product_name', 
        ]);
        $this->crud->addColumn([
            'label'     => '表示名',
            'type'      => 'text',
            'name'      => 'display_name', 
        ]);
        $this->crud->addColumn([
            'label' => '購入コース',
            'type' => 'select_from_array',
            'name' => 'contract_type',
            'options' => \App\Enums\ContractType::getPurchaseOptions(),
        ]);
        $this->crud->addColumn([
            'label'     => 'キャッシュバック対象',
            'type'      => 'text',
            'name'      => 'cashback_text', 
        ]);
        $this->crud->addColumn([
            'label' => '店舗タイプ',
            'type' => 'select_from_array',
            'name' => 'introducer_type',
            'options' => \App\Enums\IntroducerType::getAllValues(),
        ]);
        $this->crud->addColumn([
            'label' => '分野',
            'type' => 'select',
            'name' => 'product_field_id',
            'attribute' => 'name',
            'entity' => 'product_Field',
            'model' => "App\Models\ProductField",
        ]);
        $this->crud->addColumn([
            'label'     => '初期費用',
            'type'      => 'text',
            'name'      => 'initial_price', 
        ]);
        $this->crud->addColumn([
            'label'     => '月額料',
            'type'      => 'text',
            'name'      => 'month_price', 
        ]);

    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);

        $this->crud->addField([
            'label'     => 'CODE',
            'type'      => 'text',
            'name'      => 'code', 
        ]);
        $this->crud->addField([
            'label'     => '商品名',
            'type'      => 'text',
            'name'      => 'product_name', 
        ]);
        $this->crud->addField([
            'label'     => '表示名',
            'type'      => 'text',
            'name'      => 'display_name', 
        ]);
        $this->crud->addField([
            'label' => '購入コース',
            'type' => 'select_from_array',
            'name' => 'contract_type',
            'options' => \App\Enums\ContractType::getPurchaseOptions(),
        ]);
        $this->crud->addField([
            'label'     => 'キャッシュバック対象',
            'type'      => 'checkbox',
            'name'      => 'cashback', 
        ]);
        $this->crud->addField([
            'label' => '店舗タイプ',
            'type' => 'select_from_array',
            'name' => 'introducer_type',
            'options' => \App\Enums\IntroducerType::getAllValues(),
        ]);
        $this->crud->addField([
            'label' => '分野',
            'type' => 'select',
            'name' => 'product_field_id',
            'attribute' => 'name',
            'entity' => 'product_Field',
            'model' => "App\Models\ProductField",
        ]);
        $this->crud->addField([
            'label'     => '初期費用',
            'type'      => 'text',
            'name'      => 'initial_price', 
        ]);
        $this->crud->addField([
            'label'     => '月額料',
            'type'      => 'text',
            'name'      => 'month_price', 
        ]);
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
