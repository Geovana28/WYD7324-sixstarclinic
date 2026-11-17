<?php
/* ===========================================================================
   SixStar Clinic — Processamento e Gravação de Agendamento
   Disciplina: ARA0062 / WYD7324 · Desenvolvimento Web
   Responsável: Geovana Moreira (Líder)
   =========================================================================== */

// 1. Verifica se a requisição foi enviada via método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Redireciona de volta para a página inicial se o arquivo for acessado via GET
    header('Location: ../frontend/index.html');
    exit;
}

// 2. Inclui o arquivo de conexão PDO com o MySQL
require_once __DIR__ . '/config/conexao.php';

// 3. Coleta e limpa os dados enviados pelo formulário
// (A proteção contra SQL Injection é feita pelo prepare(?) e contra XSS pelo htmlspecialchars no painel.php)
$nome          = isset($_POST['nome']) ? trim(strip_tags($_POST['nome'])) : '';
$telefone      = isset($_POST['telefone']) ? trim(strip_tags($_POST['telefone'])) : '';
$email         = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
$especialidade = isset($_POST['especialidade']) ? trim(strip_tags($_POST['especialidade'])) : '';
$medico        = isset($_POST['medico']) ? trim(strip_tags($_POST['medico'])) : '';
$data_consulta = isset($_POST['data_consulta']) ? trim($_POST['data_consulta']) : '';
$horario       = isset($_POST['horario']) ? trim($_POST['horario']) : '';
$observacoes   = isset($_POST['observacoes']) ? trim(strip_tags($_POST['observacoes'])) : '';

// 4. Validação básica no lado do servidor dos campos obrigatórios
if (empty($nome) || empty($telefone) || empty($email) || empty($especialidade) || empty($medico) || empty($data_consulta) || empty($horario)) {
    die("Por favor, preencha todos os campos obrigatórios do agendamento. <a href='../frontend/index.html#agendamento'>Voltar ao formulário</a>");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Formato de e-mail inválido. <a href='../frontend/index.html#agendamento'>Voltar ao formulário</a>");
}

// 5. Inserção segura no banco de dados usando Prepared Statements (contra SQL Injection)
try {
    $sql = "INSERT INTO agendamentos 
            (nome, telefone, email, especialidade, medico, data_consulta, horario, observacoes, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pendente')";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $nome,
        $telefone,
        $email,
        $especialidade,
        $medico,
        $data_consulta,
        $horario,
        $observacoes
    ]);

    // 6. Redirecionamento após o sucesso
    // Se a página sucesso.html já existir, vai para ela; caso contrário, redireciona para a home
    if (file_exists(__DIR__ . '/../frontend/sucesso.html')) {
        header('Location: ../frontend/sucesso.html');
    } else {
        header('Location: ../frontend/index.html?agendado=sucesso#agendamento');
    }
    exit;

} catch (PDOException $e) {
    // Tratamento de erro seguro sem expor detalhes internos do banco
    die("Erro ao registrar o agendamento no banco de dados. Por favor, tente novamente.");
}
