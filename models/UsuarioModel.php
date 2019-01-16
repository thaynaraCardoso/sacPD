<?php

/**
* @package Pratica Didática
* @author Thaynara Cardoso 
* @version 0.1.1
*  
* Camada - Modelo ou Model.
* Diretório Pai - models  
* Arquivo - UsuarioModel.php
*
* Responsável por gerenciar e persistir os dados dos  
* Roteiros 
**/
class UsuarioModel extends PersistModelAbstract
{
	private $in_idusuario;
	private $st_emailusuario;
	private $st_idareaatuacaousuario;
	private $st_idinstituicaousuario;
	private $st_senhausuario;
	private $st_nomeusuario;
	private $st_perfilusuario;
	
	function __construct()
	{
		parent::__construct();
		//executa método de criação da tabela Roteiro
		$this->createTableUsuario();
	}
	
	
	/**
	 * Setters e Getters da
	 * classe UsuarioModel
	 */
	
	public function setIdUsuario( $in_idusuario )
	{
		$this->in_idusuario = $in_idusuario;
		return $this;
	}
	
	public function getIdUsuario()
	{
		return $this->in_idusuario;
	}
	
	public function setEmailUsuario( $st_emailusuario )
	{
		$this->st_emailusuario = $st_emailusuario;
		return $this;
	}
	
	public function getEmailUsuario()
	{
		return $this->st_emailusuario;
	}
	
	public function setIdAreaAtuacaoUsuario( $st_idareaatuacaousuario )
	{
		$this->st_idareaatuacaousuario = $st_idareaatuacaousuario;
		return $this;
	}
	
	public function getIdAreaAtuacaoUsuario()
	{
		return $this->st_idareaatuacaousuario;
	}
	
	public function setIdInstituicaoUsuario( $st_idinstituicaousuario )
	{
		$this->st_idinstituicaousuario = $st_idinstituicaousuario;
		return $this;
	}
	
	public function getIdInstituicaoUsuario()
	{
		return $this->st_idinstituicaousuario;
	}
	
	public function setSenhaUsuario( $st_senhausuario )
	{
		$this->st_senhausuario = $st_senhausuario;
		return $this;
	}
	
	public function getSenhaUsuario()
	{
		return $this->st_senhausuario;
	}	
	
	
	public function setNomeUsuario( $st_nomeusuario )
	{
		$this->st_nomeusuario = $st_nomeusuario;
		return $this;
	}
	
	public function getNomeUsuario()
	{
		return $this->st_nomeusuario;
	}	
	
	public function setPerfilUsuario( $st_perfilusuario )
	{
		$this->st_perfilusuario = $st_perfilusuario;
		return $this;
	}
	
	public function getPerfilUsuario()
	{
		return $this->st_perfilusuario;
	}
	/**
	* Retorna um array contendo os Usuarios
	* @param string $st_tituloroteiro
	* @return Array
	*/
	public function _list( $st_nomeusuario = null )
	{
		if(!is_null($st_nomeusuario))
			$st_query = "SELECT * FROM usuario WHERE nomeusuario LIKE '%$st_nomeusuario%';";
		else
			$st_query = 'SELECT * FROM usuario;';	
		
		$v_usuarios = array();
		try
		{
			$o_data = $this->o_db->query($st_query);
			while($o_ret = $o_data->fetchObject())
			{
				$o_usuario = new UsuarioModel();
				$o_usuario->setIdUsuario($o_ret->idusuario);
				$o_usuario->setEmailUsuario($o_ret->emailusuario);
				$o_usuario->setIdAreaAtuacaoUsuario($o_ret->idareaatuacaousuario);
				$o_usuario->setIdInstituicaoUsuario($o_ret->idinstituicaousuario);
				$o_usuario->setSenhaUsuario($o_ret->senhausuario);
				$o_usuario->setNomeUsuario($o_ret->nomeusuario);
				$o_usuario->setPerfilUsuario($o_ret->perfilusuario);
				array_push($v_usuarios, $o_usuario);
			}
		}
		catch(PDOException $e)
		{}				
		return $v_usuarios;
	}
	
	/**
	* Retorna os dados de um usuario referente
	* a um determinado Idusuario
	* @param integer $in_idusuario
	* @return UsuarioModel
	*/
	public function loadById( $in_idusuario )
	{
		$v_usuarios = array();
		$st_query = "SELECT * FROM usuario WHERE idusuario = $in_idusuario;";
		$o_data = $this->o_db->query($st_query);
		$o_ret = $o_data->fetchObject();
		$this->setIdUsuario($o_ret->idusuario);
		$this->setEmailUsuario($o_ret->emailusuario);
		$this->setIdAreaAtuacaoUsuario($o_ret->idareaatuacaousuario);
		$this->setIdInstituicaoUsuario($o_ret->idinstituicaousuario);
		$this->setSenhaUsuario($o_ret->senhausuario);
		$this->setNomeUsuario($o_ret->nomeusuario);
		$this->setPerfilUsuario($o_ret->perfilusuario);	
		return $this;
	}
	
/**
	* Verificar se usuário e senha estão ok
	* @param integer $in_emailusuario, $senhausuario
	* @return UsuarioModel
	*/
	public function logar( $in_emailusuario, $in_senhausuario )
	{
		$v_usuarios = array();
		$st_query = "SELECT * FROM usuario WHERE emailusuario = '$in_emailusuario' and senhausuario ='".md5($in_senhausuario)."';";
		//echo $st_query;
		$o_data = $this->o_db->query($st_query);
		while($o_ret = $o_data->fetchObject()){
        	$_SESSION['nomeUsuario'] = $o_ret->nomeusuario;
            $_SESSION['idUsuario'] = $o_ret->idusuario;
            $_SESSION['emailUsuario'] = $o_ret->emailusuario;
            $_SESSION['perfilUsuario'] = $o_ret->perfilusuario;	
			$this->setIdUsuario($o_ret->idusuario);
			$this->setEmailUsuario($o_ret->emailusuario);
			$this->setIdAreaAtuacaoUsuario($o_ret->idareaatuacaousuario);
			$this->setIdInstituicaoUsuario($o_ret->idinstituicaousuario);
			$this->setSenhaUsuario($o_ret->senhausuario);
			$this->setNomeUsuario($o_ret->nomeusuario);
			$this->setPerfilUsuario($o_ret->perfilusuario);	
		return $this;
		}
	}
	
	/**
	* Salva dados contidos na instancia da classe
	* na tabela de Roteiros. Se o IDRoteiro for passado,
	* um UPDATE será executado, caso contrário, um
	* INSERT será executado
	* @throws PDOException
	* @return integer
	*/
	public function save()
	{
		
		
		if(is_null($this->in_idusuario)){
			$st_query = "INSERT INTO usuario
						(
							emailusuario,
							idareaatuacaousuario,
							idinstituicaousuario,
							senhausuario,
							nomeusuario,
							perfilusuario
						)
						VALUES
						(
							'$this->st_emailusuario',
							'$this->st_idareaatuacaousuario',
							'$this->st_idinstituicaousuario',
							'".md5($this->st_senhausuario)."',
							'$this->st_nomeusuario',
							'$this->st_perfilusuario'
						);";
		echo $st_query;	
		}else
		$alterasenha="S";
		$v_usuarios = array();
		$st_query = "SELECT * FROM usuario WHERE idusuario = $this->in_idusuario;";
		$o_data = $this->o_db->query($st_query);
		$o_ret = $o_data->fetchObject();
		if($o_ret->senhausuario == $this->st_senhausuario)
			$alterasenha="N";
		
			$st_query = "UPDATE
							usuario
						SET
							emailusuario 			= '$this->st_emailusuario',
							idareaatuacaousuario 	= '$this->st_idareaatuacaousuario',
							idinstituicaousuario 	= '$this->st_idinstituicaousuario',";
							if ($alterasenha=="S"){
								$st_query=$st_query."senhausuario 			='".md5($this->st_senhausuario)."',";
							}
							$st_query=$st_query."nomeusuario 			= '$this->st_nomeusuario',
							perfilusuario 			= '$this->st_perfilusuario'
							
						WHERE
							idusuario = $this->in_idusuario";
						//	echo $st_query;
		try
		{
			
			if($this->o_db->exec($st_query) > 0)
				if(is_null($this->in_idusuario))
				{
					
					/*
					* verificando se o driver usado é sqlite e pegando o ultimo id inserido
					* por algum motivo, a função nativa do PDO::lastInsertId() não funciona com sqlite
					*/
					if($this->o_db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite')
					{
						$o_ret = $this->o_db->query('SELECT last_insert_rowid() AS idusuario')->fetchObject();
						return $o_ret->idusuario;
					}
					else
						return $this->o_db->lastInsertId();
					
				}
				else
					return $this->in_idusuario;
		}
		catch (PDOException $e)
		{
			throw $e;
		}
		return false;				
	}

	/**
	* Deleta os dados persistidos na tabela de
	* usuarios usando como referencia, o id da classe.
	*/
	public function delete()
	{
		if(!is_null($this->in_idusuario))
		{
			$st_query = "DELETE FROM
							usuario
						WHERE idusuario = $this->in_idusuario";
			if($this->o_db->exec($st_query) > 0)
				return true;
		}
		return false;
	}
	
	/**
	* Cria tabela para armazernar os dados de contato, caso
	* ela ainda não exista.
	* @throws PDOException
	*/
	private function createTableUsuario()
	{
		/*
		* No caso do Sqlite, o AUTO_INCREMENT é automático na chave primaria da tabela
		* No caso do MySQL, o AUTO_INCREMENT deve ser especificado na criação do campo
		*/
		if($this->o_db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite')
			$st_auto_increment = '';
		else
			$st_auto_increment = 'AUTO_INCREMENT';
		
		$st_query = "CREATE TABLE IF NOT EXISTS `usuario` (
					  `emailusuario` varchar(300) DEFAULT NULL,
					  `idareaAtuacaousuario` int(11) DEFAULT NULL,
					  `idinstituicaousuario` int(11) DEFAULT NULL,
					  `senhausuario` varchar(45) DEFAULT NULL,
					  `nomeusuario` varchar(60) NOT NULL,
					  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
					  `perfilusuario` int(11),
					  PRIMARY KEY (`idUsuario`),
					  UNIQUE KEY `emailUsuario_UNIQUE` (`emailUsuario`),
					  KEY `idx_idUsuario` (`idUsuario`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

		//executando a query;
		try
		{
			$this->o_db->exec($st_query);
		}
		catch(PDOException $e)
		{
			throw $e;
		}	
	}
}
?>