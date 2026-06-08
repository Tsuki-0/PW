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
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        include "conexao.php";
        // recuperando 
        $codigo = $_POST['codigo'];
        $produto = $_POST['produto'];
        $descricao = $_POST['descricao'];
        $data = $_POST['data'];
        $valor = $_POST['valor'];
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        $arquivo = basename($_FILES["foto"]["name"]);
        // criando a linha de INSERT
        $sql = "insert into tabelaimg (codigo,produto, descricao, data, valor, imagem) values ('$codigo','$produto', '$descricao', '$data', $valor, '$arquivo')";
        $resultado = $conexao->query($sql);
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            $mensagem = "The file " . htmlspecialchars(basename($_FILES["foto"]["name"])) . " has been uploaded.";
        } else {
            $mensagem = "Sorry, there was an error uploading your file.";
        }
        echo <<<ALERT
            <div class="alert alert-info container alert-dismissible fade show" role="alert">
                <h2>Cadastrado com sucesso!<br>
                    $mensagem
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <a href="index.php" class="btn btn-primary">Voltar</a>
            </div>\n
        ALERT;
    } catch (Exception $e) {
        echo <<<ALERT
            <div class="alert alert-danger container alert-dismissible fade show" role="alert">
                <h2>Aconteceu um erro:<br>
                    {$e->getMessage()}
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <a href="index.php" class="btn btn-primary">Voltar</a>
            </div>\n
        ALERT;
    }
}
?>

<body>
    <main class="container">
        <h3>Semana 01 - Exemplo 13 - Listagem Geral de Produtos - Imagem</h3>
        <form name="produto" action="incluir.php" method="post" enctype="multipart/form-data">
            <b>Código:</b> <input type="number" name="codigo" required="required"><br><br>
            <b>Produto:</b> <input type="text" name="produto" maxlength='80' style="width:550px"><br><br>
            <b>Descrição: </b><br><textarea name="descricao" rows='3' cols='100'
                style="resize: none;"></textarea><br><br>
            <b>Data: </b> <input type="date" name="data"><br><br>
            <b>Valor: R$ </b><input type="number" step="0.01" name="valor"> <br><br>
            <input type="file" name="foto" id="imagemnova" accept="image/*"><br><br>
            <p>Pré-visualização:</p>
            <img src="img/SemImagem.png" id="preview" class="img-fluid img-thumbnail shadow mb-2 foto" alt="sem imagem"><br>
            <input type="submit" class="btn btn-secondary" value="Ok">&nbsp;&nbsp;
            <input type="reset" class="btn btn-dark" value="Limpar">&nbsp;&nbsp;
            <a href="index.php" class="btn btn-primary">Cancelar</a>
        </form>
    </main>
    <script>
        document.getElementById('imagemnova').addEventListener('change', function (event) {
            const file = event.target.files[0]; // Pega o primeiro arquivo selecionado

            // Cria um objeto URL temporário para exibir a imagem
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.getElementById('preview');
                img.src = e.target.result;
            };
            reader.readAsDataURL(file); // Lê o arquivo como Base64
        });
    </script>
</body>

</html>