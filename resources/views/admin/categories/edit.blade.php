<x-app-layout>
    <h1 class="text-2xl font-bold mb-6">Editar categoría</h1>

    <div class="bg-white p-6 rounded shadow max-w-lg">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="mt-1 w-full border-gray-300 rounded shadow-sm">
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="description" rows="3" class="mt-1 w-full border-gray-300 rounded shadow-sm">{{ old('description', $category->description) }}</textarea>
                @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Actualizar</button>
                <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-600 hover:underline self-center">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>