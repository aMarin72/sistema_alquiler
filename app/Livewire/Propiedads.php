<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Propiedad;
use Flux\Flux;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class Propiedads extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Campos del formulario
    public $tipo;
    public $direccion;
    public $precio;
    public $descripcion;
    public $estado = 'disponible';

    public $showModal = false; // Controlar la visibilidad del modal
    public $propiedadSeleccionada; // Guardar la consulta para mostrar los datos en el modal

    // Reglas de validación
    protected $rules = [
        'tipo' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'precio' => 'required|numeric|min:0',
        'descripcion' => 'required|string',
        'estado' => 'required|in:disponible,alquilado,mantenimiento|string',
    ];

    // Reset de los campos del formulario de creación de una propiedad
    public function resetForm()
    {
        $this->tipo = '';
        $this->direccion = '';
        $this->precio = '';
        $this->descripcion = '';
        $this->estado = '';
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

        $this->resetForm();
        Flux::modal('create-propiedad')->close(); // Cerrar el modal
        session()->flash('message', 'Propiedad creada correctamente.');
    }

    public function show(Propiedad $propiedad)
    {
        $this->propiedadSeleccionada = $propiedad;
        $this->showModal = true;
    }

    public function render()
    {
        $propiedades = Propiedad::latest()->paginate(10);
        return view('livewire.propiedads', compact('propiedades'));
    }
}
