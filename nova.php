<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST["titulo"]);
    $descricao = trim($_POST["descricao"]);

    $stmt = $conexao->prepare("INSERT INTO tarefas (titulo, descricao, usuario_id) VALUES (?, ?, ?)");
    $stmt->execute([$titulo, $descricao, $_SESSION["usuario_id"]]);

    header("Location: index.php");
    exit;
}

include 'layout.php';
?>

<div class="card shadow-sm mx-auto" style="max-width: 600px;">
    <div class="card-header bg-white">
        <h5 class="mb-0 text-primary">Nova Tarefa</h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Título da Tarefa <span class="text-danger">*</span></label>
                <input type="text" name="titulo" class="form-control" placeholder="Ex: Fazer compras" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Descrição</label>
                <textarea name="descricao" class="form-control" rows="4" placeholder="Detalhes da tarefa..."></textarea>
            </div>
            <div class="d-flex justify-content-between">
                <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar Tarefa</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>