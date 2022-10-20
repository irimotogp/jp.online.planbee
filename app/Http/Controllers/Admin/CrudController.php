<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController as BasicCrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class CrudController extends BasicCrudController
{
    use \App\Http\Controllers\Admin\Operations\CustomBDOperation;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        if(backpack_user()->hasRole('super')) :
            $this->crud->denyAccess(['show']);
        else :
            $this->crud->denyAccess(['show', 'create', 'delete', 'update']);
        endif;
    }

    
    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if(backpack_user()->hasRole('super')) :
            $this->crud->enableBulkActions();
            $this->crud->addColumn([
                'type'           => 'checkbox',
                'name'           => 'bulk_actions',
                'label'          => ' <input type="checkbox" class="crud_bulk_actions_main_checkbox" style="width: 16px; height: 16px;" />',
                'priority'       => 1,
                'searchLogic'    => false,
                'orderable'      => false,
                'visibleInModal' => false,
            ])->makeFirstColumn();
        else :
            $this->crud->removeAllButtons();
        endif;
    }
    
    // protected function setupCustomBulkDeleteDefaults()
    // {
    //     $this->crud->operation('customBulkDelete', function () {
    //         $this->crud->loadDefaultOperationSettingsFromConfig();
    //     });

    //     $this->crud->operation('list', function () {
    //         $this->crud->addButton('bottom', 'customBulkDelete', 'view', 'crud::buttons.customBulkDelete');
    //     });
    // }

    // protected function setupCustomBulkDeleteRoutes($segment, $routeName, $controller)
    // {
    //     Route::delete($segment.'/{id}/customBulkDelete', [
    //         'as'        => $routeName.'.customBulkDelete',
    //         'uses'      => $controller.'@customBulkDelete',
    //         'operation' => 'customBulkDelete',
    //     ]);
    // }

    // public function customBulkDelete() {
    //     $this->crud->hasAccessOrFail('custombd');

    //     $entries = request()->input('entries', []);
    //     $deletedEntries = [];

    //     foreach ($entries as $key => $id) {
    //         if ($entry = $this->crud->model->find($id)) {
    //             $deletedEntries[] = $entry->delete();
    //         }
    //     }

    //     return $deletedEntries;
    // }

}
