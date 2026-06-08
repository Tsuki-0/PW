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
            width: 200px;
        }
    </style>
</head>

<body>
    <main class="container">
        <h3>Semana 01 - Exemplo 13 - Listagem Geral de Produtos - Imagem</h3>
        <?php
        try {
            include "conexao.php";

            function convertedata2ss($data)
            {
                $novadata = substr($data, 8, 2) . '/' . substr($data, 5, 2) . '/' . substr($data, 0, 4);
                return $novadata;
            }
            function convertedata($data)
            {
                $data_vetor = explode('-', $data);
                $novadata = implode('/', array_reverse($data_vetor));
                return $novadata;
            }
            // recuperando a informação da URL
            // verifica se parâmetro está correto e dento da normalidade 
            if (isset($_GET['id']) && is_numeric(base64_decode($_GET['id']))) {
                $id = base64_decode($_GET['id']);
            } else {
                //ob_start(); // Inicia o Output Buffer
                header("Location: index.php");
            }

            // ajustando a instrução select para ordenar por produto
            //$query = mysqli_query($conexao, "select * from tabelaimg order by produto");
            $sql = "select * from tabelaimg where id = $id";
            $query = $conexao->query($sql);

            if ($query->num_rows > 0) {
                $dados = $query->fetch_assoc();//  mysqli_fetch_array($query);
                $produto = $dados["produto"];
                $codigo = $dados["codigo"];
                $descricao = $dados["descricao"];
                $dt = new DateTime($dados["data"], new DateTimeZone("America/Sao_Paulo"));
                $data = $dt->format("d/m/Y");
                $valor = "R$ " . number_format($dados["valor"], 2, ",", ".");
                // buscando a na pasta imagem
                if (empty($dados['imagem'])) {
                    $imagem = "SemImagem.png";
                } else {
                    $imagem = $dados['imagem'];
                }
            } else {
                throw new Exception("Produto não encontrado!");
            }
        } catch (Exception $e) {
            echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">\n
					<h2>Aconteceu um erro:<br>\n
						{$e->getMessage()}\n
					</h2>\n
					<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>\n
				</div>\n
                <a href=\"index.php\" class=\"btn btn-primary\">Voltar</a>\n";
        }
        ?>
        <?php if (!empty($codigo)): ?>
            <div class="row">
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="card shadow">
                        <img src="img/<?php echo $imagem; ?>" class="img-thumbnail img-fluid" alt="<?php echo $produto; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $produto; ?></h5>
                            <p class="card-text"><?php echo "Código: $codigo"; ?></p>
                            <p class="card-text"><?php echo $descricao; ?></p>
                            <p class="card-text"><?php echo $data; ?></p>
                            <p class="card-text"><?php echo $valor; ?></p>
                            <a href="index.php" class="btn btn-primary">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>