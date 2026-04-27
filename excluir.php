<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

require 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $usuario_id = $_SESSION["usuario_id"];

    $stmt = $conexao->prepare("DELETE FROM tarefas WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$id, $usuario_id]);
}

header("Location: index.php");
exit;