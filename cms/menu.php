<ul class="nav flex-column">
<li class="nav-item">
    <a class="nav-link" href="index">Início</a>
  </li>
<li class="nav-item">
    <a class="nav-link" href="settings">Configurações</a>
  </li>
  <?php
// check de conteudo
$conteudo = new pwaContents();
$temConteudo = $conteudo->listarConteudo('todos');


if (!empty($temConteudo)) {
    echo '<li class="nav-item">';
    echo '<a class="nav-link" href="all_contents">Conteúdos</a>';
    echo '</li>';
};
  ?>
 
  <li class="nav-item">
    <a class="nav-link" href="add_text">Adicionar Texto</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="add_audio">Adicionar Áudio</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="add_video">Adicionar Vídeo</a>
  </li>
  <li style="text-align:center;"><small><a href="version">Versão 1.0.0</a></small></li>
</ul>
