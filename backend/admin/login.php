<?php
/* ===========================================================================
   SixStar Clinic — Login da Área Administrativa
   Disciplina: ARA0062 / WYD7324 · Desenvolvimento Web
   Valida usuário e senha no MySQL (PDO + prepared statement) e abre a sessão.
   =========================================================================== */

session_start();

// Quem já está logado vai direto para o painel
if (!empty($_SESSION['admin_logado'])) {
    header('Location: painel.php');
    exit;
}

require_once __DIR__ . '/../config/conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $senha   = isset($_POST['senha']) ? $_POST['senha'] : '';

    if ($usuario === '' || $senha === '') {
        $erro = 'Informe usuário e senha.';
    } else {
        try {
            $stmt = $pdo->prepare('SELECT id, usuario, senha_hash FROM usuarios_admin WHERE usuario = ? LIMIT 1');
            $stmt->execute([$usuario]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($senha, $admin['senha_hash'])) {
                // Novo ID de sessão após o login (evita fixação de sessão)
                session_regenerate_id(true);
                $_SESSION['admin_logado']  = true;
                $_SESSION['admin_usuario'] = $admin['usuario'];
                header('Location: painel.php');
                exit;
            }

            $erro = 'Usuário ou senha incorretos.';
        } catch (PDOException $e) {
            $erro = 'Não foi possível validar o acesso agora. Tente novamente.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Administrativo - SixStar Clinic</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style-admin.css">
  <link rel="icon" type="image/png" href="../../frontend/img/favicon.png">
  <style>
    .login-erro {
      background: rgba(220, 53, 69, 0.15);
      border: 1px solid rgba(220, 53, 69, 0.5);
      color: #ff8f9a;
      border-radius: 8px;
      padding: 10px 14px;
      margin-bottom: 20px;
      font-size: 0.9rem;
      text-align: center;
    }
  </style>
</head>
<body class="admin-login-body">
  <main class="login-card">
    <header class="login-header">
      <h1 class="login-title">SixStar Clinic</h1>
      <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 6px;">Área Administrativa</p>
    </header>

    <?php if ($erro !== ''): ?>
      <div class="login-erro" role="alert"><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php" autocomplete="off">
      <div class="form-group-admin">
        <label for="usuario">Usuário</label>
        <input type="text" id="usuario" name="usuario" required autofocus
               value="<?= isset($usuario) ? htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8') : '' ?>">
      </div>
      <div class="form-group-admin">
        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" required>
      </div>
      <button type="submit" class="btn-admin-gold">Entrar</button>
    </form>
  </main>
</body>
</html>
