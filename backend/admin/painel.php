<?php
// Proteção de sessão: redireciona para login se não estiver logado
require_once __DIR__ . '/protecao.php';

// Inclui o arquivo de conexão PDO com o MySQL
require_once '../config/conexao.php';

// Inicializa variáveis dos contadores para evitar erros
$totalConsultas = 0;
$totalPendentes = 0;
$totalConfirmadas = 0;
$consultas = [];

try {
    // 1. Consulta SQL dos contadores de topo
    $sqlTotal = $pdo->query("SELECT COUNT(*) FROM agendamentos");
    $totalConsultas = $sqlTotal->fetchColumn();

    $sqlPendentes = $pdo->query("SELECT COUNT(*) FROM agendamentos WHERE LOWER(status) = 'pendente'");
    $totalPendentes = $sqlPendentes->fetchColumn();

    $sqlConfirmadas = $pdo->query("SELECT COUNT(*) FROM agendamentos WHERE LOWER(status) = 'confirmado'");
    $totalConfirmadas = $sqlConfirmadas->fetchColumn();

    // 2. Consulta SELECT direta na tabela agendamentos (compatível com a modelagem oficial)
    $query = "SELECT id, nome, telefone, email, especialidade, medico, data_consulta, horario, observacoes, status 
              FROM agendamentos 
              ORDER BY data_consulta DESC, horario DESC";
              
    $stmt = $pdo->query($query);
    $consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $erroPainel = "Erro ao carregar dados do painel: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo — SixStar Clinic</title>
    <link rel="stylesheet" href="style-admin.css">
</head>
<body>
    <header class="admin-header">
        <div class="admin-header-brand">
            <span class="gold-star">✦</span>
            <h1>SixStar Clinic &bull; Painel de Controle</h1>
        </div>
        <div class="admin-header-actions">
            <a href="../../frontend/index.html" class="btn-site" title="Abrir página inicial">🌐 Ver Site</a>
            <a href="logout.php" class="btn-logout" title="Sair da sessão administrativa">Sair / Logout 🚪</a>
        </div>
    </header>

    <main class="admin-main">
        <!-- Contadores de Topo -->
        <section class="cards-contadores">
            <div class="card card-total">
                <span class="card-icon">📋</span>
                <div>
                    <h3>Total de Consultas</h3>
                    <p class="card-number"><?php echo (int)$totalConsultas; ?></p>
                </div>
            </div>
            <div class="card card-pendentes">
                <span class="card-icon">⏳</span>
                <div>
                    <h3>Pendentes</h3>
                    <p class="card-number"><?php echo (int)$totalPendentes; ?></p>
                </div>
            </div>
            <div class="card card-confirmadas">
                <span class="card-icon">✅</span>
                <div>
                    <h3>Confirmadas</h3>
                    <p class="card-number"><?php echo (int)$totalConfirmadas; ?></p>
                </div>
            </div>
        </section>

        <!-- Tabela de Agendamentos -->
        <section class="tabela-container">
            <div class="tabela-header">
                <h2>Lista de Agendamentos Recebidos</h2>
                <span class="tabela-total">Total: <?php echo count($consultas); ?> registros</span>
            </div>

            <?php if (!empty($erroPainel)): ?>
                <div class="alerta-erro"><?php echo htmlspecialchars($erroPainel); ?></div>
            <?php endif; ?>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Contato</th>
                            <th>Especialidade &amp; Médico</th>
                            <th>Data &amp; Horário</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($consultas)): ?>
                            <?php foreach ($consultas as $consulta): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo htmlspecialchars($consulta['nome']); ?></strong>
                                        <?php if (!empty($consulta['observacoes'])): ?>
                                            <small class="obs-texto" title="Observações">📝 <?php echo htmlspecialchars($consulta['observacoes']); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div>📞 <?php echo htmlspecialchars($consulta['telefone']); ?></div>
                                        <small class="email-sub"><?php echo htmlspecialchars($consulta['email']); ?></small>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($consulta['medico']); ?></strong>
                                        <small class="spec-sub"><?php echo htmlspecialchars($consulta['especialidade']); ?></small>
                                    </td>
                                    <td>
                                        <div>📅 <?php echo date('d/m/Y', strtotime($consulta['data_consulta'])); ?></div>
                                        <small class="time-sub">⏰ <?php echo htmlspecialchars($consulta['horario']); ?></small>
                                    </td>
                                    <td>
                                        <span class="badge-status status-<?php echo strtolower($consulta['status']); ?>">
                                            <?php echo htmlspecialchars(ucfirst($consulta['status'])); ?>
                                        </span>
                                    </td>
                                    <td class="col-acoes">
                                        <a href="excluir.php?id=<?php echo (int)$consulta['id']; ?>" 
                                           class="btn-excluir" 
                                           onclick="return confirm('Deseja realmente cancelar este agendamento de <?php echo addslashes(htmlspecialchars($consulta['nome'])); ?>?');"
                                           title="Cancelar / Excluir agendamento">
                                            Cancelar ✖
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="sem-registros">Nenhum agendamento encontrado no banco de dados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
