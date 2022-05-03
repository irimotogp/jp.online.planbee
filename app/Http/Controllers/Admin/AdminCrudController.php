<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Store;
use App\Models\User;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AdminCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/admin');
        CRUD::setEntityNameStrings('', 'ユーザー');
        $this->crud->denyAccess('show');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $user = backpack_user();

        $this->crud->addColumn([
            'label'     => 'プロフィール画像',
            'name'      => 'image', 
            'type'      => 'image',
        ]);

        $this->crud->addColumn([
            'label' => '名前111',
            'type' => 'text',
            'name' => 'name'
        ]);

        $this->crud->addColumn([
            'label' => '名前',
            'type' => 'text',
            'name' => 'name'
        ]);

        $this->crud->addColumn([
            'label' => 'メールアドレス',
            'type' => 'email',
            'name' => 'email',
        ]);

        $this->crud->addColumn([
            'label'     => '権限',
            'type'      => 'relationship',
            'name'      => 'roles',
            'entity'    => 'roles',
            'attribute' => 'name',
            'model'     => "Backpack\PermissionManager\app\Models\Role",
            // 'pivot'     => true,
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
        $user = backpack_user();

        CRUD::setValidation(UserCreateRequest::class);

        // image
        $this->crud->addField([
            'label' => "プロフィール画像",
            'name' => "image",
            'type' => 'image',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);

        $this->crud->addField([
            'label' => '名前',
            'type' => 'text',
            'name' => 'name',
        ]);

        $this->crud->addField([
            'label' => 'メールアドレス',
            'type' => 'email',
            'name' => 'email',
        ]);

        $this->crud->addField([
            'label' => 'パスワード',
            'type' => 'password',
            'name' => 'password',
        ]);
        
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    protected function handlePasswordInput($request)
    {
        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');
        $request->request->remove('roles_show');
        $request->request->remove('permissions_show');

        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', bcrypt($request->input('password')));
        } else {
            $request->request->remove('password');
        }

        return $request;
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
        CRUD::setValidation(UserUpdateRequest::class);
    }
}
