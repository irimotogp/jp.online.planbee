<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PrivacyRequest;
use App\Http\Controllers\Admin\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PrivacyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PrivacyCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Privacy::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/privacy');
        CRUD::setEntityNameStrings('', '重要事項確認');
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
            'label' => 'タイプ',
            'type' => 'select_from_array',
            'name' => 'introducer_type',
            'options' => \App\Enums\IntroducerType::getAllValues(),
        ]);
        $this->crud->addColumn([
            'label'     => 'タイトル',
            'type'      => 'text',
            'name'      => 'title', 
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
        CRUD::setValidation(PrivacyRequest::class);

        $this->crud->addField([
            'label' => 'タイプ',
            'type' => 'select_from_array',
            'name' => 'introducer_type',
            'options' => \App\Enums\IntroducerType::getAllValues(),
        ]);
        $this->crud->addField([
            'label'     => 'タイトル',
            'type'      => 'text',
            'name'      => 'title', 
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
