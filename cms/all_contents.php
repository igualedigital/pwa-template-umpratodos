<!DOCTYPE html>

<?php 
 include('functions.php');
 $infoPwa = getPwaInfo();

//$c_conteudo = lerConteudo('todos');
$c_audio = lerConteudo('audio');
$c_video = lerConteudo('video');
$c_texto = lerConteudo('text');

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
        <h2>Conteúdos do PWA</h2>
        
       <!-- [+]card conteúdo: Audio -->
    

       <?php if ($c_audio) {?>
        <hr>
       <div class="card mt-4">
  <div class="card-header">
   Conteúdo em Áudio
  </div>
  <div class="card-body">
    <ol class="list-group list-group-numbered">
    <?php foreach ($c_audio as $item): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div class="ms-2 me-auto">
        <div>
        <?php
        $icon = null;
                switch ($item['tipo']) {
                  case 'text':
                    echo '<i class="fas fa-file-alt"></i> ';
                    $icon = '<i class="fas fa-file-alt"></i>';

                    break;
                  case 'audio':
                    echo '<i class="fas fa-file-audio"></i> ';
                    $icon = '<i class="fas fa-file-audio"></i>';
                    break;
                  case 'video':
                    echo '<i class="fas fa-file-video"></i> ';
                    $icon = '<i class="fas fa-file-video"></i>';
                    break;
                  default:
                    echo '<i class="fas fa-file"></i> ';
                    $icon = '<i class="fas fa-file"></i>';
                    break;
                };
                echo htmlspecialchars($item['titulo']);
             
                ?>

          </div>
        </div>
       
        <div>
          <button type="submit" id="btn_details" class="btn btn-info btn-details" data-tipo="<?= htmlspecialchars($item['tipo'] ?? ''); ?>" data-icon="<?= htmlspecialchars($icon ?? '');?>" data-titulo="<?= htmlspecialchars($item['titulo'] ?? ''); ?>" data-imagem="<?= htmlspecialchars($item['imagem'] ?? ''); ?>" data-descricao="<?= htmlspecialchars($item['descricao-da-imagem'] ?? ''); ?>" data-arquivo="<?=htmlspecialchars($item['arquivo'] ?? ''); ?>"><i class="fa-solid fa-binoculars"></i> Exibir</button>
          <button type="submit" id="btn_delete" class="btn btn-danger" data-arquivo="<?= htmlspecialchars($item['arquivo']); ?>"><i class="fa-solid fa-trash-can"></i> Excluir</button>
        </div>
        
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</div>

       <?php }; 
       $item = null;
       ?>


        <!-- [-]card conteúdo: Video -->

        <?php if ($c_video) {?>
        <hr>
       <div class="card mt-4">
  <div class="card-header">
   Conteúdo em vídeo
  </div>
  <div class="card-body">
    <ol class="list-group list-group-numbered">
    <?php foreach ($c_video as $item): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div class="ms-2 me-auto">
        <div>
        <?php
        $icon = null;
                switch ($item['tipo']) {
                  case 'text':
                    echo '<i class="fas fa-file-alt"></i> ';
                    $icon = '<i class="fas fa-file-alt"></i>';

                    break;
                  case 'audio':
                    echo '<i class="fas fa-file-audio"></i> ';
                    $icon = '<i class="fas fa-file-audio"></i>';
                    break;
                  case 'video':
                    echo '<i class="fas fa-file-video"></i> ';
                    $icon = '<i class="fas fa-file-video"></i>';
                    break;
                  default:
                    echo '<i class="fas fa-file"></i> ';
                    $icon = '<i class="fas fa-file"></i>';
                    break;
                };
                echo htmlspecialchars($item['titulo']);
             
                ?>

          </div>
        </div>
       
        <div>
          <button type="submit" id="btn_details" class="btn btn-info btn-details" data-tipo="<?= htmlspecialchars($item['tipo'] ?? ''); ?>" data-icon="<?= htmlspecialchars($icon ?? '');?>" data-titulo="<?= htmlspecialchars($item['titulo'] ?? ''); ?>" data-imagem="<?= htmlspecialchars($item['imagem'] ?? ''); ?>" data-descricao="<?= htmlspecialchars($item['descricao-da-imagem'] ?? ''); ?>" data-arquivo="<?=htmlspecialchars($item['arquivo'] ?? ''); ?>"><i class="fa-solid fa-binoculars"></i> Exibir</button>
          <button type="submit" id="btn_delete" class="btn btn-danger" data-arquivo="<?= htmlspecialchars($item['arquivo']); ?>"><i class="fa-solid fa-trash-can"></i> Excluir</button>
        </div>
        
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</div>

       <?php }; 
       $item = null;
       ?>
        <!-- [-]card conteúdo: Video -->

         <!-- [-]card conteúdo: Texto -->

         <?php if ($c_texto) {?>
        <hr>
       <div class="card mt-4">
  <div class="card-header">
   Conteúdo em Texto
  </div>
  <div class="card-body">
    <ol class="list-group list-group-numbered">
    <?php foreach ($c_texto as $item): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div class="ms-2 me-auto">
        <div>
        <?php
        $icon = null;
                switch ($item['tipo']) {
                  case 'text':
                    echo '<i class="fas fa-file-alt"></i> ';
                    $icon = '<i class="fas fa-file-alt"></i>';

                    break;
                  case 'audio':
                    echo '<i class="fas fa-file-audio"></i> ';
                    $icon = '<i class="fas fa-file-audio"></i>';
                    break;
                  case 'video':
                    echo '<i class="fas fa-file-video"></i> ';
                    $icon = '<i class="fas fa-file-video"></i>';
                    break;
                  default:
                    echo '<i class="fas fa-file"></i> ';
                    $icon = '<i class="fas fa-file"></i>';
                    break;
                };
                echo htmlspecialchars($item['titulo']);
             
                ?>

          </div>
        </div>
       
        <div>
          <button type="submit" id="btn_details" class="btn btn-info btn-details" data-tipo="<?= htmlspecialchars($item['tipo'] ?? ''); ?>" data-icon="<?= htmlspecialchars($icon ?? '');?>" data-titulo="<?= htmlspecialchars($item['titulo'] ?? ''); ?>" data-imagem="<?= htmlspecialchars($item['imagem'] ?? ''); ?>" data-descricao="<?= htmlspecialchars($item['descricao-da-imagem'] ?? ''); ?>" data-arquivo="<?=htmlspecialchars($item['arquivo'] ?? ''); ?>"><i class="fa-solid fa-binoculars"></i> Exibir</button>
          <button type="submit" id="btn_delete" class="btn btn-danger" data-arquivo="<?= htmlspecialchars($item['arquivo']); ?>"><i class="fa-solid fa-trash-can"></i> Excluir</button>
        </div>
        
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</div>

       <?php }; 
       $item = null;
       ?>
        <!-- [-]card conteúdo: text -->



      
 <!-- [+] Modal -->
 <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModalLabel">Detalhes do Conteúdo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5 id="modal-title"></h5>
        <p id="modal-description"></p>
          <img id="modal-image" src="" alt="Imagem do Conteúdo" class="img-fluid w-100 mb-3" style="display: none;">
        <div id="modal-content">
          <!-- O conteúdo (texto, áudio ou vídeo) será inserido aqui -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
        <!-- [-] Modal -->

      </main>
    </div>
  </div>
      
        
  <?php include('footer.php'); ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
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

      // Handle details button click
      $('.btn-details').on('click', function() {
    var tipo = $(this).data('tipo');
    var titulo = $(this).data('titulo');
    var imagem = null;
    var icon = $(this).data('icon');

    if($(this).data('imagem') !== ''){
      var imagem = '../storage/media/image/'+$(this).data('imagem');
    }
    
    var descricao = $(this).data('descricao');
    var arquivo = '../storage/media/'+tipo+'/'+$(this).data('arquivo');

    
    $('#modal-title').text(titulo);
    $('#modal-description').text(descricao);
    
    $('.modal-title').html(icon+' Detalhes do conteúdo <small>Formato:' + tipo+'</small>');
    if(descricao === ''){
        descricao = "Imagem sem descrição";
      }

    if (imagem) {
      $('#modal-image').attr('src', imagem).show();
      
      $('#modal-image').attr('title', descricao);
      $('#modal-image').attr('alt', descricao);
    } else {
      $('#modal-image').hide();
    }

    var contentHtml = '';
    if (tipo === 'text') {
      contentHtml = '<article class="text-content">delaiiissss</article>';
      
      $('#modal-content').html(contentHtml);
      setTimeout(function() {
        $('.text-content').load(arquivo);
      }, 100); // Atraso de 100ms para garantir que o elemento esteja no DOM
    } else if (tipo === 'audio') {
      contentHtml = '<audio controls style="width: 100%;"><source src="' + arquivo + '" type="audio/mp4">Your browser does not support the audio tag.</audio>';
    } else if (tipo === 'video') {
      contentHtml = '<video controls width="100%"><source src="' + arquivo + '" type="video/mp4">Your browser does not support the video tag.</video>';
    }
    $('#modal-content').html(contentHtml);

    $('#detailsModal').modal('show');
  });

  // Parar a mídia ao fechar o modal
  $('#detailsModal').on('hidden.bs.modal', function () {
    $('#modal-content').html('');
  });

    });
  </script>
</body>
</html>
