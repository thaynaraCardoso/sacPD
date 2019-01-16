<?php
require_once 'models/AtividadeModel.php';
require_once 'models/PraticaDidaticaModel.php';
require_once 'models/RoteiroModel.php';


/**
 * @package Pratica Didática
 * @internal Responsável por gerenciar o fluxo de dados entre
 * a camada de modelo e a de visualização
 * 
 * Camada - Controladores ou Controllers
 * Diretório Pai - controllers
 * Arquivo - AtividadeController.php
 * 
 * @author Thaynara Cardoso
 * @version 0.1.1
 *
 */
class AtividadeController
{
	public function listarAtividadesAction()
	{
		//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		if( isset($_REQUEST['in_idroteiro']) )
			if( DataValidator::isNumeric($_REQUEST['in_idroteiro']) )
			{
				$o_roteiro = new RoteiroModel();
				$o_roteiro->loadById($_REQUEST['in_idroteiro']);
				
				$o_praticadidatica = new PraticaDidaticaModel();
				$o_praticadidatica->loadById($_REQUEST['in_idpraticadidatica']);
				
				
				$o_atividade = new AtividadeModel();
				$v_atividades = $o_atividade->_list($_GET['in_idpraticadidatica']);
				
				$o_view = new View('views/listarAtividades.phtml');
				$o_view->setParams(array('o_roteiro' => $o_roteiro,'o_praticadidatica' => $o_praticadidatica, 'v_atividades' => $v_atividades));
				$o_view->showContents();
			}
	}



	public function listarAtividadesPublicasAction()
	{
		//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		if( isset($_REQUEST['in_idroteiro']) )
			if( DataValidator::isNumeric($_REQUEST['in_idroteiro']) )
			{
				$o_roteiro = new RoteiroModel();
				$o_roteiro->loadById($_REQUEST['in_idroteiro']);
				
				$o_praticadidatica = new PraticaDidaticaModel();
				$o_praticadidatica->loadById($_REQUEST['in_idpraticadidatica']);
				
				
				$o_atividade = new AtividadeModel();
				$v_atividades = $o_atividade->_list($_GET['in_idpraticadidatica']);
				
				$o_view = new View('views/listarAtividadesPublicas.phtml');
				$o_view->setParams(array('o_roteiro' => $o_roteiro,'o_praticadidatica' => $o_praticadidatica, 'v_atividades' => $v_atividades));
				$o_view->showContents();
			}
	}
	
	public function manterAtividadeAction()
	{
		
	/*	foreach ($_POST as $key => $value) {
  		echo '<p>'.$key.'</p>';
 		 foreach($value as $k => $v)
  		{
 			 echo '<p>'.$k.'</p>';
 		 echo '<p>'.$v.'</p>';
 		 echo '<hr />';
  		}

		}

	foreach($_FILES as $key => $value){
			echo '<p>'.$key.'</p>';
 		 foreach($value as $k => $v)
  		{
 			 echo '<p>'.$k.'</p>';
 		 echo '<p>'.$v.'</p>';
 		 echo '<hr />';
  		}
	} */
		//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		$o_roteiro = new RoteiroModel();
		$o_praticadidatica = new PraticaDidaticaModel();
		$o_atividade = new AtividadeModel();
		
		if( isset($_REQUEST['in_idroteiro']) )
			if( DataValidator::isInteger($_REQUEST['in_idroteiro']) )
				$o_roteiro->loadById($_REQUEST['in_idroteiro']);
		
		if( isset($_REQUEST['in_idpraticadidatica']) )
			if( DataValidator::isInteger($_REQUEST['in_idpraticadidatica']) )
				$o_praticadidatica->loadById($_REQUEST['in_idpraticadidatica']);
			
		if( isset($_REQUEST['in_idatividade']) )
			if( DataValidator::isInteger($_REQUEST['in_idatividade']) )
				$o_atividade->loadById($_REQUEST['in_idatividade']);
				
		if(count($_POST) > 0)
		{
		    $arquivo = NULL;
			$arquivo = $_FILES['in_materialapoioatividade']['tmp_name']; 
			$tamanho = $_FILES['in_materialapoioatividade']['size'];
			$tipo    = $_FILES['in_materialapoioatividade']['type'];
			$nome    = $_FILES['in_materialapoioatividade']['name'];
		

			if ( $arquivo != NULL )
			{
				$fp = fopen($arquivo, "rb");
				$conteudo = fread($fp, $tamanho);
				$conteudo = addslashes($conteudo);
				fclose($fp); 
			}
		
			$o_atividade->setDescricaoAtividade($_POST['in_descricaoatividade']);
			$o_atividade->setMaterialApoioAtividade($conteudo);
			$o_atividade->setTipoMaterialApoio($tipo);
			$o_atividade->setNomeMaterialApoio($nome);
			$o_atividade->setTipoAtividade(DataFilter::cleanString($_POST['in_tipoatividade']));
			$o_atividade->setPraticaDidaticaId($o_praticadidatica->getIdPraticaDidatica());
			if($o_atividade->save() > 0)
				Application::redirect('?controle=Atividade&acao=listarAtividades&in_idroteiro='.$o_roteiro->getIdRoteiro().'&in_idpraticadidatica='.$o_praticadidatica->getIdPraticaDidatica());
		}
			
		$o_view = new View('views/manterAtividade.phtml');
		$o_view->setParams(array('o_roteiro' => $o_roteiro,'o_praticadidatica' => $o_praticadidatica, 'o_atividade' => $o_atividade));
		$o_view->showContents();
	}
	
	public function apagarAtividadeAction()
	{
		//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		if( isset($_GET['in_idatividade']) )
			if( DataValidator::isInteger($_GET['in_idatividade']))
			{
				$o_atividade = new AtividadeModel();
				$o_atividade->loadById($_GET['in_idatividade']);
				$o_atividade->delete();
				Application::redirect('?controle=Atividade&acao=listarAtividades&in_idroteiro='.$_GET['in_idroteiro'].'&in_idpraticadidatica='.$_GET['in_idpraticadidatica']);
			}	
	}
}	