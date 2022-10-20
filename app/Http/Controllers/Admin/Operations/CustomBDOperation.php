<?php

namespace App\Http\Controllers\Admin\Operations;

use Illuminate\Support\Facades\Route;

trait CustomBDOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupCustomBDRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/custombd', [
            'as'        => $routeName.'.custombd',
            'uses'      => $controller.'@custombd',
            'operation' => 'custombd',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupCustomBDDefaults()
    {
        $this->crud->allowAccess('custombd');

        $this->crud->operation('custombd', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });

        $this->crud->operation('list', function () {
            $this->crud->addButton('bottom', 'custombd', 'view', 'crud::buttons.custombd');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function custombd()
    {
        $this->crud->hasAccessOrFail('custombd');

        $entries = request()->input('entries', []);
        $class = get_class($this->crud->model);
        $instance = new $class();
        $deletedEntriesCount=$instance::destroy($entries);
        return $deletedEntriesCount;
    }
}
