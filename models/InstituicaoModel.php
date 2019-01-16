<?php

/**
* @package Pratica Didática
* @author Thaynara Cardoso 
* @version 0.1.1
*  
* Camada - Modelo ou Model.
* Diretório Pai - models  
* Arquivo - InstituicaoModel
*
* Responsável por gerenciar e persistir os dados das
* Instituicoes 
**/
class InstituicaoModel extends PersistModelAbstract
{
	private $in_idinstituicao;
	private $st_nomeinstituicao;


	
	function __construct()
	{
		parent::__construct();
		//executa método de criação da tabela Instituicao
		$this->createTableInstituicao();
	}
	
	
	/**
	 * Setters e Getters da
	 * classe InstituicaoModel
	 */
	
	public function setIdInstituicao( $in_idinstituicao )
	{
		$this->in_idinstituicao = $in_idinstituicao;
		return $this;
	}
	
	public function getIdInstituicao()
	{
		return $this->in_idinstituicao;
	}
	
	public function setNomeInstituicao( $st_nomeinstituicao )
	{
		$this->st_nomeinstituicao = $st_nomeinstituicao;
		return $this;
	}
	
	public function getNomeInstituicao()
	{
		return $this->st_nomeinstituicao;
	}
	
	/**
	* Retorna um array contendo a Instituicao
	*  de um determinado idinstituicao
	* @param string $st_idinstituicao
	* @return Array
	*/
	public function _list()
	{
		$st_query = "SELECT * FROM instituicao order by nomeinstituicao;";	
		$v_instituicoes = array();
		try
		{
			$o_data = $this->o_db->query($st_query);
			while($o_ret = $o_data->fetchObject())
			{
				$o_instituicao = new InstituicaoModel();
				$o_instituicao->setIdInstituicao($o_ret->idinstituicao);
				$o_instituicao->setNomeInstituicao($o_ret->nomeinstituicao);
		
				array_push($v_instituicoes, $o_instituicao);
			}
		}
		catch(PDOException $e)
		{}				
		return $v_instituicoes;
	}
		
	/**
	* Retorna os dados de uma Instituicao referente
	* a um determinado Id
	* @param integer $in_idinstituicao
	* @return InstituicaoModel
	*/
	public function loadById( $in_idinstituicao )
	{
		
		$st_query = "SELECT * FROM instituicao WHERE idinstituicao = $in_idinstituicao;";
		$o_data = $this->o_db->query($st_query);
		$o_ret = $o_data->fetchObject();
		$this->setIdInstituicao($o_ret->idinstituicao);
		$this->setNomeInstituicao($o_ret->nomeinstituicao);		
		return $this;
	}
	
	/**
	* Salva dados contidos na instancia da classe
	* na tabela de Areas de Atuações. Se o idinstituicao for passado,
	* um UPDATE será executado, caso contrário, um
	* INSERT será executado
	* @throws PDOException
	* @return integer
	*/
	public function save()
	{
		if(is_null($this->in_idinstituicao)){
			$st_query = "INSERT INTO instituicao
						(
							nomeinstituicao
						)
						VALUES
						(
							'$this->st_nomeinstituicao'
						);";
		echo $st_query;	
		}else
			$st_query = "UPDATE
							instituicao
						SET
							nomeinstituicao = '$this->st_nomeinstituicao'
							
						WHERE
							idinstituicao = $this->in_idinstituicao";
		try
		{
			
			if($this->o_db->exec($st_query) > 0)
				if(is_null($this->in_idinstituicao))
				{
					
					/*
					* verificando se o driver usado é sqlite e pegando o ultimo id inserido
					* por algum motivo, a função nativa do PDO::lastInsertId() não funciona com sqlite
					*/
					if($this->o_db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite')
					{
						$o_ret = $this->o_db->query('SELECT last_insert_rowid() AS idinstituicao')->fetchObject();
						return $o_ret->idinstituicao;
					}
					else
						return $this->o_db->lastInsertId();
					
				}
				else
					return $this->in_idinstituicao;
		}
		catch (PDOException $e)
		{
			throw $e;
		}
		return false;				
	}

	/**
	* Deleta os dados persistidos na tabela de
	* Instituicao usando como referencia, o id da classe.
	*/
	public function delete()
	{
		if(!is_null($this->in_idinstituicao))
		{
			$st_query = "DELETE FROM
							instituicao
						WHERE idinstituicao = $this->in_idinstituicao";
			if($this->o_db->exec($st_query) > 0)
				return true;
		}
		return false;
	}
	
	/**
	* Cria tabela para armazernar os dados de Instituicao, caso
	* ela ainda não exista.
	* @throws PDOException
	*/
	private function createTableInstituicao()
	{
		/*
		* No caso do Sqlite, o AUTO_INCREMENT é automático na chave primaria da tabela
		* No caso do MySQL, o AUTO_INCREMENT deve ser especificado na criação do campo
		*/
		if($this->o_db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite')
			$st_auto_increment = '';
		else
			$st_auto_increment = 'AUTO_INCREMENT';
		
		$st_query = "CREATE TABLE `instituicao` (
  					`idinstituicao` int(11) NOT NULL AUTO_INCREMENT,
  					`nomeinstituicao` varchar(60) NOT NULL,
  					PRIMARY KEY (`idinstituicao`))
					ENGINE=MyISAM DEFAULT CHARSET=latin1;";

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