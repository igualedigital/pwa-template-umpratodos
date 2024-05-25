<!DOCTYPE html>
<?php 
 include('libs/functions.php');
 $pwaSettings = new pwaSettings();
 $infoPwa =  $pwaSettings->getPwaInfo();
 ?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Configurações</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
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
        <h2>Configurações e informações do PWA (<?=getLastSegment(PWA_DIR) ?>)</h2>
        <div class="card mt-4">
          <div class="card-header">
            Atualizar informações do projeto <?= $infoPwa['titulo'] ?>
          </div>
          <div class="card-body">
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
                <label>Estado do PWA</label>
                <input type="checkbox" id="estado" name="estado" data-toggle="toggle" data-size="xs" data-on="ativo" data-off="inativo" <?php echo ($infoPwa['estado-pwa'] == 1) ? 'checked' : ''; ?>>
              </div>
              <div class="form-group">
                <label>Autoexecução de arquivos de Áudio.</label>
                <input type="checkbox" id="autoplay-audio" name="autoplay-audio" <?php echo ($infoPwa['autoplay-audio'] == 1) ? 'checked' : ''; ?> data-toggle="toggle" data-size="xs" data-on="sim" data-off="não">
              </div>
              <div class="form-group">
                <label>Autoexecução de arquivos de Vídeo.</label>
                <input type="checkbox" id="autoplay-video" name="autoplay-video" <?php echo ($infoPwa['autoplay-video'] == 1) ? 'checked' : ''; ?> data-toggle="toggle" data-size="xs" data-on="sim" data-off="não">
              </div>
              <div class="form-group">
                <label>Executar vídeos automaticamente em modo Tela Cheia (Full Screen).</label>
                <input type="checkbox" id="auto-fullscreen" name="auto-fullscreen" <?php echo ($infoPwa['auto-fullscreen'] == 1) ? 'checked' : ''; ?> data-toggle="toggle" data-size="xs" data-on="sim" data-off="não">
              </div>
              <div class="form-group">
                <label>Retornar automaticamente a tela inicial quando não houver nenhuma atividade por tempo determinado.</label>
                <div class="custom-control custom-radio">
                    <input type="radio" id="option1" name="home-back-timer" class="custom-control-input" value="0" <?php echo ($infoPwa['home-back-timer'] == 0) ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="option1">Inativo</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="option2" name="home-back-timer" class="custom-control-input" value="10000" <?php echo ($infoPwa['home-back-timer'] == 10000) ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="option2">10 segundos</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="option3" name="home-back-timer" class="custom-control-input" value="30000" <?php echo ($infoPwa['home-back-timer'] == 30000) ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="option3">30 segundos</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="option4" name="home-back-timer" class="custom-control-input" value="60000" <?php echo ($infoPwa['home-back-timer'] == 60000) ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="option4">1 minuto</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="option5" name="home-back-timer" class="custom-control-input" value="300000" <?php echo ($infoPwa['home-back-timer'] == 300000) ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="option5">5 minutos</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="option6" name="home-back-timer" class="custom-control-input" value="600000" <?php echo ($infoPwa['home-back-timer'] == 600000) ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="option6">10 minutos</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="option7" name="home-back-timer" class="custom-control-input" value="1800000" <?php echo ($infoPwa['home-back-timer'] == 1800000) ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="option7">30 minutos</label>
                </div>
            </div>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-spinner fa-spin d-none mr-2"></i>
                Salvar Configurações
              </button>
            </form>
          </div>
        </div>
      </main>
    </div>
  </div>
  <?php include('footer.php'); ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
 
  <script>
    $(document).ready(function(){
      $('.navbar-toggler').on('click', function() {
        $('.sidebar').toggleClass('active');
      });

      $('#pwaForm').on('submit', function(event) {
        event.preventDefault();
        
        // Disable the button and show the spinner
        var $submitButton = $(this).find('button[type="submit"]');
        var $spinner = $submitButton.find('.fas');
        $submitButton.prop('disabled', true);
        $spinner.removeClass('d-none');

        $.ajax({
          url: 'libs/save_settings_ajax.php',
          type: 'POST',
          data: $(this).serialize(),
          success: function(response) {
            alert('Dados salvos com sucesso!');
            // Enable the button and hide the spinner
            $submitButton.prop('disabled', false);
            $spinner.addClass('d-none');
          },
          error: function(xhr, status, error) {
            alert('Erro ao salvar os dados.');
            // Enable the button and hide the spinner
            $submitButton.prop('disabled', false);
            $spinner.addClass('d-none');
          }
        });
      });
      
    });
  </script>
</body>
</html>
