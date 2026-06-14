<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Enfermeiro — Gestão de Enfermagem</title>
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

        .file-drop:hover {
            border-color: var(--teal);
            background: var(--teal-dim);
        }

        .file-drop input[type="file"] {
            display: none; /* input oculto, acionado pelo label */
        }

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
// Processa o formulário somente quando enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        include "conexao.php";
        include "funcoes.php"; // Carrega a função redimensionarImagem()

        // Recupera os dados do formulário
        $nome     = $_POST['nome'];
        $endereco = $_POST['endereco'];
        $coren    = $_POST['coren'];
        $datanasc = $_POST['datanasc'];

        // Verifica se o upload foi recebido sem erros
        if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Erro ao receber a imagem. Tente novamente.");
        }

        // Valida a extensão do arquivo
        $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extensao = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));

        if (!in_array($extensao, $extensoesPermitidas)) {
            throw new Exception("Extensão não permitida. Use JPG, PNG, WEBP ou GIF.");
        }

        // Gera um nome único para evitar conflitos de arquivo
        $arquivo = uniqid('enf_', true) . '.' . $extensao;
        $destino = "img/" . $arquivo;

        // Redimensiona e salva a imagem (máx 300px de largura)
        redimensionarImagem($_FILES["foto"]["tmp_name"], $destino, 300);

        // Insere o registro no banco de dados
        $sql = "INSERT INTO enfermeiros (nome, endereço, COREN, datanasc, foto)
                VALUES ('$nome', '$endereco', '$coren', '$datanasc', '$arquivo')";
        $conexao->query($sql);

        echo '
        <div class="alert-custom alert-success-custom" style="max-width:680px;margin:2rem auto 0;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <div>
                <strong>Cadastrado com sucesso!</strong><br>
                <a href="index.php" class="btn-teal" style="margin-top:.6rem;">Voltar à listagem</a>
            </div>
        </div>';

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
}
?>

<body>

<!-- TOPBAR -->
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
        <div style="text-align: center;">
            <h1>Novo Enfermeiro</h1>
            <p>Preencha os dados para cadastrar um novo membro na equipe</p>
        </div>
    </div>

    <!-- FORMULÁRIO DE CADASTRO -->
    <div class="form-wrap col-mb-6" style="text-align: center;">
        <form action="incluir.php" method="post" enctype="multipart/form-data">

            <div class="form-group col-sm-7 col-md-3" style="margin:0 auto; text-align: center;">
                <label class="form-label">Nome completo</label>
                <input class="form-control" type="text" name="nome" placeholder="Ex: Ana Maria Santos" required>
            </div>

            <div class="form-group col-sm-7 col-md-3" style="margin:0 auto; text-align: center;">
                <label class="form-label">Endereço</label>
               
                 <input class="form-control col-sm-7" type="text" name="endereco"
                    placeholder="Ex: Rua das Flores, 123 - Bairro Jardim" required>
            </div>

            <div class="form-group col-sm-7 col-md-2" style="margin:0 auto; text-align: center;">
                <label class="form-label">COREN</label>
                <input type="number" name="coren" class="form-control"
                    placeholder="Ex: 123456" required>
            </div>

            <div class="form-group col-sm-7 col-md-2" style="margin:0 auto; text-align: center;">
                <label class="form-label">Data de Nascimento</label>
                <input type="date" name="datanasc" class="form-control" required>
            </div>

            <div class="form-group col-sm-7 col-md-5" style="margin:0 auto; text-align: center;">
                <label class="form-label">Foto</label>
                <!-- Área de upload estilizada — o input real fica oculto -->
                <div class="file-drop">
                    <label for="imagemnova">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <span>Clique para selecionar</span>
                        JPG, PNG, WEBP ou JPEG · máx. recomendado 5MB
                    </label>
                    <input type="file" name="foto" id="imagemnova" accept="image/*" required>
                </div>
            </div>

            <div class="form-group" style="text-align: center;">
                <label class="form-label">Pré-visualização</label>
                <img src="img/SemImagem.png" id="preview" class="foto-preview" alt="pré-visualização">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-outline-primary">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Salvar
                </button>
                <button type="reset" class="btn btn-outline-secondary">Limpar</button>
                <a href="index.php" class="btn btn-outline-danger">Cancelar</a>
            </div>

        </form>
    </div>
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
