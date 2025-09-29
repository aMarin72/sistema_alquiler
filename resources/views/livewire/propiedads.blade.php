<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Inicio</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('propiedades') }}">Listado de Propiedades</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <hr class="my-5">

    {{-- Modal formulario --}}
    <flux:modal.trigger name="create-propiedad">
        <flux:button variant="primary">Crear Nueva Propiedad</flux:button>
    </flux:modal.trigger>

    @if (session()->has('message'))
        {{-- Opcion 1 --}}
        {{-- <div class="mt-5">
            <flux:callout variant="success" icon="check-circle" heading="{{ session('message') }}" />
        </div> --}}
        {{-- Opcion 2, con SweetAlert2 --}}
        <div x-data x-init="Swal.fire({
            position: 'center',
            icon: 'success',
            title: '{{ session('message') }}',
            showConfirmButton: false,
            timer: 2500
        });">
        </div>
    @endif

    {{-- Modal crear propiedad --}}
    <flux:modal name="create-propiedad" class="w-full">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Crear nueva propiedad</flux:heading>
                <flux:text class="mt-2">Rellene todos los campos requeridos.</flux:text>
            </div>

            <form wire:submit.prevent="save" class="space-y-6">
                <flux:input wire:model="tipo" :label="__('* Tipo')" type="text" />
                <flux:input wire:model="direccion" :label="__('* Dirección')" type="text" />
                <flux:input wire:model="precio" :label="__('* Precio')" type="number" />
                <flux:textarea wire:model="descripcion" :label="__('* Descripción')"></flux:textarea>
                <flux:select wire:model="estado" :label="__('* Estado')">
                    <option value="disponible">Disponible</option>
                    <option value="alquilado">Alquilado</option>
                    <option value="mantenimiento">Mantenimiento</option>
                </flux:select>

                <div class="flex justify-end space-x-2 rtl:space-x-reverse py-4">
                    <flux:modal.close>
                        <flux:button variant="filled">{{ __('Cancelar') }}</flux:button>
                    </flux:modal.close>

                    <flux:button variant="primary" type="submit">{{ __('Guardar') }}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    {{-- Modal mostrar propiedad --}}
    <flux:modal name="show-propiedad" class="w-full" wire:model='showModal'>
        @if ($propiedadSeleccionada)
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Detalles de la propiedad</flux:heading>
                </div>

                <div>
                    <flux:heading size="lg">Tipo</flux:heading>
                    <flux:text>{{ Str::ucfirst($propiedadSeleccionada->tipo) }}</flux:text>
                </div>

                <div>
                    <flux:heading size="lg">Dirección</flux:heading>
                    <flux:text>{{ $propiedadSeleccionada->direccion }}</flux:text>
                </div>

                <div>
                    <flux:heading size="lg">Precio</flux:heading>
                    <flux:text>{{ $propiedadSeleccionada->precio }}</flux:text>
                </div>

                <div>
                    <flux:heading size="lg">Descripción</flux:heading>
                    <flux:text>{{ $propiedadSeleccionada->descripcion }}</flux:text>
                </div>

                <div>
                    <flux:heading size="lg">Estado</flux:heading>
                    <flux:text>{{ Str::ucfirst($propiedadSeleccionada->estado) }}</flux:text>
                </div>

                <div class="flex justify-end space-x-2 rtl:space-x-reverse py-4">
                    <flux:modal.close>
                        <flux:button variant="filled">{{ __('Cerrar') }}</flux:button>
                    </flux:modal.close>
                </div>
            </div>
        @endif
    </flux:modal>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="">
                    <th class="px-4 py-2">Tipo</th>
                    <th class="px-4 py-2">Dirección</th>
                    <th class="px-4 py-2">Precio</th>
                    <th class="px-4 py-2">Descripción</th>
                    <th class="px-4 py-2">Estado</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($propiedades as $propiedad)
                    <tr>
                        <td class="border px-4 py-2">{{ Str::ucfirst($propiedad->tipo) }}</td>
                        <td class="border px-4 py-2">{{ $propiedad->direccion }}</td>
                        <td class="border px-4 py-2">$ {{ $propiedad->precio }}</td>
                        <td class="border px-4 py-2">{{ Str::limit($propiedad->descripcion, 50) }}</td>
                        <td class="border px-4 py-2">{{ Str::ucfirst($propiedad->estado) }}</td>
                        <td class="border px-4 py-2">
                            <flux:button variant="primary" color="cyan" wire:click="show({{ $propiedad }})">
                                <flux:icon name="eye" />
                            </flux:button>
                            <flux:button variant="primary" color="amber">
                                <flux:icon name="pencil" />
                            </flux:button>
                            <flux:button variant="primary" color="red">
                                <flux:icon name="trash" />
                            </flux:button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $propiedades->links() }}
    </div>
</div>
