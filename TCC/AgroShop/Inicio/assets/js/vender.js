document.addEventListener("DOMContentLoaded", function() {
    var meusProdutos = document.getElementById("meusprodutos");
    var containerCadastro = document.getElementById("container-cadastro");

    document.getElementById("adicionar-produto").addEventListener("click", function(e) {
      e.preventDefault();
      meusProdutos.style.display = "none";
      containerCadastro.style.display = "block";
    });

    document.getElementById("meus-produtos").addEventListener("click", function(e) {
      e.preventDefault();
      meusProdutos.style.display = "block";
      containerCadastro.style.display = "none";
    });
  });
  
  document.addEventListener("DOMContentLoaded", function() {
    var meusProdutos = document.getElementById("meusprodutos");
    var containerCadastro = document.getElementById("container-cadastro");
  
    document.getElementById("adicionar-produto").addEventListener("click", function(e) {
      e.preventDefault();
      meusProdutos.classList.add("sair-da-esquerda");
      containerCadastro.classList.remove("sair-da-esquerda");
      containerCadastro.classList.add("entrar-da-direita");
    });
  
    document.getElementById("meus-produtos").addEventListener("click", function(e) {
      e.preventDefault();
      containerCadastro.classList.remove("entrar-da-direita");
      containerCadastro.classList.add("sair-da-esquerda");
      meusProdutos.classList.remove("sair-da-esquerda");
      meusProdutos.classList.add("entrar-da-direita");
    });
  });

  document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("seuFormulario").addEventListener("submit", function(e) {
      e.preventDefault();
  
      var formData = new FormData(document.getElementById("seuFormulario"));
  
      fetch(window.location.href, { // Envie para a mesma página
        method: 'POST',
        body: formData
      })
      .then(() => {
        window.location.reload(); // Recarrega a página
      })
      .catch(error => {
        console.error('Erro:', error);
      });
    });
  });