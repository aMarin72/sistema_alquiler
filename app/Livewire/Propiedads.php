<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Propiedad;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class Propiedads extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $propiedades = Propiedad::paginate(10);
        return view('livewire.propiedads', compact('propiedades'));
    }
}
