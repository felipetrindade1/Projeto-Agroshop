// Função para abrir o pop-up centralizado
function openPopup() {
    var popup = document.getElementById('popup');
    popup.style.display = 'flex';
    // Centralizar o pop-up verticalmente
    popup.style.alignItems = 'center';
}

// Abrir o pop-up ao clicar no botão Editar Perfil
document.getElementById('editar-perfil').addEventListener('click', openPopup);

// Fechar o pop-up ao clicar no botão Fechar
document.getElementById('close-popup').addEventListener('click', function() {
    var popup = document.getElementById('popup');
    popup.style.display = 'none';
    // Redefinir a posição vertical do pop-up para o padrão
    popup.style.alignItems = 'initial';
});

// Lidar com o envio do formulário de edição de perfil
document.getElementById('perfil-form').addEventListener('submit', function(e) {
    e.preventDefault();
    // Aqui você pode adicionar a lógica para salvar as alterações no perfil do usuário
    // Por exemplo, atualizar as informações no servidor ou localmente
    alert('As alterações foram salvas com sucesso!');
    // Feche o pop-up após salvar as alterações
    var popup = document.getElementById('popup');
    popup.style.display = 'none';
    // Redefinir a posição vertical do pop-up para o padrão
    popup.style.alignItems = 'initial';
});

// Inicialmente, oculte o pop-up
document.getElementById('popup').style.display = 'none';