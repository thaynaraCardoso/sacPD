<?php
/**
 * 
 * Responsável por gerenciar e persistir os dados das Atividades da
 * Pratica Didática
 * 
 * Camada - models ou modelo
 * Diretório Pai - models
 * Arquivo - AtividadeModel.php
 * @package Pratica Didática
 * @author Thaynara Cardoso
 * @version 0.1.1
 *
 */
class AtividadeModel extends PersistModelAbstract
{
	private $in_idatividade;
	private $in_praticadidaticaid;
	private $in_descricaoatividade;
	private $in_materialapoioatividade;
	private $in_tipomaterialapoio;
	private $in_nomematerialapoio;
	private $in_tipoatividade;

	
	function __construct()
	{
		parent::__construct();
		
		//executa método de criação da tabela de PraticaDidatica
		//$this->createTableAtividade();
	}
	
	
	/**
	 * Setters e Getters da
	 * classe AtividadeModel
	 */
	
	public function setIdAtividade( $in_idatividade )
	{
		$this->in_idatividade = $in_idatividade;
		return $this;
	}
	
	public function getIdAtividade()
	{
		return $this->in_idatividade;
	}
	
	public function setPraticaDidaticaId( $in_praticadidaticaid )
	{
		$this->in_praticadidaticaid = $in_praticadidaticaid;
		return $this;
	}
	
	public function getPraticaDidaticaId()
	{
		return $this->in_praticadidaticaid;
	}
	
	public function setDescricaoAtividade( $in_descricaoatividade )
	{
		$this->in_descricaoatividade = $in_descricaoatividade;
		return $this;
	}
	
	public function getDescricaoAtividade()
	{
		return $this->in_descricaoatividade;
	}
	
	public function setMaterialApoioAtividade( $in_materialapoioatividade )
	{
		$this->in_materialapoioatividade = $in_materialapoioatividade;
		return $this;
	}
	
	public function getMaterialApoioAtividade()
	{
		return $this->in_materialapoioatividade;
	}
	
	/*
	 * 
	 * /TipoMaterialApoio é o MIME do arquivo (Exemplo: application/msword,  
	 * image/gif, image/jpeg, video/mpeg, application/pdf)
	 * 
	 * Obs: É escolhido automaticamente de acordo com o arquivo carregado.
	 * 
	 */
	public function setTipoMaterialApoio( $in_tipomaterialapoio )
	{
		$this->in_tipomaterialapoio = $in_tipomaterialapoio;
		return $this;
	}
	
	public function getTipoMaterialApoio()
	{
		return $this->in_tipomaterialapoio;
	}
	/*
	 * 
	 * /NomeMaterialApoio é o nome original do arquivo carregado
	 * Obs: É escolhido automaticamente de acordo com o arquivo carregado.
	 * 
	 */	
	public function setNomeMaterialApoio( $in_nomematerialapoio )
	{
		$this->in_nomematerialapoio = $in_nomematerialapoio;
		return $this;
	}
	
	public function getNomeMaterialApoio()
	{
		return $this->in_nomematerialapoio;
	}
	
	public  function setTipoAtividade($in_tipoatividade) {
	    $this->in_tipoatividade = $in_tipoatividade;
	    return $this;
	}
	
	public function getTipoAtividade()
	{
	    return $this->in_tipoatividade;
	}
	
	/**
	* Retorna um array contendo as Atividades
	* de uma determinada Prática Didática
	* @param integer $in_idpraticadidatica
	* @return Array
	*/
	public function _list( $in_idpraticadidatica )
	{
		$st_query = "SELECT * FROM atividade WHERE idpraticadidatica = $in_idpraticadidatica";

		$v_atividades = array();
		try
		{
			$o_data = $this->o_db->query($st_query);
			while($o_ret = $o_data->fetchObject())
			{
				$o_atividade = new AtividadeModel();
				$o_atividade->setIdAtividade($o_ret->idatividade);
				$o_atividade->setPraticaDidaticaId($o_ret->idpraticadidatica);
				$o_atividade->setDescricaoAtividade($o_ret->descricaoatividade);
				$o_atividade->setMaterialApoioAtividade($o_ret->materialapoioatividade);
				$o_atividade->setTipoMaterialApoio($o_ret->tipomaterialapoio);
				$o_atividade->setNomeMaterialApoio($o_ret->nomematerialapoio);
				$o_atividade->setTipoAtividade($o_ret->tipoatividade);
				array_push($v_atividades,$o_atividade);
			}
		}
		catch(PDOException $e)
		{}				
		return $v_atividades;
	}
	
	/**
	* Retorna os dados de uma Atividade referente
	* a um determinado idAtividade
	* @param integer $in_idatividade
	* @return AtividadeModel
	*/
	public function loadById( $in_idatividade )
	{
		$v_atividades = array();
		$st_query = "SELECT * FROM atividade WHERE idatividade = $in_idatividade;";
		try 
		{
			$o_data = $this->o_db->query($st_query);
			$o_ret = $o_data->fetchObject();
			$this->setIdAtividade($o_ret->idatividade);
			$this->setPraticaDidaticaId($o_ret->idpraticadidatica);
			$this->setDescricaoAtividade($o_ret->descricaoatividade);
			$this->setMaterialApoioAtividade($o_ret->materialapoioatividade);
			$this->setMaterialApoioAtividade($o_ret->tipomaterialapoio);
			$this->setMaterialApoioAtividade($o_ret->nomematerialapoio);
			$this->setTipoAtividade($o_ret->tipoatividade);
			
			return $this;
		}
		catch(PDOException $e)
		{}
		return false;	
	}
	
	/**
	* Salva dados contidos na instancia da classe
	* na tabela de Atividades. Se o ID for passado,
	* um UPDATE será executado, caso contrário, um
	* INSERT será executado
	* @throws PDOException
	* @return integer
	*/
	public function save()
	{
		
		if(is_null($this->in_idatividade)){

			
			$st_query = "INSERT INTO atividade
						(
							idpraticadidatica,
							descricaoatividade,
							materialapoioatividade,
							tipomaterialapoio,
							nomematerialapoio,
                            tipoatividade							
						)
						VALUES
						(
							$this->in_praticadidaticaid,
							'$this->in_descricaoatividade',
							'$this->in_materialapoioatividade',
							'$this->in_tipomaterialapoio',
							'$this->in_nomematerialapoio',
                            '$this->in_tipoatividade'
						);";
		//echo $st_query;
		}
		else{
			$st_query = "UPDATE
							atividade
						SET
							descricaoatividade = '$this->in_descricaoatividade',
							materialapoioatividade = '$this->in_materialapoioatividade,'
							materialapoioatividade = '$this->in_tipomaterialapoio,'
							materialapoioatividade = '$this->in_nomematerialapoio,'
                            tipoatividade = '$this->in_tipoatividade'
						WHERE
							idatividade = $this->in_idatividade";
			//echo $st_query;
		}
		try
		{
			
			if($this->o_db->exec($st_query) > 0)
				if(is_null($this->in_idatividade))
				{
					/*
					* verificando se o driver usado é sqlite e pegando o ultimo id inserido
					* por algum motivo, a função nativa do PDO::lastInsertId() não funciona com sqlite
					*/
					if($this->o_db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite')
					{
						$o_ret = $this->o_db->query('SELECT last_insert_rowid() AS atividadeinid')->fetchObject();
						return $o_ret->atividadeinid;
					}
					else
						return $this->o_db->lastInsertId();	
				}
				else
					return $this->in_idatividade;
		}
		catch (PDOException $e)
		{
			throw $e;
		}
		return false;				
	}

	/**
	* Deleta os dados persistidos na tabela de
	* atividades usando como referencia, o id da classe.
	*/
	public function delete()
	{
		if(!is_null($this->in_idatividade))
		{
			$st_query = "DELETE FROM
							atividade
						WHERE idatividade = $this->in_idatividade";
			if($this->o_db->exec($st_query) > 0)
				return true;
		}
		return false;
	}
	
	
	
	/**
	* 
	* Cria tabela para armazernar os dados das atividades, caso
	* ela ainda não exista.
	* @throws PDOException
	*/
	private function createTableAtividade()
	{
		/*
		* No caso do Sqlite, o AUTO_INCREMENT é automático na chave primaria da tabela
		* No caso do MySQL, o AUTO_INCREMENT deve ser especificado na criação do campo
		*/
		if($this->o_db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite')
			$st_auto_increment = '';
		else
			$st_auto_increment = 'AUTO_INCREMENT';
		
		
		$st_query = "CREATE TABLE IF NOT EXISTS atividade
					(
						idatividade INTEGER NOT NULL $st_auto_increment,
						//colocar parametros
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