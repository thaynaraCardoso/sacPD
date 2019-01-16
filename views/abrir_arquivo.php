<?php
 include("../lib/dadosconexao.php");

 try
	{
		$conecta = new PDO("mysql:host=$servidor;dbname=$banco", $usuario , $senha);
		$consultaSQL = "SELECT tipomaterialapoio, materialapoioatividade FROM atividade WHERE idatividade=$_GET[id]";
	//	echo $consultaSQL;
		$exComando = $conecta->prepare($consultaSQL); //testar o comando
		$exComando->execute(array());
        foreach($exComando as $resultado) 
		{
            $tipo = $resultado['tipomaterialapoio'];
            $conteudo = $resultado['materialapoioatividade'];
            header("Content-Type: $tipo");
            echo $conteudo;
		}	
    }catch(PDOException $erro)
	{
		echo("Errrooooo! foi esse: " . $erro->getMessage());
	}
?>