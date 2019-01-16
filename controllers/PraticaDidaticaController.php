<?php
require_once 'models/PraticaDidaticaModel.php';
require_once 'models/RoteiroModel.php';

/**
 * @package Pratica Didática
 * Responsável por gerenciar o fluxo de dados entre
 * a camada de modelo e a de visualização
 * 
 * Camada - Controladores ou Controllers
 * Diretório Pai - controllers
 * Arquivo - PraticaDidaticaController.php
 * 
 * @author Thaynara Cardoso
 * @version 0.1.1
 *
 */
class PraticaDidaticaController
{
	public function listarPraticasDidaticasAction()
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
				$v_praticasdidaticas = $o_praticadidatica->_list($_GET['in_idroteiro']);
				$o_view = new View('views/listarPraticasDidaticas.phtml');
				$o_view->setParams(array('o_roteiro' => $o_roteiro,'v_praticasdidaticas' => $v_praticasdidaticas));
				$o_view->showContents();
			}
	}
	
	public function listarPraticasDidaticasPublicasAction()
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
				$v_praticasdidaticas = $o_praticadidatica->_list($_GET['in_idroteiro']);
				$o_view = new View('views/listarPraticasDidaticasPublicas.phtml');
				$o_view->setParams(array('o_roteiro' => $o_roteiro,'v_praticasdidaticas' => $v_praticasdidaticas));
				$o_view->showContents();
			}
	}
	
	public function manterPraticaDidaticaAction()
	{
	//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		$o_roteiro = new RoteiroModel();
		$o_praticadidatica = new PraticaDidaticaModel();
		
		if( isset($_REQUEST['in_idroteiro']) )
			if( DataValidator::isInteger($_REQUEST['in_idroteiro']) )
				$o_roteiro->loadById($_REQUEST['in_idroteiro']);
			
		if( isset($_REQUEST['in_idpraticadidatica']) )
			if( DataValidator::isInteger($_REQUEST['in_idpraticadidatica']) )
				$o_praticadidatica->loadById($_REQUEST['in_idpraticadidatica']);
				
		if(count($_POST) > 0)
		{
		    $o_praticadidatica->setMotivacaoPratica($_POST['in_motivacaopratica']);
			$o_praticadidatica->setConclusaoPratica($_POST['in_conclusaopratica']);
			$o_praticadidatica->setAvaliacaopratica($_POST['in_avaliacaopratica']);
			$o_praticadidatica->setRoteiroId($o_roteiro->getIdRoteiro());
			if($o_praticadidatica->save() > 0)
				Application::redirect('?controle=PraticaDidatica&acao=listarPraticasDidaticas&in_idroteiro='.$o_roteiro->getIdRoteiro());
		}
			
		$o_view = new View('views/manterPraticaDidatica.phtml');
		$o_view->setParams(array('o_roteiro' => $o_roteiro,'o_praticadidatica' => $o_praticadidatica));
		$o_view->showContents();
	}
	
	public function apagarPraticaDidaticaAction()
	{
	//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		if( isset($_GET['in_idpraticadidatica']) )
			if( DataValidator::isInteger($_GET['in_idpraticadidatica']))
			{
				$o_praticadidatica = new PraticaDidaticaModel();
				$o_praticadidatica->loadById($_GET['in_idpraticadidatica']);
				$o_praticadidatica->delete();
				Application::redirect('?controle=PraticaDidatica&acao=listarPraticasDidaticas&in_idroteiro='.$_GET['in_idroteiro']);
			}	
	}
}	