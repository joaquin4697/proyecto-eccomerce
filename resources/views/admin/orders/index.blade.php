<x-app-layout>
    <h1 class="text-2xl font-bold mb-6">Pedidos</h1>

    <form method="GET" class="mb-4 flex flex-col sm:flex-row gap-4 items-end">
        <div class="w-full sm:w-1/3">
            <label class="block text-sm font-medium text-slate-700 mb-1">Filtrar por estado</label>
            <select name="status" class="w-full border border-slate-300 rounded-xl shadow-sm text-sm bg-white px-3 py-2" onchange="this.form.submit()">
                <option value="">Todos</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->value }}" @selected(request('status') === $status->value)>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <div class="space-y-4">
        @foreach($orders as $order)
            <div class="bg-white rounded-3xl shadow-sm border border-cyan-100 p-5">
                <div class="grid grid-cols-1 sm:grid-cols-5 gap-4 items-center">
                    <div>
                        <p class="text-sm text-slate-500">Pedido #{{ $order->id }}</p>
                        <p class="font-semibold text-slate-900">{{ $order->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Total</p>
                        <p class="font-semibold text-slate-900">${{ number_format($order->total, 2, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Estado</p>
                        <span class="inline-flex bg-cyan-50 text-cyan-700 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $order->status->label() }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Fecha</p>
                        <p class="font-semibold text-slate-900">{{ $order->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="text-right sm:text-left">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-cyan-600 font-semibold hover:text-cyan-800">Ver detalle</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $orders->links() }}</div>
</x-app-layout>