<?php

/**
* @package Pratica Didática
* @author Thaynara Cardoso 
* @version 0.1.1
*  
* Camada - Modelo ou Model.
* Diretório Pai - models  
* Arquivo - AreaAtuacaoModel
*
* Responsável por gerenciar e persistir os dados das
* Areas de Atuação 
**/
class AreaAtuacaoModel extends PersistModelAbstract
{
	private $in_idareaatuacao;
	private $st_descricaoareaatuacao;


	
	function __construct()
	{
		parent::__construct();
		//executa método de criação da tabela AreaAtuacao
		$this->createTableAreaAtuacao();
	}
	
	
	/**
	 * Setters e Getters da
	 * classe AreaAtuacaoModel
	 */
	
	public function setIdAreaAtuacao( $in_idareaatuacao )
	{
		$this->in_idareaatuacao = $in_idareaatuacao;
		return $this;
	}
	
	public function getIdAreaAtuacao()
	{
		return $this->in_idareaatuacao;
	}
	
	public function setDescricaoAreaAtuacao( $st_descricaoareaatuacao )
	{
		$this->st_descricaoareaatuacao = $st_descricaoareaatuacao;
		return $this;
	}
	
	public function getDescricaoAreaAtuacao()
	{
		return $this->st_descricaoareaatuacao;
	}
	
	/**
	* Retorna um array contendo a Area de Atuacao
	*  de um determinado idareaatuacao
	* @param string $st_idareaatuacao
	* @return Array
	*/
	public function _list()
	{
		$st_query = "SELECT * FROM areaatuacao order by descricaoareaatuacao;";	
		$v_areasatuacao = array();
		try
		{
			$o_data = $this->o_db->query($st_query);
			while($o_ret = $o_data->fetchObject())
			{
				$o_areaatuacao = new AreaAtuacaoModel();
				$o_areaatuacao->setIdAreaAtuacao($o_ret->idareaatuacao);
				$o_areaatuacao->setDescricaoAreaAtuacao($o_ret->descricaoareaatuacao);
		
				array_push($v_areasatuacao, $o_areaatuacao);
			}
		}
		catch(PDOException $e)
		{}				
		return $v_areasatuacao;
	}
		
	/**
	* Retorna os dados de uma Area de Atuacao referente
	* a um determinado Id
	* @param integer $in_idareaatuacao
	* @return AreaAtuacaoModel
	*/
	public function loadById( $in_idareaatuacao )
	{
		
		$st_query = "SELECT * FROM areaatuacao WHERE idareaatuacao = $in_idareaatuacao;";
		$o_data = $this->o_db->query($st_query);
		$o_ret = $o_data->fetchObject();
		$this->setIdAreaAtuacao($o_ret->idareaatuacao);
		$this->setDescricaoAreaAtuacao($o_ret->descricaoareaatuacao);		
		return $this;
	}
	
	/**
	* Salva dados contidos na instancia da classe
	* na tabela de Areas de Atuações. Se o idareaatuacao for passado,
	* um UPDATE será executado, caso contrário, um
	* INSERT será executado
	* @throws PDOException
	* @return integer
	*/
	public function save()
	{
		if(is_null($this->in_idareaatuacao)){
			$st_query = "INSERT INTO areaatuacao
						(
							descricaoareaatuacao
						)
						VALUES
						(
							'$this->st_descricaoareaatuacao'
						);";
		echo $st_query;	
		}else
			$st_query = "UPDATE
							areaatuacao
						SET
							descricaoareaatuacao = '$this->st_descricaoareaatuacao'
							
						WHERE
							idareaatuacao = $this->in_idareaatuacao";
		try
		{
			
			if($this->o_db->exec($st_query) > 0)
				if(is_null($this->in_idareaatuacao))
				{
					
					/*
					* verificando se o driver usado é sqlite e pegando o ultimo id inserido
					* por algum motivo, a função nativa do PDO::lastInsertId() não funciona com sqlite
					*/
					if($this->o_db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite')
					{
						$o_ret = $this->o_db->query('SELECT last_insert_rowid() AS idareaatuacao')->fetchObject();
						return $o_ret->idareaatuacao;
					}
					else
						return $this->o_db->lastInsertId();
					
				}
				else
					return $this->in_idareaatuacao;
		}
		catch (PDOException $e)
		{
			throw $e;
		}
		return false;				
	}

	/**
	* Deleta os dados persistidos na tabela de
	* AreaAtuacao usando como referencia, o id da classe.
	*/
	public function delete()
	{
		if(!is_null($this->in_idareaatuacao))
		{
			$st_query = "DELETE FROM
							areaatuacao
						WHERE idareaatuacao = $this->in_idareaatuacao";
			if($this->o_db->exec($st_query) > 0)
				return true;
		}
		return false;
	}
	
	/**
	* Cria tabela para armazernar os dados de Area de Atuacao, caso
	* ela ainda não exista.
	* @throws PDOException
	*/
	private function createTableAreaAtuacao()
	{
		/*
		* No caso do Sqlite, o AUTO_INCREMENT é automático na chave primaria da tabela
		* No caso do MySQL, o AUTO_INCREMENT deve ser especificado na criação do campo
		*/
		if($this->o_db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite')
			$st_auto_increment = '';
		else
			$st_auto_increment = 'AUTO_INCREMENT';
		
		$st_query = "CREATE TABLE `areaatuacao` (
  					`idAreaatuacao` int(11) NOT NULL AUTO_INCREMENT,
  					`descricaoareaatuacao` varchar(60) NOT NULL,
  					PRIMARY KEY (`idAreaatuacao`))
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