<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TareaCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TareaCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Tarea::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/tarea');
        CRUD::setEntityNameStrings('tarea', 'tareas');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column("titulo")
            ->label("Tarea");

        CRUD::column("descripcion")
            ->label("Descripcion");

        CRUD::column("user.name")
            ->label("Usuario asignado");

        CRUD::column("proyecto.nombre")
            ->label("Proyecto");

        CRUD::column("categoria.nombre")
            ->label("Categoria");
        
        CRUD::column('prioridad')
            ->label('Prioridad')
            ->type('radio')
            ->options(
                [
                    1 => 'Baja',
                    2 => 'Media',
                    3 => 'Alta',
                ]
            )
            ->wrapper([  //estilos
                'element' => 'span',
                'class' => function ($crud, $column, $entry, $related_key) {
                    if (($entry->prioridad) == 1) {
                        return 'badge bg-success';
                    }

                    if (($entry->prioridad) == 2) {
                        return 'badge bg-warning';
                    }
                    return 'badge bg-danger';
                },
            ]);

        CRUD::column('estado')
            ->label('Estado')
            ->type('radio')
            ->options(
                [
                    1 => 'No realizada',
                    2 => 'En proceso',
                    3 => 'Finalizada',
                ]
            )
            ->wrapper([  //estilos
                'element' => 'span',
                'class' => function ($crud, $column, $entry, $related_key) {
                    if (($entry->estado) == 3) {
                        return 'badge bg-success';
                    }

                    if (($entry->estado) == 2) {
                        return 'badge bg-warning';
                    }


                    return 'badge bg-danger';
                },
            ]);

        ;
        
        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
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
       // CRUD::setFromDb(); // set fields from db columns.
        CRUD::field("titulo");
        CRUD::field("descripcion");
        CRUD::field('usuario_id')
            ->type('select')
            ->label('Usuario')
            ->hint("Usuario al cual queres asignar la tarea")
            ->entity('user')
            ->attribute('name');

        CRUD::field('categoria_id')
            ->type('select')
            ->label('Categoria')
            ->entity('categoria')
            ->attribute('nombre');

        CRUD::field('proyecto_id')
            ->type('select')
            ->label('Proyecto')
            ->entity('proyecto')
            ->attribute('nombre');

        CRUD::field("estado")
            ->label("Estado de tarea")
            ->type("radio")
            ->default(1)
            ->options(
                [
                    1 => "No realizado",
                    2 => "En proceso",
                    3 => "Finalizado"
                ]
            );

        
        CRUD::field("prioridad")
            ->label("Prioridad de tarea")
            ->type("radio")
            ->default(3)
            ->options(
                [
                    1 => "Baja",
                    2 => "Media",
                    3 => "Alta",

                ]
            );
        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
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
