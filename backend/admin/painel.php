<?php
// Inclui o arquivo de conexão (ajuste o caminho se necessário)
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

    $sqlPendentes = $pdo->query("SELECT COUNT(*) FROM agendamentos WHERE status = 'pendente'");
    $totalPendentes = $sqlPendentes->fetchColumn();

    $sqlConfirmadas = $pdo->query("SELECT COUNT(*) FROM agendamentos WHERE status = 'confirmado'");
    $totalConfirmadas = $sqlConfirmadas->fetchColumn();

    // 2. Consulta SELECT unindo agendamentos, médicos e horários
    $query = "SELECT a.id, p.nome AS nome, p.telefone AS telefone, m.nome AS medico, a.data_consulta, a.status 
              FROM agendamentos a
              INNER JOIN pacientes p ON a.paciente_id = p.id
              INNER JOIN medicos m ON a.medico_id = m.id
              ORDER BY a.data_consulta DESC";
              
    $stmt = $pdo->query($query);
    $consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Tratamento básico de erro na consulta
    echo "Erro ao carregar os dados do painel: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo - SixStar Clinic</title>
    <link rel="stylesheet" href="style-admin.css">
    <link rel="stylesheet" href="../frontend/css/tema-claro.css" id="tema-claro-css" disabled>
    <script src="../frontend/js/tema.js" defer></script>
</head>
<body>
    <header>
        <h1>Painel SixStar Clinic</h1>
        <button id="toggle-theme-btn">Alternar Tema</button>
    </header>

    <main>
        <!-- Contadores de Topo -->
        <section class="cards-contadores">
            <div class="card">
                <h3>Total de Consultas</h3>
                <p><?php echo $totalConsultas; ?></p>
            </div>
            <div class="card">
                <h3>Pendentes</h3>
                <p><?php echo $totalPendentes; ?></p>
            </div>
            <div class="card">
                <h3>Confirmadas</h3>
                <p><?php echo $totalConfirmadas; ?></p>
            </div>
        </section>

        <!-- Tabela de Agendamentos -->
        <section class="tabela-container">
            <h2>Lista de Agendamentos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Telefone (WhatsApp)</th>
                        <th>Médico</th>
                        <th>Data/Horário</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($consultas)): ?>
                        <?php foreach ($consultas as $consulta): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($consulta['nome']); ?></td>
                                <td><?php echo htmlspecialchars($consulta['telefone']); ?></td>
                                <td><?php echo htmlspecialchars($consulta['medico']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($consulta['data_consulta'])); ?></td>
                                <td><span class="status-<?php echo strtolower($consulta['status']); ?>"><?php echo ucfirst($consulta['status']); ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Nenhum agendamento encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
