<!DOCTYPE html>
<html lang="en">
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
        <form action="save_content.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" id="title" name="title" required>
          </div>
          <div class="form-group">
            <label for="image">Imagem</label>
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
            <img id="imagePreview" src="#" alt="Pré-visualização da Imagem" style="display: none; width: 200px;">
          </div>
          <div class="form-group">
            <label for="image_description">Descrição da Imagem</label>
            <input type="text" class="form-control" id="image_description" name="image_description">
          </div>
          <div class="form-group">
            <label for="content">Conteúdo</label>
            <textarea class="form-control" id="content" name="content" rows="10" ></textarea>
          </div>
          <input type="hidden" name="type" value="text">
          <button type="submit" class="btn btn-primary">Salvar</button>
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

      $('#image').change(function() {
      const [file] = this.files;
      if (file) {
        $('#imagePreview').attr('src', URL.createObjectURL(file)).show();
      }
    });

    $('#audio').change(function() {
      const [file] = this.files;
      if (file) {
        $('#audioPreview').attr('src', URL.createObjectURL(file)).show();
      }
    });
    var simplemde = new SimpleMDE({ element: document.getElementById("content") });

      $('#addTextForm').on('submit', function(e) {
        var content = simplemde.value();
        if (!content.trim()) {
          e.preventDefault(); // Impede o envio do formulário
          $('#content').siblings('.invalid-feedback').show(); // Exibe a mensagem de erro
          $('#content').addClass('is-invalid'); // Adiciona a classe de estilo Bootstrap para campo inválido
        } else {
          $('#content').val(content); // Copia o conteúdo do SimpleMDE para o textarea
        }
      });
    });
  </script>
</body>
</html>
