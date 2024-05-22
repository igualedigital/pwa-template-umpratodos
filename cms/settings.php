<!DOCTYPE html>
<?php 
 include('functions.php');
 $infoPwa = getPwaInfo();
 ?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Configurações</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
      <main class="col-md-10 ml-sm-auto col-lg-10 px-4">
        <h2>Atualize as informações do PWA (<?=getLastSegment(BASE_DIR) ?>)</h2>
      

        
        
        <div class="card mt-4">
          <div class="card-header">
          Atualizar informações do projeto <?= $infoPwa['titulo'] ?>
          </div>
          <div class="card-body">
            <!-- [+] Formulário para gerar projeto-pwa.json -->
        <form id="pwaForm">
          <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required value="<?= $infoPwa['titulo']; ?>">
          </div>
          <div class="form-group">
            <label for="subtitulo">Subtítulo</label>
            <input type="text" class="form-control" id="subtitulo" name="subtitulo" required value="<?= $infoPwa['sub-titulo']; ?>">
          </div>
          <div class="form-group">
            <label for="descricao">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" required value="<?= $infoPwa['descricao']; ?>">
          </div>
          <div class="form-group">
            <label>Estado do PWA</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="estado" id="ativo" value="1" <?= $infoPwa['estado-pwa'] == 1 ? 'checked' : ''; ?> required required>
              <label class="form-check-label" for="ativo">Ativo</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="estado" id="inativo" value="0" <?= $infoPwa['estado-pwa'] == 1 ? 'checked' : ''; ?> required checked>
              <label class="form-check-label" for="inativo">Inativo</label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
        <!-- [-] Formulário para gerar projeto-pwa.json -->
          </div>
        </div>
        <!-- [-]Card do form de atualização do PWA -->


      
        

        

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

    // Submeter o formulário via AJAX
          $('#pwaForm').on('submit', function(event) {
            event.preventDefault();
            
            $.ajax({
              url: 'save_details.php',
              type: 'POST',
              data: $(this).serialize(),
              success: function(response) {
                alert('Dados salvos com sucesso!');
              },
              error: function(xhr, status, error) {
                alert('Erro ao salvar os dados.');
              }
            });
          });


    });
  </script>
</body>
</html>
