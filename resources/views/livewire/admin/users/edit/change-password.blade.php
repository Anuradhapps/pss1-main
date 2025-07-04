<div>
    <x-2col>
        <x-slot name="left">
            <h3 class="mb-4 text-2xl font-semibold text-white">Change Password</h3>
            <p class="max-w-md mb-3 leading-relaxed text-gray-300">
                Ensure your account is using a long, random password to stay secure.
            </p>
            <p class="max-w-md text-sm leading-relaxed text-gray-400">
                Use a password manager. We recommend
                <a href="https://1password.com/password-generator/" target="_blank" rel="noopener"
                    class="break-words text-emerald-400 hover:underline">
                    1Password’s password generator
                </a>
                for creating and storing passwords.
            </p>
        </x-slot>

        <x-slot name="right">
            <div class="w-full max-w-md p-6 bg-gray-800 shadow-lg rounded-xl">

                <x-form wire:submit.prevent="update" method="put" class="space-y-6">

                    <div
                        class="p-4 text-sm leading-relaxed border rounded-md bg-emerald-600 bg-opacity-30 border-emerald-500 text-emerald-100">
                        <p class="font-semibold text-white">New password must meet these requirements:</p>
                        <ul class="mt-2 ml-6 space-y-1 list-disc">
                            <li>At least 8 characters in length</li>
                            <li>At least one lowercase letter</li>
                            <li>At least one uppercase letter</li>
                            <li>At least one digit</li>
                        </ul>
                    </div>
                    <div class="p-2 bg-gray-500 rounded-lg">
                        <x-form.input wire:model.defer="newPassword" type="password" label="New Password"
                            name="newPassword" required autocomplete="new-password"
                            class="text-gray-200 bg-gray-900 border-gray-700 focus:border-emerald-500 focus:ring-emerald-400" />

                        <x-form.input wire:model.defer="confirmPassword" type="password" label="Confirm Password"
                            name="confirmPassword" required autocomplete="new-password"
                            class="text-gray-200 bg-gray-900 border-gray-700 focus:border-emerald-500 focus:ring-emerald-400" />

                        <x-button
                            class="w-full py-2 font-semibold text-white rounded-lg shadow-md bg-emerald-600 hover:bg-emerald-700">
                            Change Password
                        </x-button>
                    </div>


                    @include('errors.messages')

                </x-form>
            </div>
        </x-slot>
    </x-2col>
</div>
