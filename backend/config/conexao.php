<?php
/* ===========================================================================
   SixStar Clinic — Conexão com o Banco de Dados MySQL via PDO
   Disciplina: ARA0062 / WYD7324 · Desenvolvimento Web
   Responsável: Geovana Moreira (Líder)
   =========================================================================== */

// Configurações de conexão para ambiente de desenvolvimento local (XAMPP / WAMP)
// Prefixo "db_" para não colidir com variáveis dos formulários (ex.: $usuario do login)
$db_host    = 'localhost';
$db_nome    = 'sixstar_clinic';
$db_usuario = 'root';
$db_senha   = '';
$db_charset = 'utf8mb4';

// Data Source Name (DSN) com charset UTF-8 completo
$dsn = "mysql:host={$db_host};dbname={$db_nome};charset={$db_charset}";

$opcoes = [
    // Lança exceções PDOException caso ocorra algum erro na consulta
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    // Retorna resultados como array associativo por padrão ($linha['coluna'])
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // Garante que o MySQL use Prepared Statements nativos do servidor
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Instancia a conexão PDO
    $pdo = new PDO($dsn, $db_usuario, $db_senha, $opcoes);
} catch (PDOException $e) {
    // Em caso de falha de conexão, encerra a execução com mensagem amigável
    // e loga o erro sem expor detalhes sensíveis
    die("Erro ao conectar ao banco de dados da SixStar Clinic. Por favor, verifique se o MySQL no XAMPP está ativo.");
}

// Apaga as credenciais da memória para não vazarem em nenhuma página
unset($db_host, $db_nome, $db_usuario, $db_senha, $db_charset, $dsn, $opcoes);
