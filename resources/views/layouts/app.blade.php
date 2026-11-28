<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titre', 'Accueil') – ilmify </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100 bg-body-tertiary">
    @include('partials.navbar')

    @yield('hero')

    <main class="flex-grow-1 py-4">
        <div class="container">
            @include('partials.messages')
            @yield('contenu')
        </div>
    </main>

    <footer class="bg-dark text-white-50 py-3 mt-auto">
        <div class="container d-flex flex-column flex-md-row justify-content-between small">
            <span>&copy; {{ date('Y') }} Révision Étudiants – projet universitaire</span>
            <span>Laravel · MySQL · Bootstrap</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
