<x-app-layout>
    <div class="max-w-md mx-auto bg-slate-100 p-8 rounded-3xl shadow-xl ring-1 ring-slate-200">
        <h1 class="text-2xl font-bold text-slate-900 mb-6">Iniciar sesión</h1>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-900">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="mt-1 w-full border border-slate-300 bg-slate-50 text-slate-900 placeholder-slate-500 rounded shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-900">Contraseña</label>
                <input type="password" name="password"
                       class="mt-1 w-full border border-slate-300 bg-slate-50 text-slate-900 placeholder-slate-500 rounded shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remember">
                Recordarme
            </label>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Iniciar sesión
            </button>
        </form>

        <p class="text-sm text-gray-600 mt-4">
            ¿No tenés cuenta?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Registrate</a>
        </p>
    </div>
</x-app-layout>