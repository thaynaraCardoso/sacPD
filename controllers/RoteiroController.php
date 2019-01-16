<?php
//incluindo classes da camada Model
require_once 'models/RoteiroModel.php';


/**
 * @package Pratica Didática
 * Responsável por gerenciar o fluxo de dados entre
 * a camada de modelo e a de visualização
 * 
 * Camada - Controladores ou Controllers
 * Diretório Pai - controllers
 * Arquivo - RoteiroController.php
 * 
 * @author Thaynara Cardoso
* @version 0.1.1
 *
 */

	/**
	* Efetua a manipulação dos modelos necessários
	* para a aprensentação da lista de Roteiros
	*/
class RoteiroController
{

	public function listarRoteiroAction()
	{
		//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		$o_Roteiro = new RoteiroModel();
		
		//Listando os roteiros cadastrados
		$v_roteiros = $o_Roteiro->_list($_SESSION['idUsuario']);
		
		//definindo qual o arquivo HTML que será usado para
		//mostrar a lista de roteiros
		$o_view = new View('views/listarRoteiro.phtml');
		
		//Passando os dados do roteiros para a View
		$o_view->setParams(array('v_roteiros' => $v_roteiros));
		
		//Imprimindo código HTML
		$o_view->showContents();
	}
	
	public function listarRoteiroPublicoAction()
	{
		//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		$o_Roteiro = new RoteiroModel();
		
		//Listando os roteiros cadastrados
		$v_roteiros = $o_Roteiro->_listP();
		
		//definindo qual o arquivo HTML que será usado para
		//mostrar a lista de roteiros
		$o_view = new View('views/listarRoteiroPublico.phtml');
		
		//Passando os dados do roteiros para a View
		$o_view->setParams(array('v_roteiros' => $v_roteiros));
		
		//Imprimindo código HTML
		$o_view->showContents();
	}
	
	/**
	* Gerencia a  de criação
	* e edição dos Roteiros 
	*/
	public function manterRoteiroAction()
	{
		//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		$o_roteiro = new RoteiroModel();
		
		//verificando se o id do roteiro foi passado
		if( isset($_REQUEST['in_idroteiro']) )
			//verificando se o id passado é valido
			if( DataValidator::isNumeric($_REQUEST['in_idroteiro']) )
				//buscando dados do roteiros
				$o_roteiro->loadById($_REQUEST['in_idroteiro']);
			
		if(count($_POST) > 0)
		{
			$o_roteiro->setTituloRoteiro(DataFilter::cleanString($_POST['st_tituloroteiro']));
			$o_roteiro->setObjEspecificoRoteiro(DataFilter::cleanString($_POST['st_objespecificoroteiro']));
			$o_roteiro->setConteudoBasicoRoteiro(DataFilter::cleanString($_POST['st_conteudobasicoroteiro']));
			$o_roteiro->setPalavraChaveRoteiro(DataFilter::cleanString($_POST['st_palavrachaveroteiro']));
			$o_roteiro->setIdVisibilidade(DataFilter::cleanString($_POST['st_idvisibilidade']));
			$o_roteiro->setIdUsuario(DataFilter::cleanString($_SESSION['idUsuario']));
			
			//salvando dados e redirecionando para a lista de Roteiros
			if($o_roteiro->save() > 0)
				Application::redirect('?controle=Roteiro&acao=listarRoteiro');
		}
			
		$o_view = new View('views/manterRoteiro.phtml');
		$o_view->setParams(array('o_roteiro' => $o_roteiro));
		$o_view->showContents();
	}
	
	/**
	* Gerencia a requisições de exclusão dos Roteiros
	*/
	public function apagarRoteiroAction()
	{
		//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		if( DataValidator::isNumeric($_GET['in_idroteiro']) )
		{
			//apagando o roteiro
			$o_roteiro = new RoteiroModel();
			$o_roteiro->loadById($_GET['in_idroteiro']);
			$o_roteiro->delete();
			
			//Apagando os Práticas Didáticas do Roteiro
			$o_praticadidatica = new PraticaDidaticaModel();
			$v_praticadidatica = $o_praticadidatica->_list($_GET['in_idroteiro']);
			foreach($v_praticadidatica AS $o_praticadidatica)
				$o_praticadidatica->delete();
			Application::redirect('?controle=Roteiro&acao=listarRoteiro');
		}	
	}
}
?>