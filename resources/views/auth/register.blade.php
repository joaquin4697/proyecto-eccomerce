<x-app-layout>
    <div class="max-w-md mx-auto bg-slate-100 p-8 rounded-3xl shadow-xl ring-1 ring-slate-200">
        <h1 class="text-2xl font-bold text-slate-900 mb-6">Crear cuenta</h1>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-900">Nombre</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="mt-1 w-full border border-slate-300 bg-slate-50 text-slate-900 placeholder-slate-500 rounded shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-900">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="mt-1 w-full border border-slate-300 bg-white text-slate-900 placeholder-slate-500 rounded shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-900">Contraseña</label>
                <input type="password" name="password"
                       class="mt-1 w-full border border-slate-300 bg-white text-slate-900 placeholder-slate-500 rounded shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-900">Confirmar contraseña</label>
                <input type="password" name="password_confirmation"
                       class="mt-1 w-full border border-slate-300 bg-white text-slate-900 placeholder-slate-500 rounded shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Registrarme
            </button>
        </form>

        <p class="text-sm text-slate-600 mt-4">
            ¿Ya tenés cuenta?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Iniciá sesión</a>
        </p>
    </div>
</x-app-layout>