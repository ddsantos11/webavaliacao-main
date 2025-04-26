<?php
// salvar_avaliacao.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conecta ao banco de dados
    $conn = new mysqli("localhost", "root", "admin", "fciaeduardo"); // Altere conforme necessário

    // Verifica a conexão com o banco
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Recebe os valores do formulário
    $nota = $_POST['nota'];
    $feedback = $_POST['feedback'];
    $usuario_id = 1;

    // Query para inserir a avaliação no banco de dados
    $sql = "INSERT INTO Avaliacoes (usuario_id, nota, feedback, data) VALUES ('$usuario_id', '$nota', '$feedback', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Avaliação salva com sucesso!";
    } else {
        echo "Erro ao salvar avaliação: " . $conn->error;
    }

    // Fecha a conexão
    $conn->close();
}
?>
