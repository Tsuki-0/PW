<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Enfermeiro</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>
    <main class="container">
        <?php
        try {
            include "conexao.php";

            if (isset($_GET['id']) && is_numeric(base64_decode($_GET['id']))) {
                $id = base64_decode($_GET['id']);
            } else {
                header("Location: index.php");
                exit;
            }

            // Busca a foto antes de excluir para poder apagar o arquivo
            $sqlFoto  = "SELECT foto FROM enfermeiros WHERE ID = $id";
            $resFoto  = $conexao->query($sqlFoto);
            $dadosFoto = $resFoto->fetch_assoc();

            // Exclui o registro
            $sql = "DELETE FROM enfermeiros WHERE ID = $id";
            $conexao->query($sql);

            // Apaga o arquivo de foto se não for a padrão
            if (!empty($dadosFoto['foto']) && $dadosFoto['foto'] !== 'SemImagem.png') {
                $caminhoFoto = "img/" . $dadosFoto['foto'];
                if (file_exists($caminhoFoto)) {
                    unlink($caminhoFoto);
                }
            }

            echo <<<ALERT
                <div class="alert alert-success container alert-dismissible fade show" role="alert">
                    <h2>Excluído com sucesso!</h2>
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
        ?>
    </main>
</body>
</html>