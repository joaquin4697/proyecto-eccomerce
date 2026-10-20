<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Productos</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
            + Nuevo producto
        </a>
    </div>

    @if(session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <div class="bg-slate-100 rounded-3xl shadow overflow-hidden border border-slate-200">
        <table class="w-full text-sm text-left text-slate-900">
            <thead class="bg-slate-200 text-slate-900">
                <tr>
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Precio</th>
                    <th class="px-4 py-3">Stock</th>
                    <th class="px-4 py-3">Categorías</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="border-t bg-white hover:bg-slate-50">
                        <td class="px-4 py-3 text-slate-900">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-slate-900">{{ $product->formatted_price }}</td>
                        <td class="px-4 py-3">{{ $product->stock }}</td>
                        <td class="px-4 py-3">
                            @foreach($product->categories as $cat)
                                <span class="inline-block bg-slate-200 rounded px-2 py-0.5 text-xs text-slate-800">{{ $cat->name }}</span>
                            @endforeach
                        </td>
                        <td class="px-4 py-3">
                            @if($product->active)
                                <span class="text-green-600 text-xs">Activo</span>
                            @else
                                <span class="text-slate-500 text-xs">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 space-x-3">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-sky-600 hover:underline">Editar</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline"
                                  onsubmit="return confirm('¿Seguro que querés eliminar este producto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
</x-app-layout>