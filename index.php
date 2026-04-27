<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

require 'conexao.php';
include 'layout.php';

// Busca as tarefas apenas do usuário logado
$stmt = $conexao->prepare("SELECT * FROM tarefas WHERE usuario_id = ? ORDER BY id DESC");
$stmt->execute([$_SESSION["usuario_id"]]);
$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-secondary">Minhas Tarefas</h3>
    <a href="nova.php" class="btn btn-success fw-bold">+ Nova Tarefa</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Título</th>
                    <th>Data de Criação</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($tarefas) > 0): ?>
                    <?php foreach ($tarefas as $t): ?>
                        <tr>
                            <td class="ps-4">
                                <strong><?= htmlspecialchars($t['titulo']) ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars($t['descricao']) ?></small>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($t['data_criacao'])) ?></td>
                            <td>
                                <?php if ($t['status'] == 'concluida'): ?>
                                    <span class="badge bg-success">Concluída</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Pendente</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-4">
                                <?php if ($t['status'] == 'pendente'): ?>
                                    <a href="concluir.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-success" title="Concluir">✓</a>
                                <?php endif; ?>
                                <a href="editar.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                <a href="excluir.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Nenhuma tarefa encontrada. Hora de relaxar! ☕</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>