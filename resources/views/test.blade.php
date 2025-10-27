<x-minimal>
   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pest Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 flex flex-col items-center p-6">

    <h1 class="text-3xl font-bold mb-6">User Data from API</h1>

    <div id="userList" class="w-full max-w-3xl bg-white rounded-xl shadow-md p-4">
        <p class="text-center text-gray-500">Loading users...</p>
    </div>

    <script>
        async function loadUsers() {
            try {
                const response = await fetch('http://127.0.0.1:8000/api/pest-data');
                const users = await response.json();

                const container = document.getElementById('userList');
                container.innerHTML = ''; // Clear "loading" message

                users.forEach(user => {
                    const card = document.createElement('div');
                    card.className = "border-b border-gray-200 p-4 flex items-center gap-4";

                    card.innerHTML = `
                        <img src="/storage/${user.image}" alt="${user.name}" class="w-12 h-12 rounded-full border object-cover">
                        <div>
                            <h2 class="font-semibold">${user.name}</h2>
                            <p class="text-gray-500">${user.email}</p>
                            <p class="text-sm text-green-600">Status: ${user.is_active ? 'Active' : 'Inactive'}</p>
                        </div>
                    `;
                    container.appendChild(card);
                });
            } catch (error) {
                document.getElementById('userList').innerHTML =
                    `<p class="text-red-500 text-center">Error loading data.</p>`;
                console.error(error);
            }
        }

        loadUsers();
    </script>

</body>
</html>

</x-minimal>
