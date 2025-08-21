<div class="w-full">
    <div class="flex items-center justify-between p-2 text-white bg-gradient-to-r {{ $color }} "
        wire:key="{{ $cardName }}">

        <div class="flex items-center space-x-3">
            <i class="{{ $iconName }} text-xl"></i>
            <span class="text-sm font-semibold sm:text-base">{{ preg_replace('/(?<!\ )[A-Z]/', ' $0', $cardName) }}
            </span>
        </div>

        <span id="cardCount_{{ Str::slug($cardName) }}" class="text-lg font-bold">{{ $userCount }}</span>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            let count = 0;
            const targetCount = @this.targetCount;
            const speed = 10; // Slow down a bit for readability
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
</div>
