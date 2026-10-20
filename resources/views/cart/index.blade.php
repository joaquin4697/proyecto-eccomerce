<x-app-layout>
    <h1 class="text-2xl font-bold mb-6">Mi carrito</h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    @if($cartItems->isEmpty())
        <p class="text-gray-500">Tu carrito está vacío. <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Ver catálogo</a></p>
    @else
        <div class="bg-white rounded shadow overflow-hidden mb-6">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-3">Producto</th>
                        <th class="px-4 py-3">Precio unitario</th>
                        <th class="px-4 py-3">Cantidad</th>
                        <th class="px-4 py-3">Subtotal</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr class="border-t">
                            <td class="px-4 py-3">{{ $item->product->name }}</td>
                            <td class="px-4 py-3">{{ $item->product->formatted_price }}</td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                           max="{{ $item->product->stock }}" class="w-16 border-gray-300 rounded text-sm">
                                    <button type="submit" class="text-blue-600 hover:underline text-xs">Actualizar</button>
                                </form>
                            </td>
                            <td class="px-4 py-3">${{ number_format($item->subtotal(), 2, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('cart.remove', $item) }}"
                                      onsubmit="return confirm('¿Quitar este producto del carrito?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs">Quitar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded shadow p-6 max-w-md ml-auto">
            <p class="text-lg font-bold mb-4">Total: ${{ number_format($total, 2, ',', '.') }}</p>

            @if($addresses->isEmpty())
                <p class="text-sm text-red-600">
                    No tenés ninguna dirección cargada. Contactá al administrador o agregá una desde tu perfil.
                </p>
            @else
                <form method="POST" action="{{ route('cart.checkout') }}" class="space-y-3">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dirección de envío</label>
                        <select name="address_id" class="w-full border-gray-300 rounded shadow-sm text-sm">
                            @foreach($addresses as $address)
                                <option value="{{ $address->id }}">
                                    {{ $address->street }}, {{ $address->city }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded text-sm hover:bg-green-700">
                        Confirmar pedido
                    </button>
                </form>
            @endif
        </div>
    @endif
</x-app-layout>