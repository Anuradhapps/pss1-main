<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-8 sm:px-6 lg:px-8 space-y-8">

        <!-- Controls Header -->
        <div
            class="flex justify-between items-center bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-4 mb-4">
            <a href="{{ url()->previous() }}"
                class="flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary transition-colors font-medium px-2">
                <i class="fas fa-arrow-left"></i>
                <span class="hidden sm:inline">Go Back</span>
            </a>

            <button id="help-theme-toggle" type="button"
                class="flex items-center gap-2 text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/50 rounded-xl px-4 py-2 transition-colors">
                <i id="help-theme-toggle-dark-icon" class="hidden fas fa-moon text-indigo-500"></i>
                <i id="help-theme-toggle-light-icon" class="hidden fas fa-sun text-amber-500"></i>
                <span class="text-sm font-semibold">Switch Theme</span>
            </button>
        </div>

        <!-- Header -->
        <div class="text-center space-y-3 pb-2">
            <div
                class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary/10 dark:bg-primary/20 mb-2">
                <i class="fas fa-book-open text-2xl text-primary"></i>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                National Pest Surveillance System
            </h1>
            <p class="text-lg text-primary dark:text-emerald-400 font-medium tracking-wide">
                User Manual & Guidance
            </p>
        </div>

        <!-- Introduction -->
        <section
            class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 sm:p-8">
            <div class="flex items-center gap-3 mb-4">
                <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Introduction</h2>
            </div>
            <div class="space-y-4 text-slate-600 dark:text-slate-400 leading-relaxed">
                <p>This manual is designed to help Subject Matter Officers (SMOs) at Agrarian Service Centers use the
                    NPSS for effective rice pest monitoring across Sri Lanka.</p>
                <p>The NPSS is a web-based platform that is user-friendly, accessible from any internet-connected
                    device, and optimized for pest data collection at the AI Range level.</p>
            </div>
        </section>

        <!-- Main Steps Header -->
        <div class="flex items-center gap-4 py-4">
            <div class="flex-grow h-px bg-slate-200 dark:bg-slate-800"></div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white px-4">Main Steps to Use NPSS</h2>
            <div class="flex-grow h-px bg-slate-200 dark:bg-slate-800"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Step 1 -->
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 hover:shadow-md transition-shadow">
                <h3 class="flex items-center gap-3 text-lg font-bold text-slate-900 dark:text-white mb-4">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary text-white text-sm">1</span>
                    Accessing the System
                </h3>
                <ul class="list-disc list-inside space-y-2 text-slate-600 dark:text-slate-400 mb-6">
                    <li>Open your web browser.</li>
                    <li>Visit: <a href="https://uat.pps.doa.gov.lk"
                            class="text-primary hover:underline font-medium">https://uat.pps.doa.gov.lk</a></li>
                    <li>Or scan the QR code below:</li>
                </ul>
                <div
                    class="flex flex-col items-center p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-100 dark:border-slate-700">
                    <img src="{{ asset('images/qr.jpg') }}" alt="NPSS QR Code"
                        class="w-32 h-32 object-contain rounded-lg shadow-sm">
                    <p class="text-xs text-slate-500 mt-3 font-medium">NPSS QR Code</p>
                </div>
            </div>

            <!-- Account Access Alert -->
            <div
                class="bg-primary/5 dark:bg-primary/10 rounded-2xl shadow-sm border border-primary/20 dark:border-primary/30 p-6 flex flex-col justify-center">
                <h3 class="flex items-center gap-3 text-lg font-bold text-slate-900 dark:text-white mb-4">
                    <i class="fas fa-lock text-primary"></i>
                    Account Access
                </h3>
                <div class="space-y-4 text-slate-600 dark:text-slate-400">
                    <p>If you <strong>already have an account</strong>, please <a href="{{ route('login') }}"
                            class="text-primary hover:underline font-semibold">log in here</a>.</p>
                    <p>If you <strong>do not have an account</strong> yet, you need to <a href="{{ route('register') }}"
                            class="text-primary hover:underline font-semibold">register for a new account</a> before you
                        can log in and use the system.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 hover:shadow-md transition-shadow">
                <h3 class="flex items-center gap-3 text-lg font-bold text-slate-900 dark:text-white mb-4">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary text-white text-sm">2</span>
                    Registering an Account
                </h3>
                <ol class="list-decimal list-inside space-y-3 text-slate-600 dark:text-slate-400">
                    <li>Click <strong>Register</strong>.</li>
                    <li>Fill in the required details:
                        <ul class="list-disc ml-6 mt-2 space-y-1 text-sm">
                            <li>Name</li>
                            <li>Email (e.g., kamal@gmail.com)</li>
                            <li>Password (e.g., Kamal@2025)</li>
                        </ul>
                    </li>
                    <li>Click <strong>Submit</strong>. You'll be redirected to the dashboard.</li>
                </ol>
            </div>

            <!-- Step 3 -->
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 hover:shadow-md transition-shadow">
                <h3 class="flex items-center gap-3 text-lg font-bold text-slate-900 dark:text-white mb-4">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary text-white text-sm">3</span>
                    Logging In
                </h3>
                <ul class="list-disc list-inside space-y-3 text-slate-600 dark:text-slate-400">
                    <li>Enter your registered Email and Password.</li>
                    <li>Click <strong>Login</strong> to access the Dashboard.</li>
                </ul>
            </div>

            <!-- Step 4 -->
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 hover:shadow-md transition-shadow">
                <h3 class="flex items-center gap-3 text-lg font-bold text-slate-900 dark:text-white mb-4">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary text-white text-sm">4</span>
                    Navigating the System
                </h3>
                <p class="text-slate-600 dark:text-slate-400">Tap the ☰ (three-bar) menu and select <strong
                        class="text-slate-800 dark:text-slate-200">Collector</strong> to start data entry.</p>
            </div>

            <!-- Step 5 -->
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 hover:shadow-md transition-shadow">
                <h3 class="flex items-center gap-3 text-lg font-bold text-slate-900 dark:text-white mb-4">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary text-white text-sm">5</span>
                    Entering Collector Info
                </h3>
                <p class="text-slate-600 dark:text-slate-400 mb-3">On first login, fill the Collector Info Form:</p>
                <ul class="list-disc list-inside ml-2 space-y-1 text-sm text-slate-600 dark:text-slate-400">
                    <li>Phone Number</li>
                    <li>Region: Provincial / Interprovincial / Mahaveli</li>
                    <li>Location: Province → District → ASC → AI Range → Village</li>
                    <li>GPS Location (auto/manual)</li>
                    <li>Rice Variety & Establishment Date</li>
                </ul>
            </div>

            <!-- Step 6 & 7 -->
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 hover:shadow-md transition-shadow md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="flex items-center gap-3 text-lg font-bold text-slate-900 dark:text-white mb-4">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary text-white text-sm">6</span>
                        Managing Data
                    </h3>
                    <ul class="list-disc list-inside space-y-2 text-slate-600 dark:text-slate-400">
                        <li>Edit your collector information anytime.</li>
                        <li>Navigate to <strong class="text-slate-800 dark:text-slate-200">Pest Data</strong> to input
                            field observations.</li>
                    </ul>
                </div>
                <div>
                    <h3 class="flex items-center gap-3 text-lg font-bold text-slate-900 dark:text-white mb-4">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary text-white text-sm">7</span>
                        Adding Pest Data
                    </h3>
                    <ul class="list-disc list-inside space-y-1 text-sm text-slate-600 dark:text-slate-400">
                        <li>Data Collecting Date & Growth Stage Code</li>
                        <li>Temperature & Rainy Days</li>
                        <li>Tillers SP1–SP10 (mandatory)</li>
                        <li>Select Pests (if applicable)</li>
                    </ul>
                </div>
            </div>

            <!-- Mobile Shortcuts -->
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 hover:shadow-md transition-shadow md:col-span-2">
                <h3 class="flex items-center gap-3 text-lg font-bold text-slate-900 dark:text-white mb-6">
                    <i class="fas fa-mobile-alt text-primary"></i>
                    Creating a Mobile Shortcut
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div
                        class="bg-slate-50 dark:bg-slate-800/50 p-5 rounded-xl border border-slate-100 dark:border-slate-700">
                        <h4 class="font-bold text-emerald-600 dark:text-emerald-400 mb-3 flex items-center gap-2">
                            <i class="fab fa-android"></i> For Android (Chrome)
                        </h4>
                        <ol class="list-decimal list-inside space-y-2 text-sm text-slate-600 dark:text-slate-400">
                            <li>Open Chrome and go to <a href="https://uat.pps.doa.gov.lk"
                                    class="text-primary hover:underline">uat.pps.doa.gov.lk</a></li>
                            <li>Tap the 3-dot menu (⋮)</li>
                            <li>Select "Add to Home screen" or "Install App"</li>
                            <li>Rename (e.g., "NPSS") and tap Add</li>
                        </ol>
                    </div>

                    <div
                        class="bg-slate-50 dark:bg-slate-800/50 p-5 rounded-xl border border-slate-100 dark:border-slate-700">
                        <h4 class="font-bold text-indigo-600 dark:text-indigo-400 mb-3 flex items-center gap-2">
                            <i class="fab fa-apple"></i> For iPhone/iPad (Safari)
                        </h4>
                        <ol class="list-decimal list-inside space-y-2 text-sm text-slate-600 dark:text-slate-400">
                            <li>Open Safari and go to <a href="https://uat.pps.doa.gov.lk"
                                    class="text-primary hover:underline">uat.pps.doa.gov.lk</a></li>
                            <li>Tap the Share icon (box with up arrow)</li>
                            <li>Select "Add to Home Screen"</li>
                            <li>Rename and tap Add</li>
                        </ol>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer Credits -->
        <section
            class="mt-12 p-8 bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 rounded-b-3xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm text-slate-600 dark:text-slate-400">
                <div class="space-y-2">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-3">
                        Prepared By</h3>
                    <p><strong class="text-slate-800 dark:text-slate-200">Dhammika Sarathchandra</strong><br>Agriculture
                        Instructor <br>National Plant Protection Service </p>
                    <p><strong class="text-slate-800 dark:text-slate-200">Darsha Anuradha</strong><br>Lead Developer &
                        Technical Assistant<br>AFACI Project / National Plant Protection Service</p>
                </div>

                <div class="space-y-2">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-3">
                        Directed By</h3>
                    <p><strong class="text-slate-800 dark:text-slate-200">Dr. K.M.D.W. Prabath
                            Nishantha</strong><br>Additional Director, National Plant Protection Service</p>
                    <div class="mt-6 pt-4 border-t border-slate-200 dark:border-slate-700">
                        <p class="italic text-slate-500">Department of Agriculture<br>National Plant Protection
                            Service<br>Gannoruwa, Peradeniya – Sri Lanka</p>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- Theme Toggle Script specific for Help Page -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var themeToggleDarkIcon = document.getElementById('help-theme-toggle-dark-icon');
            var themeToggleLightIcon = document.getElementById('help-theme-toggle-light-icon');

            // Initialize correct icon based on current theme
            if (document.documentElement.classList.contains('dark')) {
                themeToggleLightIcon.classList.remove('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
            }

            var themeToggleBtn = document.getElementById('help-theme-toggle');
            themeToggleBtn.addEventListener('click', function() {
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                if (localStorage.getItem('color-theme')) {
                    if (localStorage.getItem('color-theme') === 'light') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    }
                } else {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    }
                }
            });
        });
    </script>
</x-app-layout>
