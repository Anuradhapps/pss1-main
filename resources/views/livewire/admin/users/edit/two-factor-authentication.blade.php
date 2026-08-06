<div wire:poll>
    <x-2col>
        <x-slot name="left">
            <h3 class="mb-4 text-2xl font-semibold text-slate-900 dark:text-white">Two-Factor Authentication</h3>

            @if (auth()->user()->two_fa_active == 'No')
                <p class="mb-3 leading-relaxed text-slate-600 dark:text-gray-300">
                    Add additional security to your account using two-factor authentication.
                </p>

                <p class="mb-1 font-semibold text-slate-800 dark:text-gray-200">Why do I need this?</p>
                <p class="mb-3 leading-relaxed text-slate-600 dark:text-gray-300">
                    Passwords can get stolen—especially if you use the same password for multiple sites. Adding Two-Step
                    Verification means that even if your password is stolen, your account remains secure.
                </p>

                <p class="mb-1 font-semibold text-slate-800 dark:text-gray-200">How does it work?</p>
                <p class="mb-3 leading-relaxed text-slate-600 dark:text-gray-300">
                    After you turn on Two-Step Verification, signing in will be a little different: you'll enter your
                    password as usual. Then, open your Authenticator app and enter the generated code into the form
                    below.
                </p>
            @endif
        </x-slot>

        <x-slot name="right">
            <div
                class="w-full max-w-md rounded-xl border border-slate-200 bg-white p-6 shadow-lg transition-colors dark:border-slate-700 dark:bg-slate-800">

                @if (auth()->user()->two_fa_active == 'Yes' && auth()->user()->two_fa_secret_key != '')
                    <p class="mb-5 text-slate-600 dark:text-gray-300">
                        Your two-factor authentication is enabled. To disable it, click the button below.
                    </p>
                    <x-button wire:click="remove"
                        class="w-full py-2 font-semibold bg-red-600 rounded-lg shadow-md hover:bg-red-700">
                        Turn Off 2FA
                    </x-button>
                @else
                    <p class="mb-3 leading-relaxed text-slate-600 dark:text-gray-300">
                        Authenticator apps generate random codes you can use to sign in. They do not have access to your
                        password or account information.
                    </p>
                    <p class="mb-4 text-slate-600 dark:text-gray-300">
                        We recommend using apps like <span class="font-semibold text-emerald-400">1Password</span> or
                        <span class="font-semibold text-emerald-400">Authy</span>.
                    </p>

                    <div class="mb-4">
                        <img src="{{ $inlineUrl }}" alt="Authenticator QR Code"
                            class="mx-auto rounded-md shadow-md" />
                    </div>

                    <p class="mb-4 text-slate-600 dark:text-gray-300 break-words">
                        Scan the QR code in your authenticator app, or manually enter this key:
                        <span
                            class="px-2 py-1 font-mono bg-slate-100 dark:bg-gray-700 rounded text-emerald-600 dark:text-emerald-400">{{ $secretKey }}</span>
                    </p>

                    <x-form wire:submit.prevent="update" method="put"
                        class="space-y-5 rounded-lg bg-white p-1 transition-colors dark:bg-slate-800">

                        <x-form.input wire:model.defer="code" label="Authentication Code" name="code" required
                            autocomplete="one-time-code"
                            class="border-slate-300 bg-white text-slate-900 focus:border-emerald-500 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100"
                            label-class="text-slate-700 dark:text-gray-300" />

                        <x-button
                            class="w-full py-2 font-semibold rounded-lg shadow-md bg-emerald-600 hover:bg-emerald-700">
                            Turn On 2FA
                        </x-button>

                        @include('errors.success')

                    </x-form>
                @endif
            </div>
        </x-slot>
    </x-2col>
</div>
