<!DOCTYPE html>
<html lang="en">
<?php 
 include('libs/functions.php');
 ?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adicionar Texto</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
  <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <nav class="navbar navbar-light bg-light">
    <button class="navbar-toggler" type="button">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>
  <div class="container-fluid container-max">
    <div class="row">
      <nav class="col-md-2 bg-light sidebar">
        <?php include('menu.php'); ?>
      </nav>
      <main class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <h2>Adicionar Texto</h2>
        <form id="textForm" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" id="title" name="title" required>
          </div>
          <div class="form-group">
            <label for="imageFile">Imagem</label>
            <input type="file" class="form-control-file" id="imageFile" name="imageFile" accept="image/*">
            <img id="imagePreview" src="#" alt="Pré-visualização da Imagem" style="display: none; width: 200px;">
          </div>
          <div class="form-group">
            <label for="image_description">Descrição da Imagem</label>
            <input type="text" class="form-control" id="image_description" name="imageDescription">
          </div>
          <div class="form-group">
            <label for="content">Conteúdo</label>
            <textarea class="form-control" id="content" name="content" rows="10"></textarea>
            <div class="invalid-feedback">O conteúdo não pode estar vazio.</div>
          </div>
          <input type="hidden" name="type" value="text">
          <button type="submit" class="btn btn-primary"><i class="fas fa-spinner fa-spin d-none mr-2"></i> Salvar</button>
        </form>
      </main>
    </div>
  </div>
  <?php include('footer.php'); ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function(){
      $('.navbar-toggler').on('click', function() {
        $('.sidebar').toggleClass('active');
      });

      $('#imageFile').change(function() {
        const file = this.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            $('#imagePreview').attr('src', e.target.result).show();
          }
          reader.readAsDataURL(file);
        } else {
          $('#imagePreview').hide();
        }
      });

      var simplemde = new SimpleMDE({ element: document.getElementById("content") });

      $('#textForm').on('submit', function(e) {
    e.preventDefault(); // Impede o envio do formulário normal

    var content = simplemde.value();
    if (!content.trim()) {
        $('#content').siblings('.invalid-feedback').show(); // Exibe a mensagem de erro
        $('#content').addClass('is-invalid'); // Adiciona a classe de estilo Bootstrap para campo inválido
    } else {
        var $submitButton = $(this).find('button[type="submit"]');
        var $spinner = $submitButton.find('.fas');
        $submitButton.prop('disabled', true);
        $spinner.removeClass('d-none');

        var formData = new FormData(this);
        formData.append('content', content); // Adiciona o conteúdo do SimpleMDE ao FormData

        $.ajax({
            url: 'libs/save_content_ajax.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.status === 'success') {
                    alert('Dados salvos com sucesso!');
                    // Limpar formulário e pré-visualizações
                    $('#textForm')[0].reset();
                    simplemde.value(''); // Limpa o editor SimpleMDE
                    $('#imagePreview').hide();
                } else {
                    alert('Erro: ' + jsonResponse.message);
                }
                // Reativar o botão e esconder o spinner
                $submitButton.prop('disabled', false);
                $spinner.addClass('d-none');
            },
            error: function(xhr, status, error) {
                alert('Erro ao enviar os dados.');
                // Reativar o botão e esconder o spinner
                $submitButton.prop('disabled', false);
                $spinner.addClass('d-none');
            }
        });
    }
});


    });
  </script>
</body>
</html>
