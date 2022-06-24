<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\IntroducerRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Enums\IntroducerType;
use App\Enums\NthType;
use App\Enums\ISDType;
use App\Enums\WEGType;

/**
 * Class IntroducerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class IntroducerCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Introducer::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/introducer');
        CRUD::setEntityNameStrings('', '登録紹介者');
        $this->crud->denyAccess(['show', 'create', 'delete', 'update']);
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
            'label'     => '登録申請者氏名',
            'type'      => 'text',
            'name'      => 'sinsei_name', 
        ]);
        $this->crud->addColumn([
            'label'     => '登録申請者メールアドレス',
            'type'      => 'text',
            'name'      => 'sinsei_email', 
        ]);
        $this->crud->addColumn([
            'label' => '店舗タイプ',
            'type' => 'select_from_array',
            'name' => 'introducer_type',
            'options' => \App\Enums\IntroducerType::getAllValues(),
        ]);
        $this->crud->addColumn([
            'label'     => '紹介取次店ID',
            'type'      => 'text',
            'name'      => 'syoukai_id', 
        ]);
        $this->crud->addColumn([
            'label'     => '紹介取次店名',
            'type'      => 'text',
            'name'      => 'syoukai_name', 
        ]);
        $this->crud->addColumn([
            'label'     => 'エバンジェリストID',
            'type'      => 'text',
            'name'      => 'eva_id', 
        ]);
        $this->crud->addColumn([
            'label'     => 'エバンジェリスト名',
            'type'      => 'text',
            'name'      => 'eva_name', 
        ]);
        $this->crud->addColumn([
            'label' => 'Nth人目',
            'type' => 'select_from_array',
            'name' => 'nth_type',
            'options' => \App\Enums\NthType::getAllValues(),
        ]);
        $this->crud->addColumn([
            'label' => '直上者指定',
            'type' => 'select_from_array',
            'name' => 'isd_type',
            'options' => \App\Enums\ISDType::getAllValues(),
        ]);
        $this->crud->addColumn([
            'label'     => '直上者ID',
            'type'      => 'text',
            'name'      => 'isd_id', 
        ]);
        $this->crud->addColumn([
            'label'     => '直上者名',
            'type'      => 'text',
            'name'      => 'isd_name', 
        ]);
        $this->crud->addColumn([
            'label' => 'ライン',
            'type' => 'select_from_array',
            'name' => 'direction_type',
            'options' => \App\Enums\DirectionType::getLabelAllValues(),
        ]);
        $this->crud->addColumn([
            'label' => '取付について',
            'type' => 'select_from_array',
            'name' => 'weg_type',
            'options' => \App\Enums\WEGType::getAllValues(),
        ]);
        $this->crud->addColumn([
            'label'     => '備考',
            'type'      => 'text',
            'name'      => 'note', 
        ]);
        $this->crud->addColumn([
            'label'     => 'UUID',
            'type'      => 'text',
            'name'      => 'uuid', 
        ]);
        $this->crud->addColumn([
            'label'     => '登録日時',
            'type'      => 'datetime',
            'name'      => 'created_at', 
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
        CRUD::setValidation(IntroducerRequest::class);

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
