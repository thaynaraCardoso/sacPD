<?php
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
class IndexController
{
	/**
	* Ação que deverá ser executada quando 
	* nenhuma outra for especificada, do mesmo jeito que o
	* arquivo index.html ou index.php é executado quando nenhum é
	* referenciado
	*/
	public function indexAction()
	{
		//redirecionando para a pagina de lista de Roteiros
		//header('Location: ?controle=Roteiro&acao=listarRoteiro');
		header('Location: ?controle=Usuario&acao=loginUsuario');
	}
}
?>