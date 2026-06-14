<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Enfermeiro — Gestão de Enfermagem</title>
    <link rel="icon" type="image/icon" href="img/icon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        
        .result-wrap {
            min-height: calc(100vh - 60px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
        }

        .result-box {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,.07);
            padding: 2.5rem 2rem;
            max-width: 440px;
            width: 100%;
            text-align: center;
        }

        .result-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
        }

        .result-icon.success { background: var(--green-dim); color: var(--green); }
        .result-icon.error   { background: #fee2e2;          color: var(--red); }

        .result-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--slate);
            margin: 0 0 .4rem;
        }

        .result-sub {
            font-size: .875rem;
            color: var(--muted);
            margin: 0 0 1.5rem;
        }
    </style>
</head>

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

<div class="result-wrap">
    <div class="result-box">
        <?php
        try {
            include "conexao.php";

            if (isset($_GET['id']) && is_numeric(base64_decode($_GET['id']))) {
                $id = base64_decode($_GET['id']);
            } else {
                header("Location: index.php");
                exit;
            }

                        $sqlFoto   = "SELECT foto FROM enfermeiros WHERE ID = $id";
            $resFoto   = $conexao->query($sqlFoto);
            $dadosFoto = $resFoto->fetch_assoc();

                        $conexao->query("DELETE FROM enfermeiros WHERE ID = $id");

                        if (!empty($dadosFoto['foto']) && $dadosFoto['foto'] !== 'SemImagem.png') {
                $caminho = "img/" . $dadosFoto['foto'];
                if (file_exists($caminho)) unlink($caminho);
            }

            echo '
            <div class="result-icon success">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <p class="result-title">Excluído com sucesso!</p>
            <p class="result-sub">O enfermeiro foi removido do sistema.</p>
            <a href="index.php" class="btn btn-outline-secondary" style="display:inline-flex;">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M19 12H5M12 5l-7 7 7 7"/>
                </svg>
                Voltar à listagem
            </a>';

        } catch (Exception $e) {
            echo '
            <div class="result-icon error">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <p class="result-title">Ocorreu um erro</p>
            <p class="result-sub">' . htmlspecialchars($e->getMessage()) . '</p>
            <a href="index.php" class="btn btn-outline-secondary" style="display:inline-flex;">Voltar</a>';
        }
        ?>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
