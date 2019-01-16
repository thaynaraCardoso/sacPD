<?php
/**
 * 
 * Responsável por gerenciar e persistir os dados de Prática diática dos
 * Roteiros
 * 
 * Camada - models ou modelo
 * Diretório Pai - models
 * Arquivo - PraticaDidaticaModel.php
 * 
 * @package Pratica Didática
 * @author Thaynara Cardoso
 * @version 0.1.1
 *
 */
class PraticaDidaticaModel extends PersistModelAbstract
{
	private $in_idpraticadidatica;
	private $in_roteiroid;
	private $in_conclusaopratica;
	private $in_avaliacaopratica;
	private $in_motivacaopratica;

	
	function __construct()
	{
		parent::__construct();
		
		//executa método de criação da tabela de PraticaDidatica
		//$this->createTablePraticaDidatica();
	}
	
	
	/**
	 * Setters e Getters da
	 * classe PraticaDidaticaModel
	 */
	
	public function setIdPraticaDidatica( $in_idpraticadidatica )
	{
		$this->in_idpraticadidatica = $in_idpraticadidatica;
		return $this;
	}
	
	public function getIdPraticaDidatica()
	{
		return $this->in_idpraticadidatica;
	}
	
	public function setRoteiroId( $in_roteiroid )
	{
		$this->in_roteiroid = $in_roteiroid;
		return $this;
	}
	
	public function getRoteiroId()
	{
		return $this->in_roteiroid;
	}
	
	public function setConclusaoPratica( $in_conclusaopratica )
	{
		$this->in_conclusaopratica = $in_conclusaopratica;
		return $this;
	}
	
	public function getConclusaoPratica()
	{
		return $this->in_conclusaopratica;
	}
	
	public function setAvaliacaopratica( $in_avaliacaopratica )
	{
		$this->in_avaliacaopratica = $in_avaliacaopratica;
		return $this;
	}
	
	public function getAvaliacaoPratica()
	{
		return $this->in_avaliacaopratica;
	}
	
	public function setMotivacaoPratica( $in_motivacao )
	{
	    $this->in_motivacaopratica = $in_motivacao;
	    return $this;
	}
	
	public function getMotivacaoPratica()
	{
	    return $this->in_motivacaopratica;
	}
	
	
	/**
	* Retorna um array contendo as Práticas Didáticas
	* de um determinado Roteiro
	* @param integer $in_idroteiro
	* @return Array
	*/
	public function _list( $in_idroteiro )
	{
		$st_query = "SELECT * FROM praticadidatica WHERE idroteiro = $in_idroteiro";
		$v_praticasdidaticas = array();
		try
		{
			$o_data = $this->o_db->query($st_query);
			while($o_ret = $o_data->fetchObject())
			{
				$o_praticadidatica = new PraticaDidaticaModel();
				$o_praticadidatica->setIdPraticaDidatica($o_ret->idpraticadidatica);
				$o_praticadidatica->setRoteiroId($o_ret->idroteiro);
				$o_praticadidatica->setConclusaoPratica($o_ret->conclusaopratica);
				$o_praticadidatica->setAvaliacaopratica($o_ret->avaliacaopratica);
				$o_praticadidatica->setMotivacaoPratica($o_ret->motivacaopratica);
				
				
				array_push($v_praticasdidaticas,$o_praticadidatica);
			}
		}
		catch(PDOException $e)
		{}				
		return $v_praticasdidaticas;
	}
	
	/**
	* Retorna os dados de uma Prática Didática referente
	* a um determinado idPratica
	* @param integer $in_idpraticadidatica
	* @return PraticaDidaticaModel
	*/
	public function loadById( $in_idpraticadidatica )
	{
		//$v_praticasdidaticas = array();
		$st_query = "SELECT * FROM praticadidatica WHERE idpraticadidatica = $in_idpraticadidatica;";
		try 
		{
			$o_data = $this->o_db->query($st_query);
			$o_ret = $o_data->fetchObject();
			$this->setIdPraticaDidatica($o_ret->idpraticadidatica);
			$this->setRoteiroId($o_ret->idroteiro);
			$this->setConclusaoPratica($o_ret->conclusaopratica);
			$this->setAvaliacaopratica($o_ret->avaliacaopratica);
			$this->setMotivacaoPratica($o_ret->motivacaopratica);

			return $this;
		}
		catch(PDOException $e)
		{}
		return false;	
	}
	
	/**
	* Salva dados contidos na instancia da classe
	* na tabela de praticadidatica. Se o ID for passado,
	* um UPDATE será executado, caso contrário, um
	* INSERT será executado
	* @throws PDOException
	* @return integer
	*/
	public function save()
	{
		
		if(is_null($this->in_idpraticadidatica)){
			$st_query = "INSERT INTO praticadidatica
						(
							idroteiro,
							conclusaopratica,
							avaliacaopratica,
                            motivacaopratica
						)
						VALUES
						(
							$this->in_roteiroid,
							'$this->in_conclusaopratica',
							'$this->in_avaliacaopratica',
                            '$this->in_motivacaopratica'
						);";
		//echo $st_query;
		}
		else{
			$st_query = "UPDATE
							praticadidatica
						SET
							conclusaopratica = '$this->in_conclusaopratica',
							avaliacaopratica = '$this->in_avaliacaopratica',
                            motivacaopratica = '$this->in_motivacaopratica'
						WHERE
							idpraticadidatica = $this->in_idpraticadidatica";
		//	echo $st_query;
		}
		try
		{
			
			if($this->o_db->exec($st_query) > 0)
				if(is_null($this->in_idpraticadidatica))
				{
					/*
					* verificando se o driver usado é sqlite e pegando o ultimo id inserido
					* por algum motivo, a função nativa do PDO::lastInsertId() não funciona com sqlite
					*/
					if($this->o_db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite')
					{
						$o_ret = $this->o_db->query('SELECT last_insert_rowid() AS praticadidaticainid')->fetchObject();
						return $o_ret->praticadidaticainid;
					}
					else
						return $this->o_db->lastInsertId();	
				}
				else
					return $this->in_idpraticadidatica;
		}
		catch (PDOException $e)
		{
			throw $e;
		}
		return false;				
	}

	/**
	* Deleta os dados persistidos na tabela de
	* telefone usando como referencia, o id da classe.
	*/
	public function delete()
	{
		if(!is_null($this->in_idpraticadidatica))
		{
			$st_query = "DELETE FROM
							atividade
						WHERE idpraticadidatica = $this->in_idpraticadidatica";
			if($this->o_db->exec($st_query) > 0)
			$st_query = "DELETE FROM
							praticadidatica
						WHERE idpraticadidatica = $this->in_idpraticadidatica";
			if($this->o_db->exec($st_query) > 0)
				return true;
		}
		return false;
	}
	
	
	
	/**
	* 
	* Cria tabela para armazernar os dados de telefone, caso
	* ela ainda não exista.
	* @throws PDOException
	*/
	private function createTableTelefone()
	{
		/*
		* No caso do Sqlite, o AUTO_INCREMENT é automático na chave primaria da tabela
		* No caso do MySQL, o AUTO_INCREMENT deve ser especificado na criação do campo
		*/
		if($this->o_db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite')
			$st_auto_increment = '';
		else
			$st_auto_increment = 'AUTO_INCREMENT';
		
		
		$st_query = "CREATE TABLE IF NOT EXISTS praticadidatica
					(
						atributos
					)";
		
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