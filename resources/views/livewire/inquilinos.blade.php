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

    {{-- Boton para mostrar el modal de crear inquilino, llama al metodo openModalCreate --}}
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

    {{-- Modal mostrar inquilino --}}
    <flux:modal name="show-inquilino" class="w-full" wire:model='showModal'>
        @if ($inquilinoShow)
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Detalles del inquilino</flux:heading>
                </div>

                <div>
                    <flux:heading size="lg">Nombres</flux:heading>
                    <flux:text>{{ $inquilinoShow->nombres }}</flux:text>
                </div>

                <div>
                    <flux:heading size="lg">Email</flux:heading>
                    <flux:text>{{ $inquilinoShow->email }}</flux:text>
                </div>

                <div>
                    <flux:heading size="lg">Teléfono</flux:heading>
                    <flux:text>{{ $inquilinoShow->telefono }}</flux:text>
                </div>

                <div>
                    <flux:heading size="lg">Fecha de Nacimiento</flux:heading>
                    <flux:text>{{ $inquilinoShow->fecha_nacimiento }}</flux:text>
                </div>

                <div>
                    <flux:heading size="lg">DNI</flux:heading>
                    <flux:text>{{ $inquilinoShow->dni }}</flux:text>
                </div>

                <div class="flex justify-end space-x-2 rtl:space-x-reverse py-4">
                    <flux:modal.close>
                        <flux:button variant="filled">{{ __('Cerrar') }}</flux:button>
                    </flux:modal.close>
                </div>
            </div>
        @endif
    </flux:modal>

    {{-- Modal editar inquilino --}}
    <flux:modal name="edit-inquilino" class="w-full" wire:model='editModal'>
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Editar inquilino</flux:heading>
                <flux:text class="mt-2">Rellene todos los campos requeridos.</flux:text>
            </div>

            <form wire:submit.prevent="update" class="space-y-6">
                <flux:input wire:model="editNombres" :label="__('* Nombres')" type="text" />
                <flux:input wire:model="editEmail" :label="__('* Email')" type="email" />
                <flux:input wire:model="editTelefono" :label="__('* Teléfono')" type="text" />
                <flux:input wire:model="editFechaNacimiento" :label="__('* Fecha de Nacimiento')" type="date" />
                <flux:input wire:model="editDni" :label="__('* DNI')" type="text" />
                <div class="flex justify-end space-x-2 rtl:space-x-reverse py-4">
                    <flux:modal.close>
                        <flux:button variant="filled">{{ __('Cancelar') }}</flux:button>
                    </flux:modal.close>

                    <flux:button variant="primary" type="submit">{{ __('Guardar') }}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    {{-- Modal eliminar inquilino --}}
    <flux:modal name="delete-inquilino" class="w-full" wire:model='deleteModal'>
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Eliminar inquilino?</flux:heading>

                <flux:text class="mt-2">
                    <p>¿Está seguro de que desea eliminar este inquilino?.</p>
                    <p>Esta acción no se puede deshacer.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger" wire:click="delete">Eliminar inquilino</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
