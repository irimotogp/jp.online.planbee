<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductFieldRequest;
use App\Http\Controllers\Admin\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductFieldCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductFieldCrudController extends CrudController
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
        parent::setup();
        CRUD::setModel(\App\Models\ProductField::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product-field');
        CRUD::setEntityNameStrings('', '分野');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        parent::setupListOperation();
        $this->crud->addColumn([
            'label'     => '分野名',
            'type'      => 'text',
            'name'      => 'name'
        ]);
        $this->crud->addColumn([
            'label'     => '分野リスト',
            'type'      => 'relationship',
            'name'      => 'product_options',
            'entity'    => 'product_options',
            'attribute' => 'name',
            'model'     => "App\Models\ProductOption",
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
        CRUD::setValidation(ProductFieldRequest::class);

        $this->crud->addField([
            'label'     => '分野名',
            'type'      => 'text',
            'name'      => 'name'
        ]);
        $this->crud->addField([
            'label'     => '分野リスト',
            'type'      => 'relationship',
            'name'      => 'product_options',
            'entity'    => 'product_options',
            'attribute' => 'name',
            'model'     => "App\Models\ProductOption",
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
