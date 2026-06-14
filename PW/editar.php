<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Enfermagem</title>
    <link rel="icon" type="image/icon" href="img/icon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        /* ── exclusivo: área de upload de foto ── */
        .file-drop {
            border: 2px dashed var(--border);
            border-radius: 10px;
            padding: 1.25rem;
            text-align: center;
            cursor: pointer;
            transition: border-color .15s, background .15s;
            background: var(--surface);
        }

        .file-drop:hover { border-color: var(--teal); background: var(--teal-dim); }

        .file-drop input[type="file"] { display: none; /* input oculto, acionado pelo label */ }

        .file-drop label {
            cursor: pointer;
            font-size: .875rem;
            color: var(--muted);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .5rem;
        }

        .file-drop label span { color: var(--teal); font-weight: 600; }
    </style>
</head>

<?php
try {
    include "conexao.php";
    include "funcoes.php"; // Carrega a função redimensionarImagem()

    // Valida e decodifica o ID recebido pela URL
    if (isset($_GET['id']) && is_numeric(base64_decode($_GET['id']))) {
        $id = base64_decode($_GET['id']);
    } else {
        throw new Exception("Enfermeiro não encontrado!");
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        // GET: carrega os dados atuais do banco para preencher o formulário
        $sql       = "SELECT * FROM enfermeiros WHERE ID = $id";
        $resultado = $conexao->query($sql);
        $dados     = $resultado->fetch_assoc();

        $nome     = $dados['nome'];
        $endereco = $dados['endereço'];
        $coren    = $dados['COREN'];
        // Formata a data para o formato aceito pelo input type="date"
        $dt       = new DateTime($dados['datanasc'], new DateTimeZone("America/Sao_Paulo"));
        $datanasc = $dt->format("Y-m-d");
        $foto     = empty($dados['foto']) ? "SemImagem.png" : $dados['foto'];

    } else {

        // POST: recupera os dados do formulário enviado
        $nome     = $_POST['nome'];
        $endereco = $_POST['endereco'];
        $coren    = $_POST['coren'];
        $datanasc = $_POST['datanasc'];

        // Busca a foto atual no banco como fallback caso nenhuma nova seja enviada
        $sqlFoto   = "SELECT foto FROM enfermeiros WHERE ID = $id";
        $resFoto   = $conexao->query($sqlFoto);
        $dadosFoto = $resFoto->fetch_assoc();
        $foto      = !empty($dadosFoto['foto']) ? $dadosFoto['foto'] : 'SemImagem.png';

        // Verifica se um novo arquivo foi enviado
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {

            $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

            if (!in_array($extensao, $extensoesPermitidas)) {
                throw new Exception("Extensão não permitida. Use JPG, PNG, WEBP ou GIF.");
            }

            // Gera nome único para o novo arquivo
            $nomeArquivo = uniqid('enf_', true) . '.' . $extensao;
            $destino     = "img/" . $nomeArquivo;

            // Redimensiona e salva a nova imagem (máx 300px de largura)
            redimensionarImagem($_FILES['foto']['tmp_name'], $destino, 300);

            // Remove a foto antiga do servidor se não for a imagem padrão
            if ($foto !== 'SemImagem.png' && file_exists("img/" . $foto)) {
                unlink("img/" . $foto);
            }

            $foto = $nomeArquivo;

        } elseif (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
            // Houve tentativa de upload mas ocorreu erro técnico
            throw new Exception("Erro ao receber a imagem. Tente novamente.");
        }
        // Se UPLOAD_ERR_NO_FILE: nenhum arquivo enviado, mantém a foto atual do banco

        // Atualiza o registro no banco de dados
        $sql = "UPDATE enfermeiros SET
                    nome     = '" . htmlspecialchars($nome)     . "',
                    endereço = '" . htmlspecialchars($endereco) . "',
                    COREN    = $coren,
                    datanasc = '$datanasc',
                    foto     = '$foto'
                WHERE ID = $id";

        $conexao->query($sql);

        echo '
        <div class="alert-custom alert-success-custom" style="max-width:680px;margin:2rem auto 0;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <div>
                <strong>Atualizado com sucesso!</strong><br>
                <a href="index.php" class="btn-teal" style="margin-top:.6rem;">Voltar à listagem</a>
            </div>
        </div>';
    }

} catch (Exception $e) {
    echo '
    <div class="alert-custom alert-danger-custom" style="max-width:680px;margin:2rem auto 0;">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <div>
            <strong>Erro:</strong> ' . htmlspecialchars($e->getMessage()) . '<br>
            <a href="index.php" class="btn-outline" style="margin-top:.6rem;">Voltar</a>
        </div>
    </div>';
}
?>

<body>

<nav class="topbar">
    <a href="index.php" class="topbar-brand">
        <span class="icon-wrap">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path d="M12 2a5 5 0 1 1 0 10A5 5 0 0 1 12 2z"/>
                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
            </svg>
        </span>
        Gestão de Enfermagem
    </a>
    <span class="topbar-sub">Sistema de Gestão</span>
</nav>

<div class="page-wrap">

    <!-- CABEÇALHO DA PÁGINA -->
    <div class="page-header" style="text-align: center;">
        <div>
            <h1>Editar Enfermeiro</h1>
            <h3 style="margin-top: 1%;">Atualize os dados do cadastro</h3>
        </div>
    </div>

    <!-- Exibe o formulário apenas se os dados foram carregados com sucesso -->
    <?php if (isset($nome)): ?>
    <?php $idEnc = base64_encode($id); // Recodifica o ID para usar na action do form ?>
    <div class="form-wrap">
        <form action="editar.php?id=<?= $idEnc ?>" method="post" enctype="multipart/form-data">

            <div class="form-group  col-md-5" style="margin:0 auto; text-align: center;">
                <label class="form-label">Nome completo</label>
                <input type="text" name="nome" maxlength="50" class="form-control"
                    value="<?= htmlspecialchars($nome) ?>" required>
            </div>

            <div class="form-group  col-md-5" style="margin:0 auto; text-align: center;">
                <label class="form-label">Endereço</label>
                <input type="text" name="endereco" maxlength="50" class="form-control"
                    value="<?= htmlspecialchars($endereco) ?>" required>
            </div>

            <div class="form-group col-md-2" style="margin:0 auto; text-align: center;">
                <label class="form-label">COREN</label>
                <input type="number" name="coren" class="form-control"
                    value="<?= $coren ?>" required>
            </div>

            <div class="form-group col-md-3" style="margin:0 auto; text-align: center;">
                <label class="form-label">Data de Nascimento</label>
                <input type="date" name="datanasc" class="form-control"
                    value="<?= $datanasc ?>">
            </div>

            <div class="form-group" style="margin:0 auto; text-align: center;">
                <label class="form-label">Nova Foto <small style="color:var(--muted);font-weight:400;">(deixe vazio para manter a atual)</small></label>
                <!-- Área de upload estilizada — o input real fica oculto -->
                <div class="file-drop">
                    <label for="imagemnova">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <span>Clique para selecionar</span>
                        JPG, PNG, WEBP ou GIF
                    </label>
                    <input type="file" name="foto" id="imagemnova" accept="image/*">
                </div>
            </div>

            <div class="form-group" style="margin:0 auto; text-align: center;">
                <label class="form-label">Foto atual</label>
                <!-- Pré-visualização atualizada via JS ao selecionar nova foto -->
                <img src="img/<?= $foto ?>" id="preview" class="foto-preview" alt="foto atual" style="width: 25%; height: 25%;">
            </div>

            <div class="form-actions" style="display: flex; gap: 1rem; justify-content: center;">
                <button type="submit" class="btn btn-outline-success">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Salvar alterações
                </button>
                <button type="reset" class="btn btn-outline-danger">Desfazer</button>
                <a href="index.php" class="btn btn-outline-dark">Cancelar</a>
            </div>

        </form>
    </div>
    <?php endif; ?>

</div>

<script>
    // Atualiza a pré-visualização ao selecionar uma nova imagem
    document.getElementById('imagemnova').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = ev => document.getElementById('preview').src = ev.target.result;
        reader.readAsDataURL(file);
    });
</script>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
