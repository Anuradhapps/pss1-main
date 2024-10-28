<div class="mb-1">
    <div  class="text-2xl font-bold text-white bg-gradient-to-r {{ $color }} p-2 rounded-lg flex gap-2 shadow-xl">
        <i  class="{{ $iconName }}"></i> 
        {{ $cardName }} <span id="cardCount" > {{ $userCount }}</span>
    </div>
    
    <script>
        document.addEventListener('livewire:load', function () {
            let count = 0;
            let targetCount = @this.targetCount; // Livewire's reactive property
            let speed = 1; // Adjust speed here for faster or slower animation
    
            const countLabel = document.getElementById('cardCount');
    
            const counter = setInterval(function() {
                if (count < targetCount) {
                    count++;
                    countLabel.textContent = count;
    
                    // Update the Livewire property to maintain reactivity
                    @this.set('userCount', count);
                } else {
                    clearInterval(counter);
                }
            }, speed);
        });
    </script>
    
</div>
