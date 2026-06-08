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
<?php
try {
    include "conexao.php";

    // recuperando a informação da URL
    // verifica se parâmetro está correto e dento da normalidade 
    if (isset($_GET['id']) && is_numeric(base64_decode($_GET['id']))) {
        $id = base64_decode($_GET['id']);
    } else {
        //ob_start(); // Inicia o Output Buffer
        throw new Exception("Produto não existe!");
        //header("Location: index.php");
    }
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // criando a linha do  SELECT
        $sql = "select * from tabelaimg where id = $id";
        $resultado = $conexao->query($sql);
        $dados = $resultado->fetch_assoc();

        $codigo = $dados['codigo'];
        $produto = $dados['produto'];
        $descricao = $dados['descricao'];
        $dt = new DateTime($dados['data'], new DateTimeZone("America/Sao_Paulo"));
        $data = $dt->format("Y-m-d");
        $valor = $dados['valor'];
    } else {
        // recuperando 
        $codigo = $_POST['codigo'];
        $produto = $_POST['produto'];
        $descricao = $_POST['descricao'];
        $data = $_POST['data'];
        $valor = $_POST['valor'];
        // var_dump($id);
        // var_dump($codigo);
        // var_dump($produto);
        // var_dump($descricao);
        // var_dump($data);
        // var_dump($valor);

        // criando a linha de UPDATE
        $sql = "update tabelaimg set produto='". htmlspecialchars($produto) . 
        "', descricao='". htmlspecialchars($descricao) . "', data='$data', valor=$valor, codigo=$codigo where id=$id";
        // var_dump($sql);
        // exit();
        $resultado = $conexao->query($sql);

        echo <<<ALERT
            <div class="alert alert-info container alert-dismissible fade show" role="alert">
                <h2>Aconteceu um erro:<br>
                    Atualizado com sucesso!
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <a href="index.php" class="btn btn-primary">Voltar</a>
            </div>\n
        ALERT;
    }
} catch (Exception $e) {
    echo <<<ALERT
            <div class="alert alert-danger container alert-dismissible fade show" role="alert">
                <h2>Aconteceu um erro:<br>
                    {$e->getMessage()}
                </h2>\n
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <a href="index.php" class="btn btn-primary">Voltar</a>
            </div>\n
        ALERT;
}

?>

<body>
    <main class="container">
        <h3>Semana 01 - Exemplo 13 - Listagem Geral de Produtos - Imagem</h3>
        <?php $id = base64_encode($id); ?>
        <form name="produto" action="editar.php?id=<?= $id; ?>" method="post">
            <b>Código:</b> <input type="number" name="codigo" required="required" value="<?php echo $codigo; ?>"><br><br>
            <b>Produto:</b> <input type="text" name="produto" maxlength='80' style="width:550px" value="<?php echo $produto; ?>"><br><br>
            <b>Descrição: </b><br><textarea name="descricao" rows='3' cols='100'
                style="resize: none;"><?php echo $descricao; ?></textarea><br><br>
            <b>Data: </b> <input type="date" name="data" value="<?php echo $data; ?>"><br><br>
            <b>Valor: R$ </b><input type="number" step="0.01" name="valor" value="<?php echo $valor; ?>"> <br><br>
            <input type="submit" class="btn btn-secondary" value="Ok">&nbsp;&nbsp;
            <input type="reset" class="btn btn-dark" value="Limpar">&nbsp;&nbsp;
            <a href="index.php" class="btn btn-primary">Cancelar</a>
        </form>
    </main>
</body>

</html>