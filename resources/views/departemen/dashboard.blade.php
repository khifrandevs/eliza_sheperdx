<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Departemen</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold">Selamat Datang, Departemen {{ auth('departemen')->user()->nama_departemen }}</h2>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="mt-4 px-4 py-2 bg-red-500 text-white rounded">Logout</button>
        </form>
    </div>
</body>
</html>