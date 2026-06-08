<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Exemplo PHP PW1</title>
	<link rel="icon" type="image/icon" href="img/icon.png">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/estilo.css">
	<style>
		.centraliza {
			text-align: center;
		}

		.foto {
			width: 150px;
		}
	</style>
</head>

<body>
	<main class="container">
		<h3>Semana 01 - Exemplo 13 - Listagem Geral de Produtos - Imagem33</h3>
		<header class="mb-2">
			<div class="row">
				<div class="col-sm-12 col-6">
					<a href="incluir.php" class="btn btn-primary">Incluir</a>
				</div>
			</div>
			<div class="row"> <!-- Form acrescentado para fazer o filtro/consulta -->
				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">

					<form action="#" method="post">
						<fieldset>
							<legend></legend>
							<label for="busca">Pesquisar:</label>
							<input type="search" size="30" maxlength="50" placeholder="Digite o nome ou parte dele"
								id="busca" name="filtro">
							<input type="submit" value="Pesquisar" class="btn btn-secondary">
						</fieldset>
					</form>
				</div>
			</div>
		</header>
		<?php
		try {
			// include_once "conexao.php";
			// require "conexao.php";
			// require_once "conexao.php";
			include "conexao.php";

			// ajustando a instrução select para ordenar por produto
			//$query = mysqli_query($conexao, "select * from tabelaimg order by produto");
			$sql = "";
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$filtro = $_POST["filtro"];
				$sql = "select * from tabelaimg where produto like '%$filtro%' order by produto";
			} else {
				$sql = "select * from tabelaimg order by produto";
			}

			$query = $conexao->query($sql);
			// if (!$query) {
			// 	die('Query Inválida: ' . @mysqli_error($conexao));
			// }
			echo <<<DOC
				<table class="table table-info table-hover">
							<tr>
								<th width="30px">Id</th>
								<th width="100px">Código</th>
								<th width="250px">Produto</th>
								<th width="100px">Valor</th>
								<th width="100px">Produto</th>
								<th width="200px">Ações</th>
							</tr>\n
				DOC;

			while ($dados = mysqli_fetch_array($query)) {
				echo "\t\t\t<tr>\n";
				echo "\t\t\t\t<td class=\"centraliza\">{$dados['id']}</td>\n";
				echo "\t\t\t\t<td>" . $dados['codigo'] . "</td>\n";
				echo "\t\t\t\t<td>" . $dados['produto'] . "</td>\n";
				echo "\t\t\t\t<td> R$ " . number_format($dados['valor'], 2, ",", ".") . "</td>\n";
				// buscando a na pasta imagem
				if (empty($dados['imagem'])) {
					$imagem = "SemImagem.png";
				} else {
					$imagem = $dados['imagem'];
				}
				//$id_del = $dados['id'];
				$id = base64_encode($dados['id']);
				echo "\t\t\t\t<td>
					<a href=\"verproduto.php?id=$id\">
						<img src=\"img/$imagem\" class=\"foto img-thumbnail shadow\">
					</a>
				</td>\n";
				echo "\t\t\t\t<td>
					<a href=\"verproduto.php?id=$id\" class=\"btn btn-primary\">
						Visualizar
					</a>&nbsp;&nbsp;
					<a href=\"editar.php?id=$id\" class=\"btn btn-primary\">
						Editar
					</a>&nbsp;&nbsp
					<!-- Acrescentado para apagar e chamar o modal -->
					<a href=\"#\" class=\"btn btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#excluirModal\" data-produto=\"$id\">
						Apagar
					</a>
				</td>\n";
				echo "\t\t\t</tr>\n";
			}
			echo "\t\t</table>\n";

			//mysqli_close($conexao);
			//$conexao = null;
		
		} catch (Exception $e) {
			echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">\n
					<h2>Aconteceu um erro:<br>\n
						{$e->getMessage()}\n
					</h2>\n
					<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>\n
				</div>\n";
		}
		?>
	</main>
	<?php include "modal.php";  //Acrescentado para incluir o modal ?>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/dialogo.js"></script> <!-- Acrescentado para personalizar o modal -->
</body>

</html>