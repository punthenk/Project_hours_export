<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <!-- Custom Label matching previous style -->
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>

            <!-- Custom Input matching previous style -->
            <input id="email" class="w-full border-none rounded-lg px-3 py-2 text-sm bg-gray-200
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white" type="email" name="email"
                value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com" />
            <!-- Error messages (optional, assuming $errors is available in Blade context) -->
            @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <!-- Custom Label matching previous style -->
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>

            <!-- Custom Input matching previous style -->
            <input id="password" class="w-full border-none rounded-lg px-3 py-2 text-sm bg-gray-200
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white" type="password"
                name="password" required autocomplete="current-password" placeholder="••••••••" />
            <!-- Error messages (optional, assuming $errors is available in Blade context) -->
            @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-900">Remember me</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
            <!-- Forgot Password Link matching previous style -->
            <a class="text-sm text-indigo-600 hover:text-indigo-500 font-medium" href="{{ route('password.request') }}">
                Forgot your password?
            </a>
            @endif

            <!-- Login Button matching previous style -->
            <button type="submit"
                class="bg-gray-900 hover:bg-gray-800 text-white font-semibold px-4 py-2 rounded-lg transition duration-150 ease-in-out shadow-md disabled:bg-gray-400">
                Log In
            </button>
        </div>
    </form>
    <p class="mt-8 text-center text-sm text-gray-500">
        You do not have an acount?
        <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
            Register here
        </a>
    </p>
</x-guest-layout>
