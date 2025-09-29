<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Propiedad;
use Flux\Flux;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class Propiedads extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'tailwind';

    // Campos del formulario crear propiedad
    public $tipo;
    public $direccion;
    public $precio;
    public $descripcion;
    public $estado = 'disponible';

    // Campos del formulario editar propiedad
    public $editTipo;
    public $editDireccion;
    public $editPrecio;
    public $editDescripcion;
    public $editEstado;

    // Controlar la visibilidad del modal
    public $showModal = false; // Controlar la visibilidad del modal
    public $propiedadSeleccionada; // Guardar la consulta para mostrar los datos en el modal
    public $editModal = false; // Controlar la visibilidad del modal
    public $editPropiedadSeleccionada; // Guardar la consulta para mostrar los datos en el modal
    public $deleteModal = false; // Controlar la visibilidad del modal
    public $deletePropiedadSeleccionada; // Guardar la consulta para mostrar los datos en el modal

    // Reglas de validación
    protected $rules = [
        'tipo' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'precio' => 'required|numeric|min:0',
        'descripcion' => 'required|string',
        'estado' => 'required|in:disponible,alquilado,mantenimiento|string',
    ];

    // Reset de los campos del formulario de creación de una propiedad
    public function resetCreateForm()
    {
        $this->reset('tipo', 'direccion', 'precio', 'descripcion', 'estado');
        $this->resetErrorBag();
    }

    // Reset de los campos del formulario de edición de una propiedad
    public function resetEditForm()
    {
        $this->reset('editTipo', 'editDireccion', 'editPrecio', 'editDescripcion', 'editEstado', 'editPropiedadSeleccionada');
        $this->resetErrorBag();
    }

    // Crear una nueva propiedad
    public function save()
    {
        $this->validate();

        Propiedad::create([
            'tipo' => $this->tipo,
            'direccion' => $this->direccion,
            'precio' => $this->precio,
            'descripcion' => $this->descripcion,
            'estado' => $this->estado,
        ]);

        $this->resetCreateForm();
        Flux::modal('create-propiedad')->close(); // Cerrar el modal
        session()->flash('message', 'Propiedad creada correctamente.');
    }

    public function show(Propiedad $propiedad)
    {
        $this->propiedadSeleccionada = $propiedad;
        $this->showModal = true;
    }

    public function showModalEdit(Propiedad $propiedad)
    {
        $this->editPropiedadSeleccionada = $propiedad;
        $this->editTipo = $propiedad->tipo;
        $this->editDireccion = $propiedad->direccion;
        $this->editPrecio = $propiedad->precio;
        $this->editDescripcion = $propiedad->descripcion;
        $this->editEstado = $propiedad->estado;
        $this->editModal = true;
    }

    public function update()
    {
        $this->validate([
            'editTipo' => 'required|string|max:255',
            'editDireccion' => 'required|string|max:255',
            'editPrecio' => 'required|numeric|min:0',
            'editDescripcion' => 'required|string',
            'editEstado' => 'required|in:disponible,alquilado,mantenimiento|string',
        ]);

        $this->editPropiedadSeleccionada->update([
            'tipo' => $this->editTipo,
            'direccion' => $this->editDireccion,
            'precio' => $this->editPrecio,
            'descripcion' => $this->editDescripcion,
            'estado' => $this->editEstado,
        ]);

        $this->resetEditForm();
        Flux::modal('edit-propiedad')->close(); // Cerrar el modal
        session()->flash('message', 'Propiedad actualizada correctamente.');
    }

    public function showModaldelete(Propiedad $propiedad)
    {
        $this->deletePropiedadSeleccionada = $propiedad;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $this->deletePropiedadSeleccionada->delete();
        $this->deleteModal = false;
        session()->flash('message', 'Propiedad eliminada correctamente.');

        $this->resetPage();
    }

    public function render()
    {
        $propiedades = Propiedad::latest()->paginate(10);
        return view('livewire.propiedads', compact('propiedades'));
    }
}
