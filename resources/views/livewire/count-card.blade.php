<x-ui.card padding="p-5" class="relative group cursor-pointer border-l-4 overflow-hidden {{ str_replace('from-', 'border-', explode(' ', $color)[0]) }}">
    <div class="absolute right-0 top-0 w-32 h-32 bg-gradient-to-br {{ $color }} opacity-10 rounded-bl-full -mr-8 -mt-8 transition-transform duration-500 group-hover:scale-110"></div>
    
    <div class="flex items-center justify-between relative z-10" wire:key="{{ $cardName }}">
        <div class="space-y-2">
            <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                {{ preg_replace('/(?<!\ )[A-Z]/', ' $0', $cardName) }}
            </p>
            <h3 class="text-3xl font-bold text-slate-900 dark:text-white" id="cardCount_{{ Str::slug($cardName) }}">
                {{ $userCount }}
            </h3>
        </div>
        
        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-gradient-to-br {{ $color }} text-white shadow-lg group-hover:shadow-xl transition-shadow duration-300">
            <i class="{{ $iconName }} text-xl"></i>
        </div>
    </div>

    <!-- Livewire Counter Logic -->
    <script>
        document.addEventListener('livewire:load', function() {
            let count = 0;
            const targetCount = @this.targetCount;
            const speed = 10; 
            const countLabel = document.getElementById('cardCount_{{ Str::slug($cardName) }}');

            const counter = setInterval(() => {
                if (count < targetCount) {
                    count++;
                    countLabel.textContent = count;
                    @this.set('userCount', count);
                } else {
                    clearInterval(counter);
                }
            }, speed);
        });
    </script>
</x-ui.card>
