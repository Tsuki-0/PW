<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Enfermeiro | NurseCare</title>
    <link rel="icon" type="image/icon" href="img/icon.png">
    <!-- Bootstrap 5 + Icons + Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts para estilo refinado -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .glass-container {
            max-width: 760px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(2px);
            border-radius: 2rem;
            box-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.35), 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 2rem 2rem 2.5rem;
            transition: all .1s ease;
            border: 1px solid rgba(255,255,255,0.5);
        }

        @media (max-width: 576px) {
            .glass-container {
                padding: 1.5rem;
            }
            .preview-img {
                width: 120px !important;
                height: 120px !important;
            }
            input, .btn, .form-label {
                font-size: 0.9rem;
            }
        }

        h3 {
            font-weight: 700;
            color: #1e2f5e;
            margin-bottom: 1.8rem;
            position: relative;
            display: inline-block;
            letter-spacing: -0.2px;
            font-size: 1.85rem;
        }

        h3:after {
            content: '';
            display: block;
            width: 60%;
            height: 3px;
            background: linear-gradient(90deg, #2c7da0, #61a5c2);
            border-radius: 3px;
            margin-top: 8px;
        }

        .form-label-custom {
            font-weight: 600;
            color: #2c3e66;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
        }

        .form-label-custom i {
            color: #2c7da0;
            width: 22px;
            font-size: 1rem;
        }

        input:not([type="submit"]):not([type="reset"]), .custom-input {
            border-radius: 1rem;
            border: 1px solid #d9e2ef;
            padding: 0.7rem 1rem;
            transition: all 0.2s;
            background-color: #fefefe;
            font-weight: 500;
            width: 100%;
            font-size: 0.95rem;
        }

        input:focus {
            border-color: #2c7da0;
            box-shadow: 0 0 0 3px rgba(44, 125, 160, 0.2);
            outline: none;
            background-color: #ffffff;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            opacity: 0.5;
        }

        .file-upload-wrapper {
            position: relative;
            margin-top: 6px;
        }
        .file-upload-wrapper input[type="file"] {
            padding: 0.5rem;
            background: #f8fafc;
            border-radius: 2rem;
            font-size: 0.85rem;
            cursor: pointer;
        }
        .file-upload-wrapper input[type="file"]::file-selector-button {
            background: #e9ecef;
            border: none;
            border-radius: 2rem;
            padding: 0.4rem 1rem;
            font-weight: 500;
            color: #1e4663;
            margin-right: 1rem;
            transition: 0.2s;
        }
        .file-upload-wrapper input[type="file"]::file-selector-button:hover {
            background: #dee2e6;
        }

        .preview-section {
            background: #f1f5f9;
            border-radius: 1.5rem;
            padding: 1rem;
            text-align: center;
            margin: 1rem 0 1rem;
            border: 1px dashed #b9d0e8;
        }

        .preview-img {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            background: #fef9e6;
            transition: transform 0.2s;
        }
        .preview-img:hover {
            transform: scale(1.02);
        }

        .btn-custom-ok {
            background: linear-gradient(95deg, #1f6392, #2c7da0);
            border: none;
            border-radius: 3rem;
            padding: 0.6rem 2.2rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: 0.2s;
            color: white;
            box-shadow: 0 5px 12px rgba(44,125,160,0.3);
        }
        .btn-custom-ok:hover {
            background: linear-gradient(95deg, #0f517a, #236b8e);
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(44,125,160,0.4);
        }

        .btn-custom-reset {
            background: #eef2f7;
            border: 1px solid #cbdde9;
            border-radius: 3rem;
            padding: 0.6rem 1.8rem;
            font-weight: 500;
            color: #2c3e66;
        }
        .btn-custom-reset:hover {
            background: #e2e8f0;
            border-color: #b1c5d6;
        }

        .btn-custom-cancel {
            background: transparent;
            border: 1px solid #adb7c4;
            border-radius: 3rem;
            padding: 0.6rem 1.8rem;
            font-weight: 500;
            color: #495e7e;
        }
        .btn-custom-cancel:hover {
            background: #f1f3f7;
            border-color: #8fa0b3;
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            justify-content: center;
            margin-top: 1.8rem;
        }

        .alert-custom {
            border-radius: 1.2rem;
            border-left: 6px solid;
            font-weight: 500;
            backdrop-filter: blur(2px);
            margin: 0 auto 1.5rem auto;
            max-width: 760px;
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px);}
            to { opacity: 1; transform: translateY(0);}
        }

        .info-text {
            font-size: 0.8rem;
            color: #4b6b8f;
            margin-top: 5px;
        }

        hr {
            background: linear-gradient(90deg, transparent, #c5d5e8, transparent);
            height: 1px;
            border: 0;
            margin: 0.8rem 0 1.2rem;
        }

        footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.75rem;
            color: #5d718b;
        }
    </style>
</head>

<?php
// Variáveis para controlar exibição
$mostrarFormulario = false;
$erroMsg = null;
$sucessoMsg = null;

try {
    include "conexao.php";

    // Verifica se é POST (atualização)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Pega o ID da URL
        if (isset($_GET['id']) && is_numeric(base64_decode($_GET['id']))) {
            $id = base64_decode($_GET['id']);
        } else {
            throw new Exception("ID inválido para atualização!");
        }

        $nome = $_POST['nome'];
        $endereco = $_POST['endereco'];
        $coren = $_POST['coren'];
        $datanasc = $_POST['datanasc'];

        // Busca foto atual como fallback
        $sqlFoto = "SELECT foto FROM enfermeiros WHERE ID = $id";
        $resFoto = $conexao->query($sqlFoto);
        $dadosFoto = $resFoto->fetch_assoc();
        $foto = (!empty($dadosFoto['foto'])) ? $dadosFoto['foto'] : 'SemImagem.png';

        // Verifica se um novo arquivo foi enviado
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $nomeOriginal = $_FILES['foto']['name'];
            $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

            if (!in_array($extensao, $extensoesPermitidas)) {
                throw new Exception("Extensão de imagem não permitida! Use JPG, PNG, GIF ou WEBP.");
            }

            $nomeArquivo = uniqid('enf_', true) . '.' . $extensao;
            $destino = "img/" . $nomeArquivo;

            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                throw new Exception("Erro ao salvar a imagem!");
            }

            // Apaga foto antiga se não for a padrão
            if ($foto !== 'SemImagem.png' && file_exists("img/" . $foto)) {
                unlink("img/" . $foto);
            }
            $foto = $nomeArquivo;
        } elseif (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
            throw new Exception("Erro no envio da imagem.");
        }

        $sql = "UPDATE enfermeiros SET
                    nome = '" . htmlspecialchars($nome) . "',
                    endereço = '" . htmlspecialchars($endereco) . "',
                    COREN = $coren,
                    datanasc = '$datanasc',
                    foto = '$foto'
                WHERE ID = $id";

        $conexao->query($sql);
        $sucessoMsg = "Enfermeiro atualizado com sucesso!";
        
        // Após salvar, recarrega os dados para mostrar no formulário
        $sql = "SELECT * FROM enfermeiros WHERE ID = $id";
        $resultado = $conexao->query($sql);
        $dados = $resultado->fetch_assoc();
        
        $nome = $dados['nome'];
        $endereco = $dados['endereço'];
        $coren = $dados['COREN'];
        $dt = new DateTime($dados['datanasc'], new DateTimeZone("America/Sao_Paulo"));
        $datanasc = $dt->format("Y-m-d");
        $foto = empty($dados['foto']) ? "SemImagem.png" : $dados['foto'];
        $mostrarFormulario = true;
    }
    
    // Se é GET (carregar página) ou POST falhou mas precisa mostrar form
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET['id']) && is_numeric(base64_decode($_GET['id']))) {
            $id = base64_decode($_GET['id']);
            $sql = "SELECT * FROM enfermeiros WHERE ID = $id";
            $resultado = $conexao->query($sql);
            
            if ($resultado && $resultado->num_rows > 0) {
                $dados = $resultado->fetch_assoc();
                $nome = $dados['nome'];
                $endereco = $dados['endereço'];
                $coren = $dados['COREN'];
                $dt = new DateTime($dados['datanasc'], new DateTimeZone("America/Sao_Paulo"));
                $datanasc = $dt->format("Y-m-d");
                $foto = empty($dados['foto']) ? "SemImagem.png" : $dados['foto'];
                $mostrarFormulario = true;
            } else {
                throw new Exception("Enfermeiro não encontrado!");
            }
        } else {
            throw new Exception("ID do enfermeiro inválido!");
        }
    }
    
} catch (Exception $e) {
    $erroMsg = $e->getMessage();
    $mostrarFormulario = false;
}

// Exibe alerta de sucesso ou erro
if ($sucessoMsg) {
    echo <<<ALERT
    <div class="alert alert-success alert-custom container d-flex align-items-center justify-content-between flex-wrap" role="alert">
        <div class="d-flex align-items-center gap-3">
            <i class="fas fa-check-circle fa-2x text-success"></i>
            <div>
                <h5 class="mb-0 fw-bold">Sucesso!</h5>
                <p class="mb-0 small">{$sucessoMsg}</p>
            </div>
        </div>
        <a href="index.php" class="btn btn-sm btn-outline-success rounded-pill px-4 mt-2 mt-sm-0"><i class="fas fa-arrow-left me-1"></i>Voltar</a>
    </div>
    ALERT;
}

if ($erroMsg) {
    echo <<<ALERT
    <div class="alert alert-danger alert-custom container d-flex align-items-center justify-content-between flex-wrap" role="alert">
        <div class="d-flex align-items-center gap-3">
            <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
            <div>
                <h5 class="mb-0 fw-bold">Erro!</h5>
                <p class="mb-0 small">{$erroMsg}</p>
            </div>
        </div>
        <a href="index.php" class="btn btn-sm btn-outline-danger rounded-pill px-4 mt-2 mt-sm-0"><i class="fas fa-home me-1"></i>Home</a>
    </div>
    ALERT;
}
?>

<body>
    <div class="glass-container">
        <div class="d-flex align-items-center gap-2 mb-1">
            <i class="fas fa-user-edit fa-2x" style="color: #2c7da0;"></i>
            <h3>Editar Enfermeiro</h3>
        </div>
        <hr>
        
        <?php if ($mostrarFormulario): ?>
        <form name="enfermeiro" action="editar.php?id=<?= base64_encode($id) ?>" method="post" enctype="multipart/form-data">
            
            <div class="mb-3">
                <div class="form-label-custom">
                    <i class="fas fa-signature"></i> Nome completo
                </div>
                <input type="text" name="nome" maxlength="50" style="width:100%"
                    value="<?= htmlspecialchars($nome) ?>" required placeholder="Ex: Ana Maria Silva">
            </div>

            <div class="mb-3">
                <div class="form-label-custom">
                    <i class="fas fa-map-marker-alt"></i> Endereço
                </div>
                <input type="text" name="endereco" maxlength="50" style="width:100%"
                    value="<?= htmlspecialchars($endereco) ?>" required placeholder="Rua, número, bairro">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-label-custom">
                        <i class="fas fa-id-card"></i> COREN
                    </div>
                    <input type="number" name="coren" value="<?= $coren ?>" required class="form-control custom-input" placeholder="Número do registro">
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-label-custom">
                        <i class="fas fa-calendar-alt"></i> Data de Nascimento
                    </div>
                    <input type="date" name="datanasc" value="<?= $datanasc ?>" class="form-control custom-input">
                </div>
            </div>

            <div class="mb-3">
                <div class="form-label-custom">
                    <i class="fas fa-camera-retro"></i> Nova foto (opcional)
                </div>
                <div class="file-upload-wrapper">
                    <input type="file" name="foto" id="imagemnova" accept="image/*" class="form-control">
                </div>
                <div class="info-text">
                    <i class="fas fa-info-circle"></i> Formatos: JPG, PNG, GIF, WEBP.
                </div>
            </div>

            <div class="preview-section">
                <div class="form-label-custom justify-content-center">
                    <i class="fas fa-image"></i> Pré-visualização
                </div>
                <img src="img/<?= $foto ?>" id="preview" class="preview-img img-fluid" alt="foto do enfermeiro">
                <p class="mt-2 mb-0 text-muted small">Clique em "Escolher arquivo" para trocar a imagem</p>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn btn-custom-ok"><i class="fas fa-save me-2"></i>Salvar alterações</button>
                <button type="reset" class="btn btn-custom-reset"><i class="fas fa-undo-alt me-2"></i>Limpar campos</button>
                <a href="index.php" class="btn btn-custom-cancel"><i class="fas fa-times me-2"></i>Cancelar</a>
            </div>
        </form>
        <?php elseif (!$sucessoMsg && !$erroMsg): ?>
            <div class="text-center py-5">
                <i class="fas fa-user-slash fa-4x text-secondary mb-3"></i>
                <h5 class="text-secondary">Nenhum enfermeiro selecionado</h5>
                <p class="text-muted">Não foi possível carregar os dados solicitados.</p>
                <a href="index.php" class="btn btn-primary rounded-pill px-5 mt-3"><i class="fas fa-arrow-left me-2"></i>Voltar para lista</a>
            </div>
        <?php endif; ?>
        
        <footer>
            <i class="fas fa-heartbeat me-1"></i> NurseCare · Gestão de enfermeiros
        </footer>
    </div>

    <script>
        const fileInput = document.getElementById('imagemnova');
        const previewImg = document.getElementById('preview');
        const fotoAtual = "<?= $foto ?>";

        if (fileInput) {
            fileInput.addEventListener('change', function (event) {
                const file = event.target.files[0];
                if (file) {
                    const allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/jpg'];
                    if (!allowed.includes(file.type)) {
                        alert("Formato inválido! Envie apenas imagens JPG, PNG, GIF ou WEBP.");
                        fileInput.value = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImg.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        const resetBtn = document.querySelector('button[type="reset"]');
        if (resetBtn && previewImg && fotoAtual) {
            resetBtn.addEventListener('click', function (e) {
                setTimeout(() => {
                    if (fileInput) fileInput.value = '';
                    previewImg.src = "img/" + fotoAtual;
                }, 10);
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>