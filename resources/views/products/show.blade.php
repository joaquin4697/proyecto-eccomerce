<x-app-layout>
    <div class="bg-slate-50 rounded-3xl shadow-xl p-6 max-w-3xl mx-auto ring-1 ring-slate-200">
        <a href="{{ route('home') }}" class="text-sm text-sky-600 hover:text-sky-800 hover:underline">&larr; Volver al catálogo</a>

        <div class="mt-4 bg-slate-100 h-64 rounded flex items-center justify-center text-slate-500">
            Sin imagen
        </div>

        <h1 class="text-2xl font-bold mt-4 text-slate-900">{{ $product->name }}</h1>

        <p class="text-sm text-slate-600 mt-1">
            @foreach($product->categories as $cat)
                <span class="inline-block bg-slate-200 text-slate-800 rounded px-2 py-0.5 text-xs">{{ $cat->name }}</span>
            @endforeach
        </p>

        <p class="text-2xl font-bold text-blue-600 mt-3">{{ $product->formatted_price }}</p>

        <p class="text-sm text-gray-600 mt-1">
            @if($product->stock > 0)
                <span class="text-green-600">En stock ({{ $product->stock }} disponibles)</span>
            @else
                <span class="text-red-600">Sin stock</span>
            @endif
        </p>

        @auth              
            <form method="POST" action="{{ route('wishlist.toggle', $product) }}" class="mt-2">
                @csrf
                @php
                $inWishlist = auth()->user()->wishlist()->where('product_id', $product->id)->exists();
                @endphp
                <button type="submit" class="text-sm {{ $inWishlist ? 'text-red-600' : 'text-gray-500' }} hover:underline">
                    {{ $inWishlist ? '❤️ Quitar de mis deseos' : '🤍 Agregar a mis deseos' }}
                </button>
            </form>

            @if($product->stock > 0)
                <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-4 flex items-center gap-3">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                           class="w-20 border-gray-300 rounded shadow-sm text-sm">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                        Agregar al carrito
                    </button>
                </form>
            @endif
        @else
            <p class="mt-4 text-sm text-gray-500">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Iniciá sesión</a> para comprar este producto.
            </p>
        @endauth

        <p class="text-gray-700 mt-4">{{ $product->description }}</p>

        <hr class="my-6">

        
        <h2 class="text-lg font-semibold mb-3">Reseñas ({{ $product->reviews->count() }})</h2>

       
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded text-sm mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded text-sm mb-4">
                {{ session('error') }}
            </div>
        @endif

        
        @auth
            <div class="bg-slate-100 p-5 rounded-3xl border border-slate-200 mb-6">
                <h3 class="text-sm font-semibold text-slate-900 mb-3">Deja tu opinión sobre este producto</h3>
                <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-slate-700 mb-1">Puntuación</label>
                        <select name="rating" class="w-full md:w-40 rounded border border-slate-300 bg-white text-slate-900 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                            <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                            <option value="4">⭐⭐⭐⭐ (4/5)</option>
                            <option value="3">⭐⭐⭐ (3/5)</option>
                            <option value="2">⭐⭐ (2/5)</option>
                            <option value="1">⭐ (1/5)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-medium text-slate-700 mb-1">Comentario</label>
                        <textarea name="comment" rows="3" required placeholder="Escribe tu opinión..." class="w-full border border-slate-300 bg-white text-slate-900 text-sm rounded shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-3 py-1.5 rounded text-sm hover:bg-blue-700">
                        Enviar reseña
                    </button>
                </form>
            </div>
        @endauth

       
        @forelse($product->reviews as $review)
            <div class="border-b border-slate-200 py-4">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-900">
                        {{ $review->user->name ?? 'Usuario' }}
                    </p>
                    <span class="text-xs text-amber-600">
                        {{ str_repeat('⭐', $review->rating) }} ({{ $review->rating }}/5)
                    </span>
                </div>
                <p class="text-sm text-slate-700 mt-2">{{ $review->comment }}</p>
                <span class="text-xs text-slate-500 block mt-2">{{ $review->created_at->diffForHumans() }}</span>
            </div>
        @empty
            <p class="text-sm text-slate-600">Todavía no hay reseñas para este producto.</p>
        @endforelse
    </div>
</x-app-layout>