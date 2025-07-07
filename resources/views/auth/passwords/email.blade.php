<x-guest-layout>
    @section('title', 'Reset Password')

    <x-auth-card class="max-w-md p-6 mx-auto text-white bg-gray-900 rounded-lg shadow-xl">
        <!-- Page Title -->
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold text-white">Reset Password</h1>
            <p class="mt-1 text-sm text-gray-400">
                Enter your email to receive a password reset link.
            </p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-200 bg-red-800 border border-red-600 rounded-md">
                <ul class="space-y-1 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Success Message -->
        @if (session('status'))
            <div class="p-4 mb-4 text-sm text-green-200 bg-green-800 border border-green-600 rounded-md">
                {{ session('status') }}
            </div>
        @endif

        <!-- Reset Form -->
        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Email Input -->
            <div>
                <label for="email" class="block mb-1 text-sm font-medium text-gray-300">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    placeholder="you@example.com"
                    class="w-full px-4 py-2 text-white placeholder-gray-500 bg-gray-800 border border-gray-700 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full px-5 py-3 text-sm font-semibold text-white transition duration-300 bg-blue-600 rounded-md hover:bg-blue-700 hover:shadow-md">
                Send Reset Email
            </button>

            <!-- Back to Login -->
            <div class="text-sm text-center text-gray-400">
                <a href="{{ route('login') }}" class="underline transition duration-200 hover:text-blue-400">
                    Back to Login
                </a>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
