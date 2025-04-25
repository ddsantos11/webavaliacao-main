<?php
// Configuração do banco de dados
$host = 'localhost'; // Endereço do servidor
$dbname = 'fciaeduardo'; // Nome do banco de dados
$username = 'root'; // Usuário do banco de dados
$password = 'admin'; // Senha do banco de dados

try {
    // Conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Receber dados do formulário
    $nota = isset($_POST['nota']) ? (int)$_POST['nota'] : '';
    $feedback = isset($_POST['feedback']) ? htmlspecialchars($_POST['feedback']) : '';

    // Verificar se a nota é válida
    if ($nota < 1 || $nota > 5) {
        die('Nota inválida.');
    }

    // Inserir a avaliação no banco de dados
    $stmt = $pdo->prepare("INSERT INTO Avaliac  oes (nota, feedback, data) VALUES (:nota, :feedback, NOW())");
    $stmt->bindParam(':nota', $nota);
    $stmt->bindParam(':feedback', $feedback);

    // Executar a query
    $stmt->execute();

    // Mensagem de sucesso
    echo "Obrigado por sua avaliação!";
} catch (PDOException $e) {
    // Caso haja erro na conexão ou execução
    echo "Erro: " . $e->getMessage();
}
?>

