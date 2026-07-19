<div class="flex min-h-screen bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
    
    <!-- Left Side: Branding / Showcase (Hidden on mobile & tablet, visible on lg screens) -->
    <div class="hidden lg:flex lg:w-1/2 relative items-center justify-center overflow-hidden bg-slate-900">
        <!-- Abstract Premium Background Gradients -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary via-indigo-800 to-slate-900 opacity-95 z-0"></div>
        
        <!-- Geometric Pattern Overlay for Texture -->
        <div class="absolute inset-0 z-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <!-- Content -->
        <div class="relative z-10 flex flex-col items-center justify-center text-center p-12 text-white">
            <!-- Large Logo -->
            <a href="/" class="group flex flex-col items-center mb-8 transform transition-transform hover:scale-105 duration-300">
                <div class="bg-white/10 p-4 rounded-3xl backdrop-blur-sm border border-white/20 shadow-2xl mb-6 group-hover:bg-white/20 transition-colors">
                    <img src="{{ asset('images/LOGO.png') }}" alt="Logo" class="h-32 w-32 object-contain drop-shadow-xl" />
                </div>
                <h1 class="text-4xl font-extrabold tracking-tight mb-2 text-white drop-shadow-md">
                    National Pest
                </h1>
                <h1 class="text-3xl font-bold tracking-tight text-emerald-400 drop-shadow-md">
                    Surveillance System
                </h1>
            </a>
            
            <p class="text-lg font-medium text-indigo-100/80 max-w-md mx-auto leading-relaxed drop-shadow-sm mt-4">
                Empowering agricultural officers with real-time data for effective pest monitoring and management across Sri Lanka.
            </p>
        </div>
    </div>

    <!-- Right Side: Form Container (Full width on mobile, half width on lg screens) -->
    <div class="flex-1 flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 py-12 bg-surface-light dark:bg-surface-dark z-10 relative lg:rounded-l-3xl lg:shadow-[-20px_0_40px_-15px_rgba(0,0,0,0.1)]">
        
        <!-- Mobile Logo (Visible only on mobile/tablet) -->
        <div class="lg:hidden w-full max-w-md flex justify-center mb-8">
            <a href="/" class="transform transition hover:scale-105">
                <x-logo-light class="block dark:hidden"></x-logo-light>
                <x-logo-dark class="hidden dark:block"></x-logo-dark>
            </a>
        </div>

        <!-- Form Card -->
        <div {{ $attributes->merge(['class' => 'w-full max-w-md p-8 sm:p-10 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-colors duration-300 relative overflow-hidden']) }}>
            <!-- Decorative subtle top highlight bar -->
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary via-emerald-400 to-primary"></div>
            
            {{ $slot }}
        </div>
        
        <!-- Footer under form -->
        <div class="mt-10 text-center text-sm font-medium text-slate-500 dark:text-slate-400 lg:max-w-md w-full flex flex-col items-center gap-1">
            <span>&copy; {{ date('Y') }} National Plant Protection Service</span>
            <span class="text-slate-400 dark:text-slate-500">Department of Agriculture, Sri Lanka</span>
        </div>
    </div>

</div>
