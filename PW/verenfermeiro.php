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
        /* ── exclusivo: layout do cartão de perfil ── */
        .profile-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
            max-width: 560px;
            min-width: 320px;
            overflow: hidden;
        }

        /* Banner decorativo no topo do cartão */
        .profile-banner {
            height: 90px;
            background: linear-gradient(135deg, var(--teal) 0%, var(--teal-light) 100%);
        }

        .profile-body {
            padding: 0 2rem 2rem;
        }

        /* Avatar posicionado metade dentro do banner */
        .profile-avatar {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            border: 4px solid var(--white);
            object-fit: cover;
            margin-top: -48px;
            display: block;
            box-shadow: 0 2px 8px rgba(0,0,0,.15);
        }

        .profile-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--slate);
            margin: .6rem 0 .15rem;
        }

        /* Linha de campo com ícone */
        .profile-field {
            display: flex;
            align-items: flex-start;
            gap: .6rem;
            padding: .7rem 0;
            border-bottom: 1px solid var(--border);
            font-size: .875rem;
        }

        .profile-field:last-of-type { border-bottom: none; }

        .profile-field svg { color: var(--teal); margin-top: 2px; flex-shrink: 0; }

        .profile-field-label {
            font-size: .72rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .profile-field-value {
            font-weight: 500;
            color: var(--slate);
        }
</style>
</head>

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
        <div>
            <h1>Ficha do Enfermeiro</h1>
            <h3 style="margin-top: 1%;">Dados completos do cadastro</h3>
        </div>
    </div>

    <?php
    try {
        include "conexao.php";

        // Valida e decodifica o ID recebido pela URL
        if (isset($_GET['id']) && is_numeric(base64_decode($_GET['id']))) {
            $id = base64_decode($_GET['id']);
        } else {
            header("Location: index.php");
            exit;
        }

        // Busca os dados do enfermeiro pelo ID
        $sql   = "SELECT * FROM enfermeiros WHERE ID = $id";
        $query = $conexao->query($sql);

        if ($query->num_rows > 0) {
            $dados    = $query->fetch_assoc();
            $nome     = $dados['nome'];
            $endereco = $dados['endereço'];
            $coren    = $dados['COREN'];
            // Formata a data para exibição no padrão brasileiro
            $dt       = new DateTime($dados['datanasc'], new DateTimeZone("America/Sao_Paulo"));
            $datanasc = $dt->format("d/m/Y");
            $foto     = empty($dados['foto']) ? "SemImagem.png" : $dados['foto'];
            $idEnc    = base64_encode($id); // Recodifica para uso nos links
        } else {
            throw new Exception("Enfermeiro não encontrado!");
        }

    } catch (Exception $e) {
        echo '<div class="alert-custom alert-danger-custom">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <div><strong>Erro:</strong> ' . htmlspecialchars($e->getMessage()) . '<br>
                    <a href="index.php" class="btn-outline" style="margin-top:.5rem;">Voltar</a>
                </div>
              </div>';
    }
    ?>

    <!-- Exibe o cartão de perfil apenas se os dados foram carregados com sucesso -->
    <?php if (isset($nome)): ?>
    <div class="profile-wrapper">
        <div class="profile-card" style="width: 85%;">
            <div class="profile-banner"></div>
            <div class="profile-body">
                <img src="img/<?= $foto ?>" class="profile-avatar" alt="<?= htmlspecialchars($nome) ?>">
                <p class="profile-name"><?= htmlspecialchars($nome) ?></p>
                <span class="td-coren">COREN <?= htmlspecialchars($coren) ?></span>

                <hr class="section-divider">

                <!-- Campo: Endereço -->
                <div class="profile-field">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <div>
                        <div class="profile-field-label">Endereço</div>
                        <div class="profile-field-value"><?= htmlspecialchars($endereco) ?></div>
                    </div>
                </div>

                <!-- Campo: Data de Nascimento -->
                <div class="profile-field">
                    <div>
                        <div class="profile-field-label">Data de Nascimento</div>
                        <div class="profile-field-value"><?= $datanasc ?></div>
                    </div>
                </div>

                <div class="form-actions" style="display: flex; gap: 1rem; justify-content: center;">
                    <a href="editar.php?id=<?= $idEnc?>">
                       <button type="button" class="btn btn-outline-primary">Editar</button>
                    </a>
                    <a href="index.php"></a>
                        <button type="button" class="btn btn-outline-secondary">Voltar</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
