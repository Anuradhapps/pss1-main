<div>
    <div
        class="flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-900">
        <div
            class="flex items-center justify-between border-b border-slate-200 bg-slate-50 p-6 dark:border-slate-800 dark:bg-slate-900/50">
            <h2 class="flex items-center gap-2 text-lg font-bold text-slate-900 dark:text-white">
                <i class="fas fa-user-circle text-primary text-xl"></i> Account Settings
            </h2>
            <div class="flex select-none items-center space-x-1 text-xs font-medium text-slate-500 dark:text-slate-400">
                <span class="text-primary">*</span>
                <span>= required</span>
            </div>
        </div>

        <x-form wire:submit.prevent="update" method="put" class="flex flex-1 flex-col space-y-6 p-6">
            <div class="flex-1 space-y-6">
                <x-form.input wire:model.defer="name" label='Name *' name="name" required />

                <x-form.input wire:model.defer="email" label='Email *' name="email" type="email" required
                    class="border-slate-300 bg-white text-slate-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                    label-class="text-slate-700 dark:text-slate-300" />
                <x-form.select wire:model.defer="role" label="Role *" name="role" required
                    class="border-slate-300 bg-white text-slate-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                    label-class="text-slate-700 dark:text-slate-300">
                    <option value="">Select Role</option>

                    @foreach ($roles as $roleItem)
                        <option value="{{ $roleItem->id }}">
                            {{ $roleItem->name }}
                        </option>
                    @endforeach
                </x-form.select>
                <x-form.input wire:model="image" label='Upload Image' name="image" type="file"
                    class="border-slate-300 bg-white text-slate-900 focus:border-emerald-500 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 file:mr-4 file:border-0 file:bg-emerald-600 file:px-3 file:py-1 file:text-white file:hover:bg-emerald-700"
                    label-class="text-slate-700 dark:text-slate-300" />

                @if ($image || storage_exists($user->image))
                    <div
                        class="mt-4 inline-block rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700/60 dark:bg-slate-800/50">
                        @if ($image)
                            <p
                                class="mb-3 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                Photo Preview:</p>
                            <img src="{{ $image->temporaryUrl() }}" alt="Photo Preview"
                                class="h-24 w-24 rounded-xl border border-slate-200 object-cover shadow-sm dark:border-slate-600" />
                        @elseif(storage_exists($user->image))
                            <p
                                class="mb-3 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                Current Photo:</p>
                            <img src="{{ storage_url($user->image) }}" alt="{{ $user->name }}"
                                class="h-24 w-24 rounded-xl border border-slate-200 object-cover shadow-sm dark:border-slate-600" />
                        @endif
                    </div>
                @endif
            </div>

            <div class="mt-auto border-t border-slate-200 pt-6 dark:border-slate-800">
                <button type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-primary px-6 py-2.5 text-sm font-bold text-white shadow-sm transition-all hover:bg-emerald-600 hover:shadow-primary/30 sm:w-auto">
                    <i class="fas fa-save"></i> Update Profile
                </button>
            </div>

            @include('errors.messages')
        </x-form>
    </div>
</div>
