<?php
//incluindo classes da camada Model
require_once 'models/UsuarioModel.php';
require_once 'models/AreaAtuacaoModel.php';
require_once 'models/InstituicaoModel.php';
require_once 'models/RoteiroModel.php';



/**
 * @package Pratica Didática
 * Responsável por gerenciar o fluxo de dados entre
 * a camada de modelo e a de visualização
 * 
 * Camada - Controladores ou Controllers
 * Diretório Pai - controllers
 * Arquivo - UsuarioController.php
 * 
 * @author Thaynara Cardoso
* @version 0.1.1
 *
 */
class UsuarioController
{
	/**
	* Efetua a manipulação dos modelos necessários
	* para a aprensentação da lista de Usuarios
	*/
	public function listarUsuarioAction()
	{
		//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		$o_usuario = new UsuarioModel();
		$o_areaatuacao = new AreaAtuacaoModel();
		$o_instituicao = new InstituicaoModel();
		
		//Listando os usuários cadastrados
		$v_usuarios = $o_usuario->_list();
		$v_areasatuacao = $o_areaatuacao->_list();
		$v_instituicao = $o_instituicao->_list();
		
		//definindo qual o arquivo HTML que será usado para
		//mostrar a lista de usuários
		$o_view = new View('views/listarUsuario.phtml');
		
		//Passando os dados do usuáios para a View
		$o_view->setParams(array('v_usuarios' => $v_usuarios,'v_areasatuacao'=>$v_areasatuacao,'v_instituicoes'=>$v_instituicao));
		
		//Imprimindo código HTML
		$o_view->showContents();
	}
	
	
	/**
	* Gerencia a  de criação
	* e edição dos Usuários 
	*/
	public function manterUsuarioAction()
	{
	//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		
		$o_usuario = new UsuarioModel();
		$o_areaatuacao = new AreaAtuacaoModel();
		$o_instituicao = new InstituicaoModel();
		
		//verificando se o id do usuario foi passado
		if(isset($_REQUEST['in_idusuario']) )
			//verificando se o id passado é valido
			if( DataValidator::isNumeric($_REQUEST['in_idusuario']) ) {
				//buscando dados do contato
				$o_usuario->loadById($_REQUEST['in_idusuario']);
				$v_areasatuacao = $o_areaatuacao->_list();
				$v_instituicao = $o_instituicao->_list();
			}
		
			
		if(count($_POST) > 0)
		{
			$o_usuario->setEmailUsuario(DataFilter::cleanString($_POST['st_emailusuario']));
			$o_usuario->setIdAreaAtuacaoUsuario(DataFilter::cleanString($_POST['st_idareaatuacaousuario']));
			$o_usuario->setIdInstituicaoUsuario(DataFilter::cleanString($_POST['st_idinstituicaousuario']));
			$o_usuario->setSenhaUsuario(DataFilter::cleanString($_POST['st_senhausuario']));
			$o_usuario->setNomeUsuario(DataFilter::cleanString($_POST['st_nomeusuario']));
			$o_usuario->setPerfilUsuario(DataFilter::cleanString($_POST['st_perfilusuario']));
						
			//salvando dados e redirecionando para a lista de Usuarios
			if($o_usuario->save() > 0)
				Application::redirect('?controle=Usuario&acao=listarUsuario');
		}
			
		$o_view = new View('views/manterUsuario.phtml');
		$o_view->setParams(array('o_usuario' =>$o_usuario,'v_areasatuacao'=>$v_areasatuacao,'v_instituicoes'=>$v_instituicao));
		$o_view->showContents();
	}
	
	
	/**
	* Gerencia a o login dos usuarios
	*  
	*/
	public function loginUsuarioAction()
	{
		$o_usuario = new UsuarioModel();

	// trecho abaixo testa varíaveis recebidas (retirar para colocar
	// em produção
	//
	//foreach($_POST as $key => $value) {
    //	if (strpos($key, 'substring_')>=0) {
      //  	echo "KEY:". $key."<br>";
     //   	echo "VALOR:".$value."<br>";
    //	}
	//}

	//Se há uma sessão ativa, então logou recebe S senão, receberá null, pois
	//é o primeiro acesso
	if (isset($_SESSION['nomeUsuario'])) {
	$logou='S';
	Application::redirect('?controle=Site&acao=mostrarSite');
	}
	else $logou=null;

		
		//verificando se o id do usuario foi passado
		if( isset($_POST['st_emailusuario']) ){

			//se há um POST pelo menos
			if(count($_POST) > 0)
			{
				//salvando dados e redirecionando para pagina inicial do site
				if($o_usuario->logar($_REQUEST['st_emailusuario'], $_REQUEST['st_senhausuario']) > 0){
					Application::redirect('?controle=Site&acao=mostrarSite');
					$logou='S'; //usuario e senha válidos
			}
			else $logou='N';//usuário ou senha inválidos
		
		}
		}
		$o_view = new View('views/loginUsuario.phtml');
		$o_view->setParams(array('o_usuario' => $o_usuario, 'v_logado'=>$logou));
		$o_view->showContents();
	}
	
	/**
	* Gerencia a requisições de exclusão dos Roteiros
	*/
	public function apagarUsuarioAction()
	{
	//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		if( DataValidator::isNumeric($_GET['in_idusuario']) )
		{
			//apagando o contato
			$o_usuario = new UsuarioModel();
			$o_usuario->loadById($_GET['in_idusuario']);
			$o_usuario->delete();
			
			//Apagando os Práticas Roteiros do Usuario
			//reacao em cadeia até apagar todas as atividades
			$o_roteiro = new RoteiroModel();
			$v_roteiro = $o_roteiro->_list($_GET['in_idusuario']);
			foreach($v_roteiro AS $o_roteiro)
				$o_roteiro->delete();
			Application::redirect('?controle=Usuario&acao=listarUsuario');
		}	
	}
}
?>