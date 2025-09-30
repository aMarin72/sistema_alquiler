<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Inquilino;
use Livewire\WithPagination;

class Inquilinos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    // campos del formulario crear inquilino
    public $nombres;
    public $email;
    public $telefono;
    public $fecha_nacimiento;
    public $dni;

    // campos del formulario editar inquilino
    public $editNombres;
    public $editEmail;
    public $editTelefono;
    public $editFechaNacimiento;
    public $editDni;

    // control de los modales
    public $createModal = false;
    public $showModal = false;
    public $editModal = false;
    public $deleteModal = false;
    public $inquilinoShow; // Guardar la consulta para mostrar los datos del inquilino a mostrar
    public $inquilinoEdit; // Guardar la consulta para mostrar los datos del inquilino a editar
    public $inquilinoDelete; // Guardar la consulta para mostrar los datos del inquilino a eliminar

    // Validaciones
    protected $rules = [
        'nombres' => 'required|string|max:255',
        'email' => 'required|email|unique:inquilinos,email',
        'telefono' => 'required|string|max:255',
        'fecha_nacimiento' => 'required|date',
        'dni' => 'required|string|max:255|unique:inquilinos,dni',
    ];

    // reset de los campos del formulario crear inquilino
    public function resetCreateForm()
    {
        $this->reset('nombres', 'email', 'telefono', 'fecha_nacimiento', 'dni');
        $this->resetErrorBag();
    }

    // reset de los campos del formulario editar inquilino
    public function resetEditForm()
    {
        $this->reset('editNombres', 'editEmail', 'editTelefono', 'editFechaNacimiento', 'editDni', 'inquilinoEdit');
        $this->resetErrorBag();
    }

    // mostrar modal crear inquilino
    public function openModalCreate()
    {
        $this->resetCreateForm();
        $this->createModal = true;
    }

    // guardar inquilino
    public function save()
    {
        $this->validate();

        Inquilino::create([
            'nombres' => $this->nombres,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'dni' => $this->dni,
        ]);

        $this->resetCreateForm();
        $this->createModal = false;
        session()->flash('message', 'Inquilino creado correctamente.');
    }

    // mostrar modal show inquilino
    public function modalShow(Inquilino $inquilino)
    {
        $this->inquilinoShow = $inquilino;
        $this->showModal = true;
    }

    // mostrar modal editar inquilino
    public function modalEdit(Inquilino $inquilino)
    {
        $this->inquilinoEdit = $inquilino;
        $this->editNombres = $inquilino->nombres;
        $this->editEmail = $inquilino->email;
        $this->editTelefono = $inquilino->telefono;
        $this->editFechaNacimiento = $inquilino->fecha_nacimiento;
        $this->editDni = $inquilino->dni;
        $this->editModal = true;
    }

    // actualizar inquilino
    public function update()
    {
        $this->validate([
            'editNombres' => 'required|string|max:255',
            'editEmail' => 'required|email|unique:inquilinos,email,' . $this->inquilinoEdit->id,
            'editTelefono' => 'required|string|max:255',
            'editFechaNacimiento' => 'required|date',
            'editDni' => 'required|string|max:255|unique:inquilinos,dni,' . $this->inquilinoEdit->id,
        ]);

        $this->inquilinoEdit->update([
            'nombres' => $this->editNombres,
            'email' => $this->editEmail,
            'telefono' => $this->editTelefono,
            'fecha_nacimiento' => $this->editFechaNacimiento,
            'dni' => $this->editDni,
        ]);

        $this->resetEditForm();
        $this->editModal = false;
        session()->flash('message', 'Inquilino actualizado correctamente.');
    }

    // confirmar eliminacion de inquilino
    public function modalDelete(Inquilino $inquilino)
    {
        $this->inquilinoDelete = $inquilino;
        $this->deleteModal = true;
    }

    // eliminar inquilino
    public function delete()
    {
        $this->inquilinoDelete->delete();
        $this->deleteModal = false;
        $this->resetPage();
        session()->flash('message', 'Inquilino eliminado correctamente.');
    }

    public function render()
    {
        $inquilinos = Inquilino::paginate(10);
        return view('livewire.inquilinos', compact('inquilinos'));
    }
}
