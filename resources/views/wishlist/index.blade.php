<x-app-layout>
    <h1 class="text-2xl font-bold mb-6">Mi lista de deseos</h1>

    @if($products->isEmpty())
        <p class="text-gray-500">Todavía no agregaste productos a tu lista de deseos. <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Ver catálogo</a></p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($products as $product)
                <div class="bg-white rounded shadow p-4 flex flex-col">
                    <a href="{{ route('products.show', $product) }}">
                        <div class="bg-gray-100 h-40 rounded mb-3 flex items-center justify-center text-gray-400 text-sm">
                            Sin imagen
                        </div>
                        <h2 class="font-semibold text-gray-800">{{ $product->name }}</h2>
                    </a>
                    <p class="text-sm text-gray-500 mb-2">
                        @foreach($product->categories as $cat)
                            <span class="inline-block bg-gray-100 rounded px-2 py-0.5 text-xs">{{ $cat->name }}</span>
                        @endforeach
                    </p>
                    <p class="mt-auto text-lg font-bold text-blue-600">{{ $product->formatted_price }}</p>

                    <form method="POST" action="{{ route('wishlist.toggle', $product) }}" class="mt-2">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:underline">❤️ Quitar de mis deseos</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>