<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Enfermeiro — Gestão de Enfermagem</title>
    <link rel="icon" type="image/jpeg" href="img/logo.jpg">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        /* Estilo exclusivo desta pagina: area de upload de foto */
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

        .file-drop input[type="file"] { display: none; }

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

    if (isset($_GET['id']) && is_numeric(base64_decode($_GET['id']))) {
        $id = base64_decode($_GET['id']);
    } else {
        throw new Exception("Enfermeiro não encontrado!");
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $sql      = "SELECT * FROM enfermeiros WHERE ID = $id";
        $resultado = $conexao->query($sql);
        $dados    = $resultado->fetch_assoc();

        $nome     = $dados['nome'];
        $endereco = $dados['endereço'];
        $coren    = $dados['COREN'];
        $dt       = new DateTime($dados['datanasc'], new DateTimeZone("America/Sao_Paulo"));
        $datanasc = $dt->format("d/m/Y");
        $foto     = empty($dados['foto']) ? "SemImagem.png" : $dados['foto'];

    } else {

        $nome     = $_POST['nome'];
        $endereco = $_POST['endereco'];
        $coren    = $_POST['coren'];
        $datanasc = $_POST['datanasc'];

        $sqlFoto  = "SELECT foto FROM enfermeiros WHERE ID = $id";
        $resFoto  = $conexao->query($sqlFoto);
        $dadosFoto = $resFoto->fetch_assoc();
        $foto     = !empty($dadosFoto['foto']) ? $dadosFoto['foto'] : 'SemImagem.png';

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {

            $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

            if (!in_array($extensao, $extensoesPermitidas)) {
                throw new Exception("Extensão não permitida. Use JPG, PNG, WEBP ou GIF.");
            }

            $nomeArquivo = uniqid('enf_', true) . '.' . $extensao;
            $destino     = "img/" . $nomeArquivo;

            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                throw new Exception("Erro ao salvar a imagem!");
            }

            if ($foto !== 'SemImagem.png' && file_exists("img/" . $foto)) {
                unlink("img/" . $foto);
            }

            $foto = $nomeArquivo;

        } elseif (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
            throw new Exception("Erro ao receber a imagem. Tente novamente.");
        }

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

    <div class="page-header">
        <div>
            <h1>Editar Enfermeiro</h1>
            <p>Atualize os dados do cadastro</p>
        </div>
    </div>

    <?php if (isset($nome)): ?>
    <?php $idEnc = base64_encode($id); ?>
    <div class="form-wrap">
        <form action="editar.php?id=<?= $idEnc ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label class="form-label">Nome completo</label>
                <input type="text" name="nome" maxlength="50" class="form-control-custom"
                    value="<?= htmlspecialchars($nome) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Endereço</label>
                <input type="text" name="endereco" maxlength="50" class="form-control-custom"
                    value="<?= htmlspecialchars($endereco) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">COREN</label>
                <input type="number" name="coren" class="form-control-custom"
                    value="<?= $coren ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Data de Nascimento</label>
                <input type="text" name="datanasc" id="datanasc" class="form-control-custom"
                    placeholder="dd/mm/aaaa" inputmode="numeric" maxlength="10"
                    pattern="\d{2}/\d{2}/\d{4}"
                    value="<?= $datanasc ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Nova Foto <small style="color:var(--muted);font-weight:400;">(deixe vazio para manter a atual)</small></label>
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

            <div class="form-group">
                <label class="form-label">Foto atual</label>
                <img src="img/<?= $foto ?>" id="preview" class="foto-preview" alt="foto atual">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-teal">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Salvar alterações
                </button>
                <button type="reset" class="btn-outline">Desfazer</button>
                <a href="index.php" class="btn-outline">Cancelar</a>
            </div>

        </form>
    </div>
    <?php endif; ?>

</div>

<script>
    document.getElementById('imagemnova').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = ev => document.getElementById('preview').src = ev.target.result;
        reader.readAsDataURL(file);
    });

    /* Mascara o campo de data no formato dd/mm/aaaa enquanto o usuario digita */
    const campoData = document.getElementById('datanasc');

    campoData.addEventListener('input', function (e) {
        let v = e.target.value.replace(/\D/g, '').slice(0, 8);
        if (v.length >= 5) {
            v = v.slice(0, 2) + '/' + v.slice(2, 4) + '/' + v.slice(4);
        } else if (v.length >= 3) {
            v = v.slice(0, 2) + '/' + v.slice(2);
        }
        e.target.value = v;
    });

    /* Valida se a data digitada esta entre 01/01/1920 e 14/06/2026 */
    campoData.addEventListener('blur', function (e) {
        const valor = e.target.value;
        const match = valor.match(/^(\d{2})\/(\d{2})\/(\d{4})$/);

        if (!match) {
            e.target.setCustomValidity('Digite a data no formato dd/mm/aaaa.');
            e.target.reportValidity();
            return;
        }

        const [, dia, mes, ano] = match;
        const data = new Date(`${ano}-${mes}-${dia}`);
        const min  = new Date('1920-01-01');
        const max  = new Date('2026-06-14');

        if (data < min || data > max || data.getMonth() + 1 != parseInt(mes)) {
            e.target.setCustomValidity('Data deve estar entre 01/01/1920 e 14/06/2026.');
        } else {
            e.target.setCustomValidity('');
        }
        e.target.reportValidity();
    });

    /* Converte dd/mm/aaaa para aaaa-mm-dd antes de enviar o formulario */
    document.querySelector('form').addEventListener('submit', function () {
        const match = campoData.value.match(/^(\d{2})\/(\d{2})\/(\d{4})$/);
        if (match) {
            const [, dia, mes, ano] = match;
            campoData.value = `${ano}-${mes}-${dia}`;
        }
    });
</script>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
