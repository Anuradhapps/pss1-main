<x-guest-layout>
    @section('title', 'Reset Password')

    <x-auth-card
        class="mx-auto max-w-md rounded-lg bg-white p-6 text-slate-900 shadow-xl dark:bg-slate-900 dark:text-white">
        <!-- Page Title -->
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Reset Password</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
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
                <label for="email" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Email
                    Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    placeholder="you@example.com"
                    class="w-full border border-slate-300 bg-white px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder-slate-500">
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition duration-300 hover:bg-blue-700 hover:shadow-md">
                Send Reset Email
            </button>

            <!-- Back to Login -->
            <div class="text-center text-sm text-slate-500 dark:text-slate-400">
                <a href="{{ route('login') }}" class="underline transition duration-200 hover:text-blue-400">
                    Back to Login
                </a>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
