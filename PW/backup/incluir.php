<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incluir Enfermeiro</title>
    <link rel="icon" type="image/icon" href="img/icon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        .foto { width: 200px; }
    </style>
</head>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        include "conexao.php";

        $nome     = $_POST['nome'];
        $endereco = $_POST['endereco'];
        $coren    = $_POST['coren'];
        $datanasc = $_POST['datanasc'];

        $target_dir  = "img/";
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        $arquivo     = basename($_FILES["foto"]["name"]);

        $sql = "INSERT INTO enfermeiros (nome, endereço, COREN, datanasc, foto)
                VALUES ('$nome', '$endereco', '$coren', '$datanasc', '$arquivo')";

        $resultado = $conexao->query($sql);

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            $mensagem = "Foto enviada com sucesso.";
        } else {
            $mensagem = "Atenção: erro ao enviar a foto.";
        }

        echo <<<ALERT
            <div class="alert alert-info container alert-dismissible fade show" role="alert">
                <h2>Cadastrado com sucesso!<br>$mensagem</h2>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <a href="index.php" class="btn btn-primary">Voltar</a>
            </div>
        ALERT;

    } catch (Exception $e) {
        echo <<<ALERT
            <div class="alert alert-danger container alert-dismissible fade show" role="alert">
                <h2>Aconteceu um erro:<br>{$e->getMessage()}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <a href="index.php" class="btn btn-primary">Voltar</a>
            </div>
        ALERT;
    }
}
?>

<body>
    <main class="container">
        <h3>Incluir Enfermeiro</h3>
        <form name="enfermeiro" action="incluir.php" method="post" enctype="multipart/form-data">

            <b>Nome:</b>
            <input type="text" name="nome" maxlength="50" style="width:400px" required><br><br>

            <b>Endereço:</b>
            <input type="text" name="endereco" maxlength="50" style="width:400px" required><br><br>

            <b>COREN:</b>
            <input type="number" name="coren" required><br><br>

            <b>Data de Nascimento:</b>
            <input type="date" name="datanasc" required><br><br>

            <b>Foto:</b>
            <input type="file" name="foto" id="imagemnova" accept="image/*"><br><br>

            <p>Pré-visualização:</p>
            <img src="img/SemImagem.png" id="preview"
                class="img-fluid img-thumbnail shadow mb-2 foto" alt="sem imagem"><br><br>

            <input type="submit" class="btn btn-secondary" value="Ok">&nbsp;&nbsp;
            <input type="reset"  class="btn btn-dark"      value="Limpar">&nbsp;&nbsp;
            <a href="index.php"  class="btn btn-primary">Cancelar</a>
        </form>
    </main>

    <script>
        document.getElementById('imagemnova').addEventListener('change', function (event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    </script>
</body>
</html>