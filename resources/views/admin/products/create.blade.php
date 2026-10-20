<x-app-layout>
    <h1 class="text-2xl font-bold mb-6">Nuevo producto</h1>

    <div class="bg-white p-6 rounded shadow max-w-2xl">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="name" value="{{ old('name') }}" class="mt-1 w-full border-gray-300 rounded shadow-sm">
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="description" rows="3" class="mt-1 w-full border-gray-300 rounded shadow-sm">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Precio</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="mt-1 w-full border-gray-300 rounded shadow-sm">
                    @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" class="mt-1 w-full border-gray-300 rounded shadow-sm">
                    @error('stock') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categorías</label>
                <div class="flex flex-wrap gap-3">
                    @foreach($categories as $category)
                        <label class="flex items-center gap-1 text-sm">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                   @checked(collect(old('categories'))->contains($category->id))>
                            {{ $category->name }}
                        </label>
                    @endforeach
                </div>
                @error('categories') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Imagen</label>
                <input type="file" name="image" class="mt-1 w-full text-sm">
                @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="active" value="1" checked>
                Producto activo (visible en el catálogo)
            </label>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Guardar</button>
                <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-600 hover:underline self-center">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>