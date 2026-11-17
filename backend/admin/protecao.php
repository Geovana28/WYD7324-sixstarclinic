<?php
/* ===========================================================================
   SixStar Clinic — Trava de acesso ao painel administrativo
   Uso: na PRIMEIRA linha de painel.php (antes de qualquer HTML), escreva:

       <?php require_once __DIR__ . '/protecao.php'; ?>

   Sem sessão ativa, o visitante é enviado de volta para login.php.
   =========================================================================== */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit;
}
