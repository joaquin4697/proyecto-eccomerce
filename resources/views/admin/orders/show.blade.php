<x-app-layout>
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Volver a pedidos</a>

    <h1 class="text-2xl font-bold mt-4 mb-6">Pedido #{{ $order->id }}</h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="md:col-span-2 bg-cyan-50 rounded-3xl shadow-sm border border-cyan-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-slate-900 text-lg">Productos del pedido</h2>
                <span class="text-sm text-slate-500">Total items: {{ $order->items->count() }}</span>
            </div>
            <table class="w-full text-sm text-left">
                <thead class="bg-cyan-100 text-slate-700">
                    <tr>
                        <th class="py-3 px-2">Producto</th>
                        <th class="py-3 px-2">Cantidad</th>
                        <th class="py-3 px-2">Precio unitario</th>
                        <th class="py-3 px-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr class="border-b last:border-b-0 hover:bg-white transition">
                            <td class="py-3 px-2 text-slate-800">{{ $item->product->name }}</td>
                            <td class="py-3 px-2 text-slate-700">{{ $item->quantity }}</td>
                            <td class="py-3 px-2 text-slate-700">${{ number_format($item->unit_price, 2, ',', '.') }}</td>
                            <td class="py-3 px-2 text-slate-900 font-semibold">${{ number_format($item->quantity * $item->unit_price, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 rounded-3xl bg-white border border-cyan-100 px-4 py-3 text-right">
                <p class="text-slate-900 font-semibold text-lg">Total: ${{ number_format($order->total, 2, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-cyan-100 p-6 space-y-5">
            <div class="bg-cyan-50 rounded-3xl p-4">
                <h2 class="font-semibold mb-2 text-slate-900">Cliente</h2>
                <p class="text-sm text-slate-700">{{ $order->user->name }}</p>
                <p class="text-sm text-slate-700">{{ $order->user->email }}</p>
            </div>

            @if($order->address)
                <div class="bg-cyan-50 rounded-3xl p-4">
                    <h2 class="font-semibold mb-2 text-slate-900">Dirección de envío</h2>
                    <p class="text-sm text-slate-700">
                        {{ $order->address->street }}, {{ $order->address->city }}
                    </p>
                </div>
            @endif

            <div class="bg-cyan-50 rounded-3xl p-4">
                <h2 class="font-semibold mb-2 text-slate-900">Estado actual</h2>
                <span class="inline-block bg-cyan-100 text-cyan-700 rounded-full px-3 py-1 text-sm font-semibold">{{ $order->status->label() }}</span>
            </div>

            <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="space-y-3">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-sm font-medium text-slate-700">Cambiar estado</label>
                    <select name="status" class="w-full border border-slate-300 rounded-xl shadow-sm text-sm bg-white px-3 py-2">
                        @foreach(\App\Enums\OrderStatus::cases() as $status)
                            <option value="{{ $status->value }}" @selected($order->status === $status)>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full bg-cyan-600 text-white py-2 rounded-xl text-sm hover:bg-cyan-500">
                    Actualizar estado
                </button>
            </form>
        </div>

    </div>
</x-app-layout>