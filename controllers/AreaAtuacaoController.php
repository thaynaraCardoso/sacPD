<?php
//incluindo classes da camada Model
require_once 'models/AreaAtuacaoModel.php';


/**
 * @package Pratica Didática
 * Responsável por gerenciar o fluxo de dados entre
 * a camada de modelo e a de visualização
 * 
 * Camada - Controladores ou Controllers
 * Diretório Pai - controllers
 * Arquivo - AreaAtuacaoController.php
 * 
 * @author Thaynara Cardoso
* @version 0.1.1
 *
 */

	/**
	* Efetua a manipulação dos modelos necessários
	* para a aprensentação da lista de Areas de Atuacao
	*/
class AreaAtuacaoController
{

	public function listarAreaAtuacaoAction()
	{
		//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		$o_areaatuacao = new AreaAtuacaoModel();
		
		//Listando as Areas de Atuação cadastradas
		$v_areasatuacao = $o_areaatuacao->_list();
		
		//definindo qual o arquivo HTML que será usado para
		//mostrar a lista de areas de atuação
		$o_view = new View('views/listarAreaAtuacao.phtml');
		
		//Passando os dados das Areas de Atuação para a View
		$o_view->setParams(array('v_areasatuacao' => $v_areasatuacao));
		
		//Imprimindo código HTML
		$o_view->showContents();
	}
	
	/**
	* Gerencia a  de criação
	* e edição dos Areas de Atuação 
	*/
	public function manterAreaAtuacaoAction()
	{
		//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		$o_areaatuacao = new AreaAtuacaoModel();
		
		//verificando se o id foi passado
		if( isset($_REQUEST['in_idareaatuacao']) )
			//verificando se o id passado é valido
			if( DataValidator::isNumeric($_REQUEST['in_idareaatuacao']) )
				//buscando dados da Area de Atuacao
				$o_areaatuacao->loadById($_REQUEST['in_idareaatuacao']);
			
		if(count($_POST) > 0)
		{
			$o_areaatuacao->setDescricaoAreaAtuacao(DataFilter::cleanString($_POST['st_descricaoareaatuacao']));
		//salvando dados e redirecionando para a lista de Areas de Atuacao
			if($o_areaatuacao->save() > 0)
				Application::redirect('?controle=AreaAtuacao&acao=listarAreaAtuacao');
		}
			
		$o_view = new View('views/manterAreaAtuacao.phtml');
		$o_view->setParams(array('o_areaatuacao' => $o_areaatuacao));
		$o_view->showContents();
	}
	
	/**
	* Gerencia a requisições de exclusão das Areas de Atuacao
	*/
	public function apagarAreaAtuacaoAction()
	{
		//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		if( DataValidator::isNumeric($_GET['in_idareaatuacao']) )
		{
			//apagando a area de atuacao
			$o_areaatuacao = new AreaAtuacaoModel();
			$o_areaatuacao->loadById($_GET['in_idareaatuacao']);
			$o_areaatuacao->delete();
			
			Application::redirect('?controle=AreaAtuacao&acao=listarAreaAtuacao');
		}	
	}
}
?>