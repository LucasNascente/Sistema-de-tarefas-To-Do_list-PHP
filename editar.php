<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

require 'conexao.php';

// Verifica se o ID foi passado na URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$usuario_id = $_SESSION["usuario_id"];

// Busca a tarefa atual (garantindo que pertence ao usuário logado)
$stmt = $conexao->prepare("SELECT * FROM tarefas WHERE id = ? AND usuario_id = ?");
$stmt->execute([$id, $usuario_id]);
$tarefa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tarefa) {
    header("Location: index.php"); // Se tentar acessar tarefa de outro usuário, volta pro início
    exit;
}

// Se o formulário foi enviado (UPDATE)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST["titulo"]);
    $descricao = trim($_POST["descricao"]);
    $status = $_POST["status"];

    $update = $conexao->prepare("UPDATE tarefas SET titulo = ?, descricao = ?, status = ? WHERE id = ? AND usuario_id = ?");
    $update->execute([$titulo, $descricao, $status, $id, $usuario_id]);

    header("Location: index.php");
    exit;
}

include 'layout.php';
?>

<div class="card shadow-sm mx-auto" style="max-width: 600px;">
    <div class="card-header bg-white">
        <h5 class="mb-0 text-primary">Editar Tarefa</h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Título</label>
                <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($tarefa['titulo']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Descrição</label>
                <textarea name="descricao" class="form-control" rows="4"><?= htmlspecialchars($tarefa['descricao']) ?></textarea>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select">
                    <option value="pendente" <?= $tarefa['status'] == 'pendente' ? 'selected' : '' ?>>Pendente</option>
                    <option value="concluida" <?= $tarefa['status'] == 'concluida' ? 'selected' : '' ?>>Concluída</option>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">Atualizar Tarefa</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>