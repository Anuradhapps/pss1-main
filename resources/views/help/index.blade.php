<x-app-layout>
    <div class="p-6 max-w-6xl mx-auto text-white space-y-8">

        <div class="text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-green-400">📘 National Pest Surveillance System (NPSS)
            </h1>
            <p class="text-lg mt-2 text-gray-300 italic">User Manual & Guidance </p>
        </div>

        <section class="space-y-4">
            <h2 class="text-2xl font-semibold text-yellow-300">📌 Introduction</h2>
            <p>This manual is designed to help Subject Matter Officers (SMOs) at Agrarian Service Centers use the
                NPSS for effective rice pest monitoring across Sri Lanka.</p>
            <p>The NPSS is a web-based platform that is user-friendly, accessible from any internet-connected device,
                and optimized for pest data collection at the AI Range level.</p>
        </section>

        <hr class="border-gray-600">

        <section class="space-y-4">
            <h2 class="text-2xl font-semibold text-green-300">🚀 Main Steps to Use NPSS</h2>

            <div class="bg-gray-800 p-4 rounded-md shadow-md space-y-4">
                <h3 class="text-xl font-bold text-yellow-300">1️⃣ Accessing the System</h3>
                <ul class="list-disc list-inside text-gray-300 space-y-1">
                    <li>Open your web browser.</li>
                    <li>Visit: <a href="https://uat.pps.doa.gov.lk"
                            class="text-blue-400 underline">https://uat.pps.doa.gov.lk</a></li>
                    <li>Or scan the QR code below:</li>
                </ul>
                <img src="{{ asset('images/qr.jpg') }}" alt="NPSS QR Code"
                    class="w-40 h-40 object-contain border rounded-md shadow-md mx-auto">
                <p class="text-center text-sm text-gray-400 mt-1">NPSS QR Code</p>
            </div>
            <div class="bg-gray-800 text-white p-4 rounded-md shadow-md mb-6">
                <h2 class="text-lg font-semibold mb-2">🔐 Account Access</h2>
                <p class="mb-2">
                    If you <strong>already have an account</strong>, please
                    <a href="{{ route('login') }}" class="text-blue-400 underline hover:text-blue-500">log in here</a>.
                </p>
                <p>
                    If you <strong>do not have an account</strong> yet, you need to
                    <a href="{{ route('register') }}" class="text-blue-400 underline hover:text-blue-500">register for a
                        new account</a>
                    before you can log in and use the system.
                </p>
            </div>


            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-gray-800 p-4 rounded-md shadow-md">
                    <h3 class="text-xl font-bold text-yellow-300">2️⃣ Registering an Account</h3>
                    <ol class="list-decimal list-inside space-y-2 text-gray-300">
                        <li>Click <strong>Register</strong>.</li>
                        <li>Fill required details:
                            <ul class="list-disc ml-4">
                                <li>Name</li>
                                <li>Email (e.g., kamal@gmail.com)</li>
                                <li>Password (e.g., Kamal@2025)</li>
                            </ul>
                        </li>
                        <li>Click <strong>Submit</strong>. You'll be redirected to the dashboard.</li>
                    </ol>
                </div>

                <div class="bg-gray-800 p-4 rounded-md shadow-md">
                    <h3 class="text-xl font-bold text-yellow-300">3️⃣ Logging In</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-300">
                        <li>Enter your Email and Password.</li>
                        <li>Click <strong>Login</strong> to access the Dashboard.</li>
                    </ul>
                </div>
            </div>

            <div class="bg-gray-800 p-4 rounded-md shadow-md space-y-2">
                <h3 class="text-xl font-bold text-yellow-300">4️⃣ Navigating the System</h3>
                <p>Tap the ☰ (three-bar) menu and select <strong>Collector</strong> to start data entry.</p>
            </div>

            <div class="bg-gray-800 p-4 rounded-md shadow-md space-y-3">
                <h3 class="text-xl font-bold text-yellow-300">5️⃣ Entering Collector Information</h3>
                <p>On first login, fill the Collector Info Form:</p>
                <ul class="list-disc list-inside ml-4 text-gray-300">
                    <li>Phone Number</li>
                    <li>Region: Provincial / Interprovincial / Mahaveli</li>
                    <li>Location: Province → District → ASC → AI Range → Village</li>
                    <li>GPS Location (auto/manual)</li>
                    <li>Rice Variety</li>
                    <li>Rice Establishment Date</li>
                </ul>
                <p>Click <strong>Save</strong> to view your data.</p>
            </div>

            <div class="bg-gray-800 p-4 rounded-md shadow-md space-y-3">
                <h3 class="text-xl font-bold text-yellow-300">6️⃣ Managing Collector Data</h3>
                <ul class="list-disc ml-4 text-gray-300">
                    <li>Edit your collector information.</li>
                    <li>Navigate to <strong>Pest Data</strong> to input observations.</li>
                </ul>
            </div>

            <div class="bg-gray-800 p-4 rounded-md shadow-md space-y-3">
                <h3 class="text-xl font-bold text-yellow-300">7️⃣ Adding Pest Data</h3>
                <ul class="list-disc ml-4 text-gray-300">
                    <li>Data Collecting Date</li>
                    <li>Growth Stage Code</li>
                    <li>Temperature</li>
                    <li>Rainy Days This Week</li>
                    <li>Tillers SP1–SP10 (mandatory)</li>
                    <li>Select Pests (if applicable)</li>
                    <li>Other Info (optional)</li>
                </ul>
                <p>Click <strong>Submit</strong> to save your data.</p>
            </div>

            <div class="bg-gray-800 p-4 rounded-md shadow-md space-y-3">
                <h3 class="text-xl font-bold text-yellow-300">8️⃣ Additional Features</h3>
                <ul class="list-disc ml-4 text-gray-300">
                    <li>Edit collector data anytime.</li>
                    <li>View and delete pest records.</li>
                    <li>Ensure all required fields are filled for accurate reports.</li>
                </ul>
            </div>

            <div class="bg-gray-800 p-4 rounded-md shadow-md space-y-3">
                <h3 class="text-xl font-bold text-yellow-300">9️⃣ Support</h3>
                <p class="text-gray-300">For help, contact the System Administrator at:</p>
                <p><strong>Department of Agriculture – National Plant Protection Service</strong></p>
            </div>

            <div class="bg-gray-800 p-4 rounded-md shadow-md space-y-3">
                <h3 class="text-xl font-bold text-yellow-300">🔟 Creating a Mobile Shortcut</h3>
                <p class="text-green-300 font-semibold">For Android (Chrome):</p>
                <ol class="list-decimal ml-6 text-gray-300">
                    <li>Open Chrome and go to: <a href="https://uat.pps.doa.gov.lk"
                            class="text-blue-400 underline">uat.pps.doa.gov.lk</a></li>
                    <li>Tap the 3-dot menu</li>
                    <li>Select "Add to Home screen" or "Install App"</li>
                    <li>Rename (e.g., "NPSS") and tap Add</li>
                </ol>

                <p class="text-green-300 font-semibold mt-4">For iPhone/iPad (Safari):</p>
                <ol class="list-decimal ml-6 text-gray-300">
                    <li>Open Safari</li>
                    <li>Go to: <a href="https://uat.pps.doa.gov.lk"
                            class="text-blue-400 underline">uat.pps.doa.gov.lk</a></li>
                    <li>Tap Share → "Add to Home Screen"</li>
                    <li>Rename and tap Add</li>
                </ol>
            </div>
        </section>

        <hr class="border-gray-600">

        <section class="text-sm text-gray-400 space-y-2">
            <h3 class="text-lg text-white font-bold">Prepared By:</h3>
            <p>Dhammika Sarathchandra – Agriculture Instructor</p>
            <p>Darsha Anuradha – Lead Developer & Technical Assistant, AFACI Project / National Plant
                Protection Service</p>

            <h3 class="text-lg text-white font-bold">Directed By:</h3>
            <p>Dr. K.M.D.W. Prabath Nishantha – Additional Director, National Plant Protection Service</p>

            <p class="mt-4 italic">Department of Agriculture, National Plant Protection Service, Gannoruwa, Peradeniya –
                Sri Lanka</p>
        </section>

    </div>
</x-app-layout>
