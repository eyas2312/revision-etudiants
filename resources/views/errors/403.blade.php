<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accès refusé – Révision Étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-body-tertiary d-flex align-items-center min-vh-100">
    <div class="container text-center">
        <h1 class="display-1 fw-bold text-danger">403</h1>
        <p class="lead">Accès refusé.</p>
        <p class="text-muted">{{ $exception->getMessage() ?: 'Vous n\'avez pas l\'autorisation d\'accéder à cette page.' }}</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Retour à l'accueil</a>
    </div>
</body>
</html>
