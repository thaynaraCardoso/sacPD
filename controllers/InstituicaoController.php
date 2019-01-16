<?php
//incluindo classes da camada Model
require_once 'models/InstituicaoModel.php';


/**
 * @package Pratica Didática
 * Responsável por gerenciar o fluxo de dados entre
 * a camada de modelo e a de visualização
 * 
 * Camada - Controladores ou Controllers
 * Diretório Pai - controllers
 * Arquivo - InstituicaoController.php
 * 
 * @author Thaynara Cardoso
* @version 0.1.1
 *
 */

	/**
	* Efetua a manipulação dos modelos necessários
	* para a aprensentação da lista de Instituicoes
	*/
class InstituicaoController
{

	public function listarInstituicaoAction()
	{
		//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		$o_instituicao = new InstituicaoModel();
		
		//Listando as Instituicoes cadastradas
		$v_instituicoes = $o_instituicao->_list();
		
		//definindo qual o arquivo HTML que será usado para
		//mostrar a lista de Instituicoes
		$o_view = new View('views/listarInstituicao.phtml');
		
		//Passando os dados das Instituicoes para a View
		$o_view->setParams(array('v_instituicoes' => $v_instituicoes));
		
		//Imprimindo código HTML
		$o_view->showContents();
	}
	
	/**
	* Gerencia a  de criação
	* e edição das Instituicoes 
	*/
	public function manterInstituicaoAction()
	{
		//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		$o_instituicao = new InstituicaoModel();
		
		//verificando se o id foi passado
		if( isset($_REQUEST['in_idinstituicao']) )
			//verificando se o id passado é valido
			if( DataValidator::isNumeric($_REQUEST['in_idinstituicao']) )
				//buscando dados da Instituicao
				$o_instituicao->loadById($_REQUEST['in_idinstituicao']);
			
		if(count($_POST) > 0)
		{
			$o_instituicao->setNomeInstituicao(DataFilter::cleanString($_POST['st_nomeinstituicao']));
		//salvando dados e redirecionando para a lista de Instituicoes
			if($o_instituicao->save() > 0)
				Application::redirect('?controle=Instituicao&acao=listarInstituicao');
		}
			
		$o_view = new View('views/manterInstituicao.phtml');
		$o_view->setParams(array('o_instituicao' => $o_instituicao));
		$o_view->showContents();
	}
	
	/**
	* Gerencia a requisições de exclusão das Instituicoes
	*/
	public function apagarInstituicaoAction()
	{
		//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		if( DataValidator::isNumeric($_GET['in_idinstituicao']) )
		{
			//apagando a Instituicao
			$o_instituicao = new InstituicaoModel();
			$o_instituicao->loadById($_GET['in_idinstituicao']);
			$o_instituicao->delete();
			
			Application::redirect('?controle=Instituicao&acao=listarInstituicao');
		}	
	}
}
?>