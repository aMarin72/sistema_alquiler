<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contrato;
use App\Models\Inquilino;
use App\Models\Propiedad;
use Livewire\WithPagination;

class Contratos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    // definir los campos del formulario crear contrato
    public $propiedad_id;
    public $inquilino_id;
    public $fecha_inicio;
    public $fecha_fin;
    public $monto;
    public $estado = 'activo';

    // definir los campos del formulario editar contrato
    public $editPropiedad_id;
    public $editInquilino_id;
    public $editFecha_inicio;
    public $editFecha_fin;
    public $editMonto;
    public $editEstado;

    // control de los modales
    public $createModal = false;
    public $showModal = false;
    public $editModal = false;
    public $deleteModal = false;
    public $contratoShow; // Guardar la consulta para mostrar los datos del contrato a mostrar
    public $contratoEdit; // Guardar la consulta para mostrar los datos del contrato a editar
    public $contratoDelete; // Guardar la consulta para mostrar los datos del contrato a eliminar

    // Validaciones
    protected $rules = [
        'propiedad_id' => 'required|exists:propiedads,id',
        'inquilino_id' => 'required|exists:inquilinos,id',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after:fecha_inicio',
        'monto' => 'required|numeric|min:0',
        'estado' => 'required|in:activo,inactivo,finalizado|string',
    ];

    // reset de los campos del formulario crear contrato
    public function resetCreateForm()
    {
        $this->reset('propiedad_id', 'inquilino_id', 'fecha_inicio', 'fecha_fin', 'monto', 'estado');
        $this->resetErrorBag();
    }

    // reset de los campos del formulario editar contrato
    public function resetEditForm()
    {
        $this->reset('editPropiedad_id', 'editInquilino_id', 'editFecha_inicio', 'editFecha_fin', 'editMonto', 'editEstado', 'contratoEdit');
        $this->resetErrorBag();
    }

    // mostrar modal crear contrato
    public function openModalCreate()
    {
        $this->resetCreateForm();
        $this->createModal = true;
    }

    // Crear un nuevo contrato
    public function save()
    {
        $this->validate();

        Contrato::create([
            'propiedad_id' => $this->propiedad_id,
            'inquilino_id' => $this->inquilino_id,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'monto' => $this->monto,
            'estado' => $this->estado,
        ]);

        $this->resetCreateForm();
        $this->createModal = false;
        session()->flash('message', 'Contrato creado correctamente.');
    }

    public function render()
    {
        $contratos = Contrato::with(['propiedad', 'inquilino'])->orderBy('created_at', 'desc')->paginate(10);
        $propiedades = Propiedad::where('estado', 'disponible')->get();
        $inquilinos = Inquilino::all();
        return view('livewire.contratos', compact('contratos', 'propiedades', 'inquilinos'));
    }
}
