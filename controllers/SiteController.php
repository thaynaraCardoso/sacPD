<?php
require_once 'models/AtividadeModel.php';
require_once 'models/PraticaDidaticaModel.php';
require_once 'models/RoteiroModel.php';
require_once 'models/UsuarioModel.php';
/**
* @package Pratica Didática
* @author Thaynara Cardoso
* @version 0.1.1
* 
* Camada - Controladores ou Controllers
* Diretório Pai - controllers 
* 
* Controlador que deverá ser chamado quando não for
* especificado nenhum outro
*/
class SiteController
{
	/**
	* Ação que deverá ser executada quando nenhuma outra for especificada, do mesmo jeito que o
	* arquivo index.html ou index.php é executado quando nenhum é
	* referenciado
	*/
	public function mostrarSiteAction()
	{
		//caso o usuário tente acessar diretamente a URL
		if (!isset($_SESSION['idUsuario'])) {
			header("location: index.php?controle=Usuario&acao=loginUsuario");
		}
		//redirecionando para a pagina de lista de Roteiros
		//header('Location: ?controle=Roteiro&acao=listarRoteiro');
		//header('Location: ?controle=Site&acao=listarSite');
		$o_view = new View('views/listarSite.phtml');
	//	$o_view->setParams(array('o_usuario' => $o_usuario));
		$o_view->showContents();
	}
}
?>