<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Inicio</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('contratos') }}">Listado de Contratos</flux:breadcrumbs.item>
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

    {{-- Boton para mostrar el modal de crear contrato, llama al metodo openModalCreate --}}
    <flux:button variant="primary" wire:click="openModalCreate">Crear Nuevo Contrato</flux:button>

    {{-- Modal crear contrato --}}
    <flux:modal class="w-full" wire:model='createModal'>
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Añadir nuevo contrato</flux:heading>
                <flux:text class="mt-2">Rellene todos los campos requeridos.</flux:text>
            </div>

            <form wire:submit.prevent="save" class="space-y-6">
                <flux:select wire:model="propiedad_id" :label="__('* Propiedad')">
                    <option value="">Seleccione una propiedad</option>
                    @foreach ($propiedades as $propiedad)
                        <option value="{{ $propiedad->id }}">{{ Str::ucfirst($propiedad->tipo) }}</option>
                    @endforeach
                </flux:select>
                <flux:select wire:model="inquilino_id" :label="__('* Inquilino')">
                    <option value="">Seleccione un inquilino</option>
                    @foreach ($inquilinos as $inquilino)
                        <option value="{{ $inquilino->id }}">{{ $inquilino->nombres }}</option>
                    @endforeach
                </flux:select>
                <flux:input wire:model="fecha_inicio" :label="__('* Fecha de Inicio')" type="date" />
                <flux:input wire:model="fecha_fin" :label="__('* Fecha de Fin')" type="date" />
                <flux:input wire:model="monto" :label="__('* Monto')" type="number" />
                <flux:select wire:model="estado" :label="__('* Estado')">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                    <option value="finalizado">Finalizado</option>
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

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Propiedad</th>
                    <th class="px-4 py-2">Inquilino</th>
                    <th class="px-4 py-2">Fecha de Inicio</th>
                    <th class="px-4 py-2">Fecha de Fin</th>
                    <th class="px-4 py-2">Monto</th>
                    <th class="px-4 py-2">Estado</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contratos as $contrato)
                    <tr>
                        <td class="border px-4 py-2">{{ $contrato->id }}</td>
                        <td class="border px-4 py-2">{{ $contrato->propiedad->tipo }}</td>
                        <td class="border px-4 py-2">{{ $contrato->inquilino->nombres }}</td>
                        <td class="border px-4 py-2">{{ $contrato->fecha_inicio }}</td>
                        <td class="border px-4 py-2">{{ $contrato->fecha_fin }}</td>
                        <td class="border px-4 py-2">{{ $contrato->monto }}</td>
                        <td class="border px-4 py-2">{{ $contrato->estado }}</td>
                        <td class="border px-4 py-2">
                            <flux:button variant="primary" color="cyan" wire:click="modalShow({{ $contrato }})">
                                <flux:icon name="eye" />
                            </flux:button>
                            <flux:button variant="primary" color="amber" wire:click="modalEdit({{ $contrato }})">
                                <flux:icon name="pencil" />
                            </flux:button>
                            <flux:button variant="primary" color="red"
                                wire:click="modalDelete({{ $contrato }})">
                                <flux:icon name="trash" />
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="border px-4 py-2 text-center">No hay contratos</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $contratos->links() }}
    </div>
</div>
