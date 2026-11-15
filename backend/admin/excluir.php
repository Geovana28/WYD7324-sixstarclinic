<?php
/* ===========================================================================
   ARA0062 — Script de Exclusão / Cancelamento de Agendamento
   Recebe o ID via GET, conecta ao banco via PDO e remove o registro.
   =========================================================================== */

// Inclui a conexão segura via PDO
require_once '../config/conexao.php';

// Verifica se o ID foi passado na URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Prepara e executa a query segura protegida contra SQL Injection
        $stmt = $pdo->prepare("DELETE FROM agendamentos WHERE id = ?");
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        // Tratamento de erro silencioso ou log se necessário
    }
}

// Redireciona de volta para o painel administrativo
header("Location: painel.php");
exit;
?>
