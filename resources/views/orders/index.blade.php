<x-app-layout>
    <h1 class="text-2xl font-bold mb-6">Mis pedidos</h1>

    @if($orders->isEmpty())
        <p class="text-slate-600">Todavía no hiciste ningún pedido. <a href="{{ route('home') }}" class="text-cyan-600 hover:text-cyan-800 hover:underline">Ver catálogo</a></p>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-slate-100 rounded-3xl shadow-sm border border-slate-200 p-5">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <p class="text-sm text-slate-500">Pedido #{{ $order->id }}</p>
                            <p class="text-2xl font-semibold text-slate-900">${{ number_format($order->total, 2, ',', '.') }}</p>
                        </div>

                        <div class="flex flex-col gap-2 text-sm text-slate-600">
                            <span class="inline-flex items-center gap-2">
                                <span class="inline-block bg-cyan-50 text-cyan-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $order->status->label() }}
                                </span>
                            </span>
                            <span>Fecha: {{ $order->created_at->format('d/m/Y') }}</span>
                        </div>

                        <a href="{{ route('orders.show', $order) }}" class="text-cyan-600 font-semibold hover:text-cyan-800">Ver detalle</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $orders->links() }}</div>
    @endif
</x-app-layout>