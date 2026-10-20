<x-app-layout>
    <div class="flex flex-col md:flex-row gap-6">

        <aside class="md:w-1/4">
            <form method="GET" action="{{ route('home') }}" class="bg-slate-100 text-slate-900 p-5 rounded-3xl shadow-xl ring-1 ring-emerald-100 space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Buscar</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Nombre del producto..."
                           class="w-full border border-slate-300 rounded-xl bg-slate-50 text-slate-900 placeholder-slate-500 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Categoría</label>
                    <select name="category" class="w-full border border-slate-300 rounded-xl bg-slate-50 text-slate-900 text-sm px-3 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
                        <option value="" class="bg-slate-50 text-slate-900">Todas</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category') == $category->id) class="bg-slate-50 text-slate-900">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full bg-emerald-600 text-white py-2 rounded-xl text-sm font-semibold hover:bg-emerald-500 transition">
                    Filtrar
                </button>

                @if(request('search') || request('category'))
                    <a href="{{ route('home') }}" class="block text-center text-sm text-emerald-600 hover:text-emerald-700 hover:underline">
                        Limpiar filtros
                    </a>
                @endif
            </form>
        </aside>

        <div class="md:w-3/4">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Catálogo de productos</h1>
                    <p class="text-slate-600 mt-1">Explora los productos disponibles con un estilo natural y fresco.</p>
                </div>
            </div>

            @if($products->isEmpty())
                <p class="text-slate-600">No se encontraron productos.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($products as $product)
                        <a href="{{ route('products.show', $product) }}"
                           class="group bg-slate-100 text-slate-900 rounded-3xl shadow-lg ring-1 ring-emerald-100 hover:-translate-y-1 transition p-5 flex flex-col">
                            <div class="bg-emerald-50 h-44 rounded-3xl mb-4 flex items-center justify-center text-emerald-400 text-sm">
                                Sin imagen
                            </div>
                            <h2 class="font-semibold text-lg text-slate-900 mb-2">{{ $product->name }}</h2>
                            <p class="text-sm text-slate-500 mb-4">
                                @foreach($product->categories as $cat)
                                    <span class="inline-block bg-emerald-100 rounded-full px-3 py-1 text-xs text-slate-700">{{ $cat->name }}</span>
                                @endforeach
                            </p>
                            <div class="mt-auto flex items-center justify-between gap-3">
                                <p class="text-xl font-bold text-emerald-600">{{ $product->formatted_price }}</p>
                                <span class="text-sm font-medium text-emerald-500 group-hover:text-emerald-700">Ver +</span>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>