<?php
session_start();

header('Content-Type: application/json');
// Conexão do banco
$host = 'localhost';
$dbname = 'fciaeduardo';
$username = 'root';
$password = 'admin';

//Verifica a conexão com o banco
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro de conexão: " . $e->getMessage()]);
    exit;
}
//Verifica os campos digitados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $cpf = $_POST['cpf'] ?? '';

    if (empty($nome) || empty($telefone)) {
        echo json_encode(["success" => false, "message" => "Nome e telefone são obrigatórios."]);
        exit;
    }
//Prepara as informações do usuário
    $stmt = $pdo->prepare("SELECT id FROM Usuarios WHERE telefone = ?");
    $stmt->execute([$telefone]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $usuarioId = $usuario['id'];
    } else {
        $stmt = $pdo->prepare("INSERT INTO Usuarios (nome, telefone, cpf) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $telefone, $cpf]);
        $usuarioId = $pdo->lastInsertId();
    }
//Envia o id para usuario_id
    $_SESSION['usuario_id'] = $usuarioId;

    echo json_encode(["success" => true, "usuario_id" => $usuarioId]);
}
?>
