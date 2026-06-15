<?php
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	$host = "localhost";
	$user = "root";
	$pass = "";
	$banco = "PW";

	try {
		$conexao = new mysqli($host, $user, $pass, $banco);
		$conexao->set_charset("utf8");
		//mysqli_set_charset($conexao,"utf8");
	} catch (Exception $e) {
		throw new Exception("Problemas com a 
				conexão do Banco de Dados:<br> {$e->getMessage()}");
	}
	// $conexao = @mysqli_connect($host, $user, $pass, $banco ) 
	// or die ("Problemas com a conexão do Banco de Dados");
?>