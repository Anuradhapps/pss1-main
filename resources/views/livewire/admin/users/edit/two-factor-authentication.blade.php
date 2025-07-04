<div wire:poll>
    <x-2col>
        <x-slot name="left">
            <h3 class="mb-4 text-2xl font-semibold text-white">Two-Factor Authentication</h3>

            @if (auth()->user()->two_fa_active == 'No')
                <p class="mb-3 leading-relaxed text-gray-300">
                    Add additional security to your account using two-factor authentication.
                </p>

                <p class="mb-1 font-semibold text-gray-200">Why do I need this?</p>
                <p class="mb-3 leading-relaxed text-gray-300">
                    Passwords can get stolen—especially if you use the same password for multiple sites. Adding Two-Step
                    Verification means that even if your password is stolen, your account remains secure.
                </p>

                <p class="mb-1 font-semibold text-gray-200">How does it work?</p>
                <p class="mb-3 leading-relaxed text-gray-300">
                    After you turn on Two-Step Verification, signing in will be a little different: you'll enter your
                    password as usual. Then, open your Authenticator app and enter the generated code into the form
                    below.
                </p>
            @endif
        </x-slot>

        <x-slot name="right">
            <div class="w-full max-w-md p-6 bg-gray-800 shadow-lg rounded-xl">

                @if (auth()->user()->two_fa_active == 'Yes' && auth()->user()->two_fa_secret_key != '')
                    <p class="mb-5 text-gray-300">
                        Your two-factor authentication is enabled. To disable it, click the button below.
                    </p>
                    <x-button wire:click="remove"
                        class="w-full py-2 font-semibold bg-red-600 rounded-lg shadow-md hover:bg-red-700">
                        Turn Off 2FA
                    </x-button>
                @else
                    <p class="mb-3 leading-relaxed text-gray-300">
                        Authenticator apps generate random codes you can use to sign in. They do not have access to your
                        password or account information.
                    </p>
                    <p class="mb-4 text-gray-300">
                        We recommend using apps like <span class="font-semibold text-emerald-400">1Password</span> or
                        <span class="font-semibold text-emerald-400">Authy</span>.
                    </p>

                    <div class="mb-4">
                        <img src="{{ $inlineUrl }}" alt="Authenticator QR Code"
                            class="mx-auto rounded-md shadow-md" />
                    </div>

                    <p class="mb-4 text-gray-300 break-words">
                        Scan the QR code in your authenticator app, or manually enter this key:
                        <span
                            class="px-2 py-1 font-mono bg-gray-700 rounded text-emerald-400">{{ $secretKey }}</span>
                    </p>

                    <x-form wire:submit.prevent="update" method="put" class="p-1 space-y-5 bg-gray-500 rounded-lg">

                        <x-form.input wire:model.defer="code" label="Authentication Code" name="code" required
                            autocomplete="one-time-code"
                            class="text-gray-200 bg-gray-900 border-gray-700 focus:border-emerald-500 focus:ring-emerald-400"
                            label-class="text-gray-300" />

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
