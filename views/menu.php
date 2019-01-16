<!doctype html>
<html lang=''>
<head>
   <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="styles.css">
   <link rel="stylesheet" type="text/css" href="views/css/main.css">
   
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="script.js"></script>
   <title>Criar nova prática didátic</title>
</head>
<body>

<div id='cssmenu'>
<ul>
<?php

if (isset($_SESSION['nomeUsuario'])) {
    //if ($_SESSION['nomeUsuario'] != "") {
    echo '      
                    <span class="banner">';
                         echo " SACPD - Sistema de apoio ao compartilhamento de práticas didáticas" ;
                          echo '
                     </span>';
}

echo '      <span class="banner-menor">';
                        $nome = Explode(" ",$_SESSION['nomeUsuario']);
                        $primeiro_nome = $nome[0];
                        echo "Olá  ". $primeiro_nome . "!" ;
                        echo '
            </span>';

    if (isset($_SESSION['nomeUsuario'])) {
        echo '<li class="selected"><a href="index.php">Home</a></li>
          <li><a href="?controle=Roteiro&acao=listarRoteiro">Meus Roteiros</a></li>    
		  <li><a href="?controle=Roteiro&acao=listarRoteiroPublico">Roteiros Públicas</a></li>';
	if($_SESSION['perfilUsuario']==0){//se usuario for administrador (perfil=0)
	    echo  '<li><a href="?controle=Usuario&acao=listarUsuario">Gerenciar Usuários</a></li>';
	    echo  '<li><a href="?controle=AreaAtuacao&acao=listarAreaAtuacao">Gerenciar Áreas de Atuação</a></li>';
	    echo  '<li><a href="?controle=Instituicao&acao=listarInstituicao">Gerenciar Instituições</a></li>';
	}
	echo '<li><a href="logout.php">Encerrar Sessão</a></li>';
  }?>
</ul>
</div>
</body>
</html>