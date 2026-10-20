<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Tienda Online' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-emerald-50 min-h-screen flex flex-col text-slate-900">

    <header class="bg-emerald-700 shadow border-b border-emerald-800">
        <nav class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="font-bold text-xl text-white">Tienda Online</a>

            <div class="flex gap-4 items-center">
                @auth
                    <a href="{{ route('wishlist.index') }}" class="text-sm text-emerald-100 hover:text-white hover:underline">Mis deseos

                    </a>
                    
                    <a 
                        href="{{ route('orders.index') }}" class="text-sm text-emerald-100 hover:text-white hover:underline">Mis pedidos
                    </a>

                    <a href="{{ route('cart.index') }}" class="text-sm text-emerald-100 hover:text-white hover:underline">
                        Carrito ({{ auth()->user()->cartItems()->sum('quantity') }})
                    </a>

                    <span class="text-sm text-gray-600">Hola, {{ auth()->user()->name }}</span>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ url('/admin') }}" class="text-sm text-blue-600 hover:underline">Panel Admin</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:underline">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-emerald-100 hover:text-white hover:underline">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="text-sm bg-amber-500 text-slate-950 px-3 py-1.5 rounded hover:bg-amber-400">Registrarse</a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="flex-1 max-w-6xl mx-auto w-full px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer class="bg-emerald-700 border-t border-emerald-800 py-4 text-center text-sm text-emerald-50">
        Trabajo Final - Desarrollo Web con Laravel
    </footer>

</body>
</html>