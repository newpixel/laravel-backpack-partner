<?php

namespace Newpixel\PartnerCRUD\App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use Newpixel\PartnerCRUD\App\Http\Requests\PartnerRequest as StoreRequest;
use Newpixel\PartnerCRUD\App\Http\Requests\PartnerRequest as UpdateRequest;

/**
 * Class PartnerCrudController.
 * @property-read CrudPanel $crud
 */
class PartnerCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('Newpixel\PartnerCRUD\App\Models\Partner');
        $this->crud->setRoute(config('backpack.base.route_prefix').'/partner');
        $this->crud->setEntityNameStrings('partener', 'parteneri');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();

        $this->crud->addColumns([
            [
                'name'      => 'row_number',
                'type'      => 'row_number',
                'label'     => '#',
                'orderable' => false,
            ],
            [
                'name'  => 'name',
                'label' => 'Denumire',
                'type'  => 'text',
            ],
            [
                'name'  => 'link',
                'label' => 'Url',
                'type'  => 'text',
            ],
            [
                'name'   => 'image',
                'label'  => 'Imagine',
                'type'   => 'image',
                'prefix' => 'storage/',
            ],
            [
                'name'    => 'active',
                'label'   => 'Activ',
                'type'    => 'radio',
                'options' => [0 => 'Nu', 1 => 'Da'],
                'inline'  => false,
            ],
        ]);

        $this->crud->addFields([
            [
                'name'              => 'name',
                'label'             => 'Denumire',
                'type'              => 'text',
                'wrapperAttributes' => ['class' => 'form-group col-md-10'],
            ],
            [
                'name'              => 'active',
                'label'             => 'Activ',
                'type'              => 'radio',
                'options'           => [0 => 'Nu', 1 => 'Da'],
                'inline'            => true,
                'wrapperAttributes' => ['class' => 'form-group col-md-2'],
            ],
            [
                'name'              => 'link',
                'label'             => 'Url',
                'type'              => 'url',
                'wrapperAttributes' => ['class' => 'form-group col-md-12'],
            ],
            [
                'name'         => 'image',
                'label'        => 'Imagine',
                'type'         => 'image',
                'upload'       => true,
                'crop'         => true,
                'aspect_ratio' => 2,
                'prefix'       => 'storage/',
            ],
        ]);

        // add asterisk for fields that are required in PartnerRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
