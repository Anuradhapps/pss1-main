<div>
    <div
        class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden h-full flex flex-col">

        <!-- Header -->
        <div
            class="p-6 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-slate-900/50">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-user-circle text-primary text-xl"></i> Account Settings
            </h2>
            <div class="flex items-center space-x-1 text-xs font-medium text-slate-500 dark:text-slate-400 select-none">
                <span class="text-primary">*</span>
                <span>= required</span>
            </div>
        </div>

        <!-- Form -->
        <x-form wire:submit.prevent="update" method="put" class="p-6 space-y-6 flex-1 flex flex-col">

            <div class="space-y-6 flex-1">
                <!-- Name -->
                <x-form.input wire:model.defer="name" label='Name *' name="name" required />

                <!-- Email -->
                <x-form.input wire:model.defer="email" label='Email *' name="email" type="email" required
                    class="text-gray-100 bg-gray-800 border border-gray-700 focus:border-emerald-500 focus:ring-emerald-500"
                    label-class="text-gray-300" />
                <x-form.select wire:model.defer="role" label="Role *" name="role" required
                    class="text-gray-100 bg-gray-800 border border-gray-700 focus:border-emerald-500 focus:ring-emerald-500"
                    label-class="text-gray-300">
                    <option value="">Select Role</option>

                    @foreach ($roles as $roleItem)
                        <option value="{{ $roleItem->id }}">
                            {{ $roleItem->name }}
                        </option>
                    @endforeach
                </x-form.select>
                <!-- Image Upload -->
                <x-form.input wire:model="image" label='Upload Image' name="image" type="file"
                    class="text-gray-100 bg-gray-800 border border-gray-700 focus:border-emerald-500 focus:ring-emerald-500 file:mr-4 file:py-1 file:px-3 file:border-0 file:bg-emerald-600 file:text-white file:hover:bg-emerald-700"
                    label-class="text-gray-300" />

                <!-- Image Preview -->
                @if ($image || storage_exists($user->image))
                    <div
                        class="mt-4 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-200 dark:border-slate-700/60 inline-block">
                        @if ($image)
                            <p
                                class="mb-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Photo Preview:</p>
                            <img src="{{ $image->temporaryUrl() }}" alt="Photo Preview"
                                class="object-cover w-24 h-24 rounded-xl shadow-sm border border-slate-200 dark:border-slate-600" />
                        @elseif(storage_exists($user->image))
                            <p
                                class="mb-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Current Photo:</p>
                            <img src="{{ storage_url($user->image) }}" alt="{{ $user->name }}"
                                class="object-cover w-24 h-24 rounded-xl shadow-sm border border-slate-200 dark:border-slate-600" />
                        @endif
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-slate-200 dark:border-slate-800 mt-auto">
                <button type="submit"
                    class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-emerald-600 rounded-xl shadow-sm hover:shadow-primary/30 transition-all">
                    <i class="fas fa-save"></i> Update Profile
                </button>
            </div>

            <!-- Error Messages -->
            @include('errors.messages')

        </x-form>
    </div>
</div>
