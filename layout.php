<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Tarefas ✓</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; }
        .navbar { background-color: #4a90e2; }
    </style>
</head>
<body>

<?php if(isset($_SESSION["usuario_id"])): ?>
<nav class="navbar navbar-expand-lg navbar-dark mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">✓ To-Do List</a>
        <div class="d-flex align-items-center">
            <span class="navbar-text text-white me-3">
                Olá, <strong><?= htmlspecialchars($_SESSION["usuario"]) ?></strong>
            </span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Sair</a>
        </div>
    </div>
</nav>
<?php endif; ?>

<div class="container pb-5">