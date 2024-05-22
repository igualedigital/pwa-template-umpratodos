<!DOCTYPE html>
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
        <form action="save_content.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" id="title" name="title" required>
          </div>
          <div class="form-group">
            <label for="image">Imagem</label>
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
            <img id="imagePreview" src="#" alt="Pré-visualização da Imagem" style="display: none;">
          </div>
          <div class="form-group">
            <label for="image_description">Descrição da Imagem</label>
            <input type="text" class="form-control" id="image_description" name="image_description">
          </div>
          <div class="form-group">
            <label for="video">Vídeo</label>
            <input type="file" class="form-control-file" id="video" name="video" accept="video/mp4" required>
            <video id="videoPreview" style="display: none;" controls></video>
          </div>
          <input type="hidden" name="type" value="video">
          <button type="submit" class="btn btn-primary">Salvar</button>
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

      $('#image').change(function() {
      const [file] = this.files;
      if (file) {
        $('#imagePreview').attr('src', URL.createObjectURL(file)).show();
      }
    });

    $('#video').change(function() {
      const [file] = this.files;
      if (file) {
        $('#videoPreview').attr('src', URL.createObjectURL(file)).show();
      }
    });

    });
  </script>
</body>
</html>
