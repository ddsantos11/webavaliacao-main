<?php
// Configuração do banco de dados
$host = 'localhost'; // endereço do servidor
$dbname = 'fciaeduardo'; // nome do banco de dados
$username = 'root'; // nome do usuário
$password = 'admin'; // senha do usuário (deixe vazio se não houver senha para o MySQL)

try {
    // Criação da conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Em caso de erro na conexão, exibe a mensagem
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $nome = $_POST['nome'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $cpf = $_POST['cpf'] ?? '';

    // Validação simples: Verifica se os campos estão preenchidos
    if (empty($nome) || empty($telefone)) {
        echo "Por favor, preencha todos os campos.";
        exit;
    }

    // Verifica se o telefone já existe no banco de dados
    $stmt = $pdo->prepare("SELECT id FROM Usuarios WHERE telefone = ?");
    $stmt->execute([$telefone]);
    $usuarioExistente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuarioExistente) {
        // Se o telefone já existe, usa o ID do usuário existente
        $usuarioId = $usuarioExistente['id'];
        echo "Usuário existente com o ID: $usuarioId. Os dados foram atualizados.";
        
        // Se necessário, aqui você pode atualizar outros dados do usuário, se for o caso
    } else {
        // Se o telefone não existir, insere um novo usuário
        $stmt = $pdo->prepare("INSERT INTO Usuarios (nome, telefone, cpf) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $telefone, $cpf]);

        // Obtém o ID do novo usuário
        $usuarioId = $pdo->lastInsertId();
        echo "Usuário cadastrado com sucesso! ID: $usuarioId";
    }
}
?>
