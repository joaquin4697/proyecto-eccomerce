<x-app-layout>
    <h1 class="text-2xl font-bold mb-6">Panel de administración</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="{{ route('admin.categories.index') }}" class="bg-slate-100 p-6 rounded-3xl shadow hover:shadow-lg transition border border-slate-200">
            <h2 class="text-lg font-semibold text-slate-900">Categorías</h2>
            <p class="text-sm text-slate-600 mt-1">Gestionar categorías de productos</p>
        </a>

        <a href="{{ route('admin.products.index') }}" class="bg-slate-100 p-6 rounded-3xl shadow hover:shadow-lg transition border border-slate-200">
            <h2 class="text-lg font-semibold text-slate-900">Productos</h2>
            <p class="text-sm text-slate-600 mt-1">Gestionar catálogo de productos</p>
        </a>

        <a href="{{ route('admin.orders.index') }}" class="bg-slate-100 p-6 rounded-3xl shadow hover:shadow-lg transition border border-slate-200">
            <h2 class="text-lg font-semibold text-slate-900">Pedidos</h2>
            <p class="text-sm text-slate-600 mt-1">Ver y actualizar estados de pedidos</p>
        </a>
    </div>
</x-app-layout>