<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Inicio</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Listado de Propiedades</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <hr class="my-5">

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">Tipo</th>
                    <th class="px-4 py-2">Dirección</th>
                    <th class="px-4 py-2">Precio</th>
                    <th class="px-4 py-2">Descripción</th>
                    <th class="px-4 py-2">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($propiedades as $propiedad)
                    <tr>
                        <td class="border px-4 py-2">{{ $propiedad->tipo }}</td>
                        <td class="border px-4 py-2">{{ $propiedad->direccion }}</td>
                        <td class="border px-4 py-2">$ {{ $propiedad->precio }}</td>
                        <td class="border px-4 py-2">{{ Str::limit($propiedad->descripcion, 50) }}</td>
                        <td class="border px-4 py-2">{{ $propiedad->estado }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $propiedades->links() }}
    </div>
</div>
