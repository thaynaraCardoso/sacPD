<?php
require_once 'models/PraticaDidaticaModel.php';


/**
* @package Pratica Didática
* @author Thaynara Cardoso 
* @version 0.1.1
*  
* Camada - Modelo ou Model.
* Diretório Pai - models  
* Arquivo - RoteiroModel
*
* Responsável por gerenciar e persistir os dados dos  
* Roteiros 
**/
class RoteiroModel extends PersistModelAbstract
{
	private $in_idroteiro;
	private $st_tituloroteiro;
	private $st_objespecificoroteiro;
	private $st_conteudobasicoroteiro;
	private $st_palavrachaveroteiro;
	private $st_idvisibilidade;
	private $st_idusuario;

	
	function __construct()
	{
		parent::__construct();
		//executa método de criação da tabela Roteiro
		$this->createTableRoteiro();
	}
	
	
	/**
	 * Setters e Getters da
	 * classe RoteiroModel
	 */
	
	public function setIdRoteiro( $in_idroteiro )
	{
		$this->in_idroteiro = $in_idroteiro;
		return $this;
	}
	
	public function getIdRoteiro()
	{
		return $this->in_idroteiro;
	}
	
	public function setTituloRoteiro( $st_tituloroteiro )
	{
		$this->st_tituloroteiro = $st_tituloroteiro;
		return $this;
	}
	
	public function getTituloRoteiro()
	{
		return $this->st_tituloroteiro;
	}
	
	public function setObjEspecificoRoteiro( $st_objespecificoroteiro )
	{
		$this->st_objespecificoroteiro = $st_objespecificoroteiro;
		return $this;
	}
	
	public function getObjEspecificoRoteiro()
	{
		return $this->st_objespecificoroteiro;
	}
	
	public function setConteudoBasicoRoteiro( $st_conteudobasicoroteiro )
	{
		$this->st_conteudobasicoroteiro = $st_conteudobasicoroteiro;
		return $this;
	}
	
	public function getConteudoBasicoRoteiro()
	{
		return $this->st_conteudobasicoroteiro;
	}
	
	public function setPalavraChaveRoteiro( $st_palavrachaveroteiro )
	{
		$this->st_palavrachaveroteiro = $st_palavrachaveroteiro;
		return $this;
	}
	
	public function getPalavraChaveRoteiro()
	{
		return $this->st_palavrachaveroteiro;
	}	
	
	public function setIdVisibilidade( $st_idvisibilidade )
	{
		$this->st_idvisibilidade = $st_idvisibilidade;
		return $this;
	}
	
	public function getIdVisibilidade()
	{
		return $this->st_idvisibilidade;
	}
	
	public function setIdUsuario( $st_idusuario )
	{
		$this->st_idusuario = $st_idusuario;
		return $this;
	}
	
	public function getIdUsuario()
	{
		return $this->st_idusuario;
	}	
	
	
	/**
	* Retorna um array contendo os Roteiros
	* do usuário
	* @param string $st_idusuario
	* @return Array
	*/
	public function _list( $st_idusuario )
	{
		$st_query = "SELECT * FROM roteiro where idusuario ='$st_idusuario';";	
		
		$v_roteiros = array();
		try
		{
			$o_data = $this->o_db->query($st_query);
			while($o_ret = $o_data->fetchObject())
			{
				$o_roteiro = new RoteiroModel();
				$o_roteiro->setIdRoteiro($o_ret->idroteiro);
				$o_roteiro->setTituloRoteiro($o_ret->tituloroteiro);
				$o_roteiro->setObjEspecificoRoteiro($o_ret->objespecificoroteiro);
				$o_roteiro->setConteudoBasicoRoteiro($o_ret->conteudobasicoroteiro);
				$o_roteiro->setPalavraChaveRoteiro($o_ret->palavrachaveroteiro);
				$o_roteiro->setIdVisibilidade($o_ret->idvisibilidade);
				$o_roteiro->setIdUsuario($o_ret->idusuario);
				array_push($v_roteiros, $o_roteiro);
			}
		}
		catch(PDOException $e)
		{}				
		return $v_roteiros;
	}
	/**
	* Retorna um array contendo os Roteiros
	* Publicos
	* @param string $st_idusuario
	* @return Array
	*/
	public function _listP()
	{
		$st_query = "SELECT * FROM roteiro where idvisibilidade=0;";	
		
		$v_roteiros = array();
		try
		{
			$o_data = $this->o_db->query($st_query);
			while($o_ret = $o_data->fetchObject())
			{
				$o_roteiro = new RoteiroModel();
				$o_roteiro->setIdRoteiro($o_ret->idroteiro);
				$o_roteiro->setTituloRoteiro($o_ret->tituloroteiro);
				$o_roteiro->setObjEspecificoRoteiro($o_ret->objespecificoroteiro);
				$o_roteiro->setConteudoBasicoRoteiro($o_ret->conteudobasicoroteiro);
				$o_roteiro->setPalavraChaveRoteiro($o_ret->palavrachaveroteiro);
				$o_roteiro->setIdVisibilidade($o_ret->idvisibilidade);
				$o_roteiro->setIdUsuario($o_ret->idusuario);
				array_push($v_roteiros, $o_roteiro);
			}
		}
		catch(PDOException $e)
		{}				
		return $v_roteiros;
	}
	
	/**
	* Retorna os dados de um roteiro referente
	* a um determinado Idroteiro
	* @param integer $in_idroteiro
	* @return RoteiroModel
	*/
	public function loadById( $in_idroteiro )
	{

		$st_query = "SELECT * FROM roteiro WHERE idroteiro = $in_idroteiro;";
		$o_data = $this->o_db->query($st_query);
		$o_ret = $o_data->fetchObject();
		$this->setIdRoteiro($o_ret->idroteiro);
		$this->setTituloRoteiro($o_ret->tituloroteiro);
		$this->setObjEspecificoRoteiro($o_ret->objespecificoroteiro);
		$this->setConteudoBasicoRoteiro($o_ret->conteudobasicoroteiro);
		$this->setPalavrachaveRoteiro($o_ret->palavrachaveroteiro);
		$this->setIdVisibilidade($o_ret->idvisibilidade);
	
		return $this;
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
		if(is_null($this->in_idroteiro)){
			$st_query = "INSERT INTO roteiro
						(
							tituloroteiro,
							objespecificoroteiro,
							conteudobasicoroteiro,
							palavrachaveroteiro,
							idvisibilidade,
							idusuario
						)
						VALUES
						(
							'$this->st_tituloroteiro',
							'$this->st_objespecificoroteiro',
							'$this->st_conteudobasicoroteiro',
							'$this->st_palavrachaveroteiro',
							'$this->st_idvisibilidade',
							'$this->st_idusuario'
						);";
		echo $st_query;	
		}else
			$st_query = "UPDATE
							roteiro
						SET
							tituloroteiro = '$this->st_tituloroteiro',
							objespecificoroteiro = '$this->st_objespecificoroteiro',
							conteudobasicoroteiro = '$this->st_conteudobasicoroteiro',
							palavrachaveroteiro = '$this->st_palavrachaveroteiro',
							idvisibilidade = '$this->st_idvisibilidade'
							
						WHERE
							idroteiro = $this->in_idroteiro";
		try
		{
			
			if($this->o_db->exec($st_query) > 0)
				if(is_null($this->in_idroteiro))
				{
					
					/*
					* verificando se o driver usado é sqlite e pegando o ultimo id inserido
					* por algum motivo, a função nativa do PDO::lastInsertId() não funciona com sqlite
					*/
					if($this->o_db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite')
					{
						$o_ret = $this->o_db->query('SELECT last_insert_rowid() AS idroteiro')->fetchObject();
						return $o_ret->idroteiro;
					}
					else
						return $this->o_db->lastInsertId();
					
				}
				else
					return $this->in_idroteiro;
		}
		catch (PDOException $e)
		{
			throw $e;
		}
		return false;				
	}

	/**
	* Deleta os dados persistidos na tabela de
	* Roteiros usando como referencia, o id da classe.
	*/
	public function delete()
	{
		if(!is_null($this->in_idroteiro))
		{
			$st_query = "DELETE FROM
							roteiro
						WHERE idroteiro = $this->in_idroteiro";
			if($this->o_db->exec($st_query) > 0)
				return true;
		}
		return false;
	}
	
	/**
	* Cria tabela para armazernar os dados de Roteiros, caso
	* ela ainda não exista.
	* @throws PDOException
	*/
	private function createTableRoteiro()
	{
		/*
		* No caso do Sqlite, o AUTO_INCREMENT é automático na chave primaria da tabela
		* No caso do MySQL, o AUTO_INCREMENT deve ser especificado na criação do campo
		*/
		if($this->o_db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite')
			$st_auto_increment = '';
		else
			$st_auto_increment = 'AUTO_INCREMENT';
		
		$st_query = "CREATE TABLE `roteiro` (
  						`idRoteiro` int(11) NOT NULL AUTO_INCREMENT,
 						`idUsuario` int(11) DEFAULT NULL,
						`objEspecificoRoteiro` varchar(2500) DEFAULT NULL,
						`conteudoBasicoRoteiro` varchar(2500) DEFAULT NULL,
						`palavraChaveRoteiro` varchar(45) DEFAULT NULL,
						`idVisibilidade` int(11) NOT NULL,
						`tituloRoteiro` int(60) NOT NULL,
						PRIMARY KEY (`idRoteiro`),
						UNIQUE KEY `idRoteiro_UNIQUE` (`idRoteiro`),
						KEY `emailUsuario_idx` (`idUsuario`),
						KEY `fk_visibilidade` (`idVisibilidade`)
						) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

		//executando a query;
		try
		{
			//$this->o_db->exec($st_query);
		}
		catch(PDOException $e)
		{
			throw $e;
		}	
	}
}
?>