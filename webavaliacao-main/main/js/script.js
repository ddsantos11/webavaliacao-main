document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");

  form.addEventListener("submit", async function (event) {
      event.preventDefault();

      const nome = document.getElementById("nome").value.trim();
      const telefone = document.getElementById("telefone").value.trim();
      const cpf = document.getElementById("cpf").value.trim();

      if (!nome || !telefone) {
          alert("Por favor, preencha nome e telefone.");
          return;
      }

      const formData = new FormData();
      formData.append("nome", nome);
      formData.append("telefone", telefone);
      formData.append("cpf", cpf);

      try {
          const response = await fetch("http://192.168.1.8/webavaliacao-main/server/cadastrar_usuario.php", {
              method: "POST",
              body: formData
          });

          const result = await response.json();

          if (result.success) {
              alert("Usuário cadastrado com sucesso!");
              window.location.href = "avaliacao.html";
          } else {
              alert(result.message || "Erro ao cadastrar.");
          }
      } catch (error) {
          alert("Erro de conexão com o servidor.");
      }
  });
});
const clearButton = document.getElementById("clear-button");

if (clearButton) {
    clearButton.addEventListener("click", function (event) {
        event.preventDefault(); // Impede envio do formulário
        document.getElementById("nome").value = "";
        document.getElementById("telefone").value = "";
        document.getElementById("cpf").value = "";
    });
}