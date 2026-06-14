<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Enfermeiro</title>
    <link rel="icon" type="image/icon" href="img/icon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        .foto { width: 200px; }
    </style>
</head>

<body>
    <main class="container">
        <h3>Detalhes do Enfermeiro</h3>
        <?php
        try {
            include "conexao.php";

            if (isset($_GET['id']) && is_numeric(base64_decode($_GET['id']))) {
                $id = base64_decode($_GET['id']);
            } else {
                header("Location: index.php");
                exit;
            }

            $sql   = "SELECT * FROM enfermeiros WHERE ID = $id";
            $query = $conexao->query($sql);

            if ($query->num_rows > 0) {
                $dados    = $query->fetch_assoc();
                $nome     = $dados['nome'];
                $endereco = $dados['endereço'];
                $coren    = $dados['COREN'];

                $dt       = new DateTime($dados['datanasc'], new DateTimeZone("America/Sao_Paulo"));
                $datanasc = $dt->format("d/m/Y");

                $foto = empty($dados['foto']) ? "SemImagem.png" : $dados['foto'];
            } else {
                throw new Exception("Enfermeiro não encontrado!");
            }

        } catch (Exception $e) {
            echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                    <h2>Aconteceu um erro:<br>{$e->getMessage()}</h2>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                  </div>
                  <a href=\"index.php\" class=\"btn btn-primary\">Voltar</a>";
        }
        ?>

        <?php if (!empty($nome)): ?>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <img src="img/<?= $foto ?>" class="img-thumbnail img-fluid" alt="<?= $nome ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($nome) ?></h5>
                        <p class="card-text"><b>Endereço:</b> <?= htmlspecialchars($endereco) ?></p>
                        <p class="card-text"><b>COREN:</b> <?= $coren ?></p>
                        <p class="card-text"><b>Data de Nascimento:</b> <?= $datanasc ?></p>
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