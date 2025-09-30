<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Inicio</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('inquilinos') }}">Listado de Inquilinos</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <hr class="my-5">

    @if (session()->has('message'))
        <div x-data x-init="Swal.fire({
            position: 'center',
            icon: 'success',
            title: '{{ session('message') }}',
            showConfirmButton: false,
            timer: 2500
        });">
        </div>
    @endif

    {{-- Boton para mostrar el modal de crear inquilino --}}
    <flux:button variant="primary" wire:click="openModalCreate">Crear Nuevo Inquilino</flux:button>

    {{-- Modal crear inquilino --}}
    <flux:modal class="w-full" wire:model='createModal'>
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Añadir nuevo inquilino</flux:heading>
                <flux:text class="mt-2">Rellene todos los campos requeridos.</flux:text>
            </div>

            <form wire:submit.prevent="save" class="space-y-6">
                <flux:input wire:model="nombres" :label="__('* Nombres')" type="text" />
                <flux:input wire:model="email" :label="__('* Email')" type="email" />
                <flux:input wire:model="telefono" :label="__('* Teléfono')" type="text" />
                <flux:input wire:model="fecha_nacimiento" :label="__('* Fecha de Nacimiento')" type="date" />
                <flux:input wire:model="dni" :label="__('* DNI')" type="text" />
                <div class="flex justify-end space-x-2 rtl:space-x-reverse py-4">
                    <flux:modal.close>
                        <flux:button variant="filled">{{ __('Cancelar') }}</flux:button>
                    </flux:modal.close>

                    <flux:button variant="primary" type="submit">{{ __('Guardar') }}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Nombres</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Teléfono</th>
                    <th class="px-4 py-2">Fecha de Nacimiento</th>
                    <th class="px-4 py-2">DNI</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inquilinos as $inquilino)
                    <tr>
                        <td class="border px-4 py-2">{{ $inquilino->id }}</td>
                        <td class="border px-4 py-2">{{ $inquilino->nombres }}</td>
                        <td class="border px-4 py-2">{{ $inquilino->email }}</td>
                        <td class="border px-4 py-2">{{ $inquilino->telefono }}</td>
                        <td class="border px-4 py-2">{{ $inquilino->fecha_nacimiento }}</td>
                        <td class="border px-4 py-2">{{ $inquilino->dni }}</td>
                        <td class="border px-4 py-2">
                            <flux:button variant="primary" color="cyan" wire:click="modalShow({{ $inquilino }})">
                                <flux:icon name="eye" />
                            </flux:button>
                            <flux:button variant="primary" color="amber" wire:click="modalEdit({{ $inquilino }})">
                                <flux:icon name="pencil" />
                            </flux:button>
                            <flux:button variant="primary" color="red"
                                wire:click="modalDelete({{ $inquilino }})">
                                <flux:icon name="trash" />
                            </flux:button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $inquilinos->links() }}
    </div>
</div>
