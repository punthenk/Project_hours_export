<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name Field -->
        <div>
            <!-- Custom Label -->
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>

            <!-- Custom Input matching login style -->
            <input id="name" class="w-full border-none rounded-lg px-3 py-2 text-sm bg-gray-200
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white" type="text" name="name"
                value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Your Name" />
            <!-- Error messages (assuming $errors is available) -->
            @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address Field -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <input id="email" class="w-full border-none rounded-lg px-3 py-2 text-sm bg-gray-200
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white" type="email" name="email"
                value="{{ old('email') }}" required autocomplete="username" placeholder="you@example.com" />
            @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Field -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input id="password" class="w-full border-none rounded-lg px-3 py-2 text-sm bg-gray-200
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white" type="password"
                name="password" required autocomplete="new-password" placeholder="••••••••" />
            @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password Field -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm
                Password</label>
            <input id="password_confirmation" class="w-full border-none rounded-lg px-3 py-2 text-sm bg-gray-200
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white" type="password"
                name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            @error('password_confirmation')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Register Button -->
        <div class="pt-2">
            <button type="submit"
                class="w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-2.5 rounded-lg transition duration-150 ease-in-out shadow-md disabled:bg-gray-400">
                Register
            </button>
        </div>
    </form>
    <p class="mt-8 text-center text-sm text-gray-500">
        Already have an account?
        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
            Log in here
        </a>
    </p>
</x-guest-layout>
