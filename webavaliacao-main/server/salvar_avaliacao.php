<?php
// salvar_avaliacao.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar ao banco de dados
    $conn = new mysqli("localhost", "root", "admin", "fciaeduardo"); // Altere conforme necessário

    // Verifique a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Obter os valores do formulário
    $nota = $_POST['nota'];
    $feedback = $_POST['feedback'];
    $usuario_id = 1; // Substitua com o ID do usuário, caso tenha um sistema de login

    // Preparar a query para inserir a avaliação no banco de dados
    $sql = "INSERT INTO Avaliacoes (nota, feedback, data) VALUES ('$nota', '$feedback', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Avaliação salva com sucesso!";
    } else {
        echo "Erro ao salvar avaliação: " . $conn->error;
    }

    // Fechar a conexão
    $conn->close();
}
?>
