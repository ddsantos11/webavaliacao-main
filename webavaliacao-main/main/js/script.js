document.addEventListener("DOMContentLoaded", function () {
    const telefoneInput = document.getElementById("telefone");
    const cpfInput = document.getElementById("cpf");

    telefoneInput.addEventListener("input", function (e) { // Definindo formatação do campo de telefone
        let value = e.target.value.replace(/\D/g, "");
        if (value.length > 11) value = value.slice(0, 11);
        if (value.length > 6) {
            value = `(${value.slice(0, 2)}) ${value.slice(2, 7)}-${value.slice(7)}`;
        } else if (value.length > 2) {
            value = `(${value.slice(0, 2)}) ${value.slice(2)}`;
        }
        e.target.value = value;
    });

    cpfInput.addEventListener("input", function (e) { // Definindo formatação do campo do CPF
        let value = e.target.value.replace(/\D/g, "");
        if (value.length > 11) value = value.slice(0, 11);
        if (value.length > 9) {
            value = `${value.slice(0, 3)}.${value.slice(3, 6)}.${value.slice(6, 9)}-${value.slice(9)}`;
        } else if (value.length > 6) {
            value = `${value.slice(0, 3)}.${value.slice(3, 6)}.${value.slice(6)}`;
        } else if (value.length > 3) {
            value = `${value.slice(0, 3)}.${value.slice(3)}`;
        }
        e.target.value = value;
    });
});

// Seleciona o formulário de cadastro e o botão
const form = document.querySelector("form");

form.addEventListener("submit", async function (event) {
  event.preventDefault();  // Impede o envio padrão do formulário

  // Obtendo os valores dos campos
  const nome = document.getElementById("nome").value;
  const telefone = document.getElementById("telefone").value;
  const cpf = document.getElementById("cpf").value;

  // Verificando se todos os campos obrigatórios estão preenchidos
  if (!nome || !telefone || !cpf) {
    alert("Por favor, preencha todos os campos.");
    return;
  }

  // Preparando os dados para enviar
  const formData = new FormData();
  formData.append("nome", nome);
  formData.append("telefone", telefone);
  formData.append("cpf", cpf);

  try {
    // Enviando os dados para o servidor via POST
    const response = await fetch("http://localhost/webavaliacao-main/server/cadastrar_usuario.php", {
      method: "POST",
      body: formData,
    });

    // Verificando se a resposta do servidor foi bem-sucedida
    if (response.ok) {
      alert("Usuário cadastrado com sucesso!");
      form.reset(); // Reseta o formulário após o envio
      window.location.href = "avaliacao.html";
    } else {
      // Exibe a resposta do servidor para depuração
      const responseText = await response.text();
      console.log(responseText);
      alert("Erro ao cadastrar o usuário. Tente novamente.");
    }
  } catch (error) {
    console.error("Erro ao enviar os dados:", error);
    alert("Ocorreu um erro. Tente novamente mais tarde.");
  }
});
