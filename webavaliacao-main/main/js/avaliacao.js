document.addEventListener("DOMContentLoaded", function () {
  const submitButton = document.getElementById("submit-button");

  if (!submitButton) return;

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

      try {
          const response = await fetch("http://192.168.1.8/webavaliacao-main/server/avaliar.php", {
              method: "POST",
              headers: {
                  "Content-Type": "application/json"
              },
              body: JSON.stringify({ nota, feedback })
          });

          const data = await response.json();

          if (data.success) {
              alert("Avaliação enviada com sucesso!");
              if (feedbackInput) feedbackInput.value = "";
              document.querySelectorAll('input[name="nota"]').forEach(input => input.checked = false);
          } else {
              errorMessage.textContent = data.message || "Erro ao enviar avaliação.";
          }
      } catch (error) {
          errorMessage.textContent = "Erro de conexão com o servidor.";
      }
  });
});
