<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'My App' }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">My App</a>
        </div>
    </nav>

    <!-- Content -->
    <main class="container">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-light text-center py-3 mt-4">
        <small>&copy; {{ date('Y') }} My App</small>
    </footer>

</body>
</html>