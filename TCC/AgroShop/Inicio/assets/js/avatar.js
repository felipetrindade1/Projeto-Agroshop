
    document.addEventListener('DOMContentLoaded', function () {
        var editButton = document.getElementById('editButton');
        var perfilFormContainer = document.getElementById('perfil-form-container');

        editButton.addEventListener('click', function () {
            // Verifica se o contêiner do formulário está visível
            if (perfilFormContainer.style.display === 'none') {
                // Se estiver oculto, mostra
                perfilFormContainer.style.display = 'block';
            } else {
                // Se estiver visível, oculta
                perfilFormContainer.style.display = 'none';
            }
        });
    });
