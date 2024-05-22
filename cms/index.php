<!DOCTYPE html>

<?php 
 include('functions.php');
 $infoPwa = getPwaInfo();

 

 ?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CMS</title>
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
        <h2>Bem-vindo ao CMS do PWA (<?=getLastSegment(BASE_DIR) ?>)</h2>
        <p>Escolha uma opção no menu para adicionar conteúdo.</p>

         <!-- [+]Card com informações do PWA -->
        
        <div class="card mt-4">
          <div class="card-header">
          <?= $infoPwa['titulo'] ?>
          </div>
          <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted"><?= $infoPwa['sub-titulo'] ?></h6>
            <p class="card-text">
              <strong>PWA ID:</strong> <span id="pwa-id"><?= $infoPwa['app-id'] ?></span><br>
              <strong>Tamanho:</strong> <span id="pwa-size"><?= $infoPwa['tamanho'] ?></span><br>
              <strong>Diretório Base:</strong> <span id="pwa-base-directory"><?= $infoPwa['diretorio-base'] ?></span>
              
            </p>
          </div>
        </div>
        <!-- [-]Card do pwa -->
<br>
        
       

       <!-- [+]card conteúdo -->
       <?php
        $c_conteudo = lerConteudo('todos');
       // $c_texto = lerConteudo('text');
       // $c_audio = lerConteudo('audio');
       // $c_video = lerConteudo('video');
      
       ?>

       <?php if ($c_conteudo) {?>
        <h2>Conteúdos</h2>
       <div class="card mt-4">
  <div class="card-header">
   Conteúdo do PWA
  </div>
  <div class="card-body">
    <ol class="list-group list-group-numbered">
    <?php foreach ($c_conteudo as $item): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div class="ms-2 me-auto">
        <div>
        <?php
                switch ($item['tipo']) {
                  case 'text':
                    echo '<i class="fas fa-file-alt"></i> ';
                    break;
                  case 'audio':
                    echo '<i class="fas fa-file-audio"></i> ';
                    break;
                  case 'video':
                    echo '<i class="fas fa-file-video"></i> ';
                    break;
                  default:
                    echo '<i class="fas fa-file"></i> ';
                    break;
                };
                echo htmlspecialchars($item['titulo']);
                ?>

          </div>
        </div>
       
          <button type="submit" class="btn btn-danger" data-arquivo="<?= htmlspecialchars($item['arquivo']); ?>">Excluir</button>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</div>

       <?php }; ?>
        <!-- [-]card conteúdo -->

      

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
