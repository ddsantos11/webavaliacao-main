document.addEventListener("DOMContentLoaded", function () {
  const submitButton = document.getElementById("submit-button");

  if (!submitButton) {
    console.error("Botão de envio não encontrado!");
    return;
  }

  submitButton.addEventListener("click", async function () {
    const notaSelecionada = document.querySelector('input[name="nota"]:checked');
    const feedbackInput = document.getElementById("feedback");
    const errorMessage = document.getElementById("error-message");

    errorMessage.textContent = "";

    if (!notaSelecionada) {
      errorMessage.textContent = "Por favor, selecione uma nota.";
      return;
    }

    const nota = notaSelecionada.value;
    const feedback = feedbackInput ? feedbackInput.value.trim() : "";

    // 🔧 Criar o FormData com os dados
    const formData = new FormData();
    formData.append("nota", nota);
    formData.append("feedback", feedback);

    try {
      const response = await fetch("http://localhost/webavaliacao-main/server/avaliar.php", {
        method: "POST",
        body: formData
      });

      const data = await response.text(); // Espera texto, não JSON

      // Aqui você pode tratar o retorno como quiser
      if (data.includes("Obrigado")) {
        alert("Avaliação enviada com sucesso!");
        if (feedbackInput) feedbackInput.value = "";
        document.querySelectorAll('input[name="nota"]').forEach(input => input.checked = false);
      } else {
        errorMessage.textContent = data || "Erro ao enviar avaliação.";
      }
    } catch (error) {
      errorMessage.textContent = "Erro de conexão com o servidor.";
    }
  });
});
