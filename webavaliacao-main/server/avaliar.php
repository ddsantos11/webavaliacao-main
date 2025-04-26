<?php
// Inicia a sessão para poder acessar dados de sessão (como o ID do usuário)
session_start();

// Define o tipo de conteúdo da resposta como JSON
header('Content-Type: application/json');


$host = 'localhost';
$dbname = 'fciaeduardo';
$username = 'root';
$password = 'admin';

// Tenta estabelecer uma conexão com o banco de dados utilizando PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro de conexão: " . $e->getMessage()]);
    exit;
}

// Decodifica o corpo da requisição JSON para um array associativo
$input = json_decode(file_get_contents('php://input'), true);

$nota = $input['nota'] ?? null;
$feedback = $input['feedback'] ?? null;
$usuarioId = $_SESSION['usuario_id'] ?? null;

// Verifica se o ID do usuário está presente na sessão
if (!$usuarioId) {
    // Se o usuário não estiver autenticado, retorna uma mensagem de erro
    echo json_encode(["success" => false, "message" => "Usuário não autenticado."]);
    exit;
}

// Verifica se a nota é válida (entre 1 e 5)
if (!$nota || $nota < 1 || $nota > 5) {
    echo json_encode(["success" => false, "message" => "Nota inválida."]);
    exit;
}

// Tenta inserir a avaliação no banco de dados
try {
    // Prepara a consulta SQL para inserir a avaliação
    $stmt = $pdo->prepare("INSERT INTO Avaliacoes (usuario_id, nota, feedback) VALUES (?, ?, ?)");
    // Executa a consulta com os dados recebidos
    $stmt->execute([$usuarioId, $nota, $feedback]);

    // Retorna uma resposta JSON de sucesso
    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    // Se houver um erro ao registrar a avaliação, retorna uma mensagem de erro
    echo json_encode(["success" => false, "message" => "Erro ao registrar avaliação: " . $e->getMessage()]);
}
?>
