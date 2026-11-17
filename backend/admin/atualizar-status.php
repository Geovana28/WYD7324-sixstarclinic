<?php
/* ===========================================================================
   SixStar Clinic — Atualização de Status do Agendamento
   Uso: atualizar-status.php?id=10&status=Confirmado
   Status aceitos (iguais ao ENUM da tabela): Pendente, Confirmado, Concluído
   =========================================================================== */

// Só administradores logados podem alterar status
require_once __DIR__ . '/protecao.php';
require_once __DIR__ . '/../config/conexao.php';

// Lista branca: só aceita os valores do ENUM do banco
$statusPermitidos = [
    'pendente'   => 'Pendente',
    'confirmado' => 'Confirmado',
    'concluido'  => 'Concluído',
];

$id     = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$chave  = isset($_GET['status']) ? strtolower(trim($_GET['status'])) : '';

if ($id > 0 && isset($statusPermitidos[$chave])) {
    try {
        $stmt = $pdo->prepare('UPDATE agendamentos SET status = ? WHERE id = ?');
        $stmt->execute([$statusPermitidos[$chave], $id]);
    } catch (PDOException $e) {
        // Falha silenciosa: volta para o painel sem alterar nada
    }
}

header('Location: painel.php');
exit;
