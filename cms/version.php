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
  <title>Versão</title>
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
            Controle de versão <?= $infoPwa['titulo'] ?>
          </div>
          <div class="card-body">
              <!-- Tabela de Controle de Versão -->
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Versão</th>
                    <th>Data de Lançamento</th>
                    <th>Descrição</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    // Exemplo de dados para a tabela
                    $versoes = [
                      
                      ['versao' => '1.0.0', 'data' => '2023-01-01', 'descricao' => 'Lançamento inicial.'],
                      //['versao' => '1.1.0', 'data' => '2023-03-15', 'descricao' => 'Correção de bugs e melhorias.'],
                      //['versao' => '1.2.0', 'data' => '2023-06-10', 'descricao' => 'Nova funcionalidade de login.'],
                      //['versao' => '1.3.0', 'data' => '2023-09-05', 'descricao' => 'Aprimoramento da interface de usuário.']
                    ];
                    
                    foreach ($versoes as $versao) {
                      echo '<tr>';
                      echo '<td>' . htmlspecialchars($versao['versao']) . '</td>';
                      echo '<td>' . htmlspecialchars($versao['data']) . '</td>';
                      echo '<td>' . htmlspecialchars($versao['descricao']) . '</td>';
                      echo '</tr>';
                    }
                  ?>
                </tbody>
              </table>
            </div>
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
    
      
    });
  </script>
</body>
</html>
