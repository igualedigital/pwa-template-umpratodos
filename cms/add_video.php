<!DOCTYPE html>
<?php 
 include('libs/functions.php');
 ?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adicionar Vídeo</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <h2>Adicionar Vídeo</h2>
        <form id="videoForm" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" id="title" name="title" required>
          </div>
          <div class="form-group">
            <label for="imageFile">Imagem</label>
            <input type="file" class="form-control-file" id="imageFile" name="imageFile" accept="image/*">
            <img id="imagePreview" src="#" alt="Pré-visualização da Imagem" style="display: none;">
          </div>
          <div class="form-group">
            <label for="image_description">Descrição da Imagem</label>
            <input type="text" class="form-control" id="image_description" name="imageDescription">
          </div>
          <div class="form-group">
            <label for="contentFile">Vídeo</label>
            <input type="file" class="form-control-file" id="contentFile" name="contentFile" accept="video/mp4" required>
            <video id="videoPreview" style="display: none;" controls></video>
          </div>
          <input type="hidden" name="type" value="video">
          <button type="submit" class="btn btn-primary"><i class="fas fa-spinner fa-spin d-none mr-2"></i> Salvar</button>
        </form>
      </main>
    </div>
  </div>
  <?php include('footer.php'); ?>
  <script>
    $(document).ready(function(){
      $('.navbar-toggler').on('click', function() {
        $('.sidebar').toggleClass('active');
      });

      // Pré-visualização da imagem
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

      // Pré-visualização do vídeo
      $('#contentFile').change(function() {
        const file = this.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            $('#videoPreview').attr('src', e.target.result).show();
          }
          reader.readAsDataURL(file);
        } else {
          $('#videoPreview').hide();
        }
      });

      $('#videoForm').on('submit', function(event) {
    event.preventDefault();
    
    var $submitButton = $(this).find('button[type="submit"]');
    var $spinner = $submitButton.find('.fas');
    $submitButton.prop('disabled', true);
    $spinner.removeClass('d-none');

    var formData = new FormData(this);

    $.ajax({
        url: 'libs/save_content_ajax.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            var jsonResponse = JSON.parse(response);
            if (jsonResponse.status === 'success') {
                alert('Conteúdo em vídeo adicionado!');
                // Limpar formulário e pré-visualizações
                $('#videoForm')[0].reset();
                $('#imagePreview').hide();
                $('#videoPreview').hide();
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
});

    });
  </script>
</body>
</html>
