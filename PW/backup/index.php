<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enfermeiros — Gestão</title>
    <link rel="icon" type="image/icon" href="img/icon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="css/estiloindex.css">
    <style>

    </style>
</head>

<body>

    <!-- Barrinha de cima -->
    <nav class="topbar">
        <a href="index.php" class="topbar-brand">
            <span class="icon-wrap">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M12 2a5 5 0 1 1 0 10A5 5 0 0 1 12 2z" />
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                </svg>
            </span>
            Gestão de Enfermeiros
        </a>
        <span style="font-size:.8rem;color:var(--muted);">Sistema de Gestão</span>
    </nav>

    <div class="page-wrap">

        <!--"HEADER" -->
        <div class="page-header">
            <div>
                <h1>Enfermeiros</h1>
                <p>Cadastro e gestão da equipe de enfermagem</p>
            </div>
        </div>

        <!-- Barra de Botões Inicial -->
        <form action="#" method="post">
            <div class="toolbar">
                <div class="search-wrap">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.35-4.35" />
                    </svg>
                    <input type="search" name="filtro" maxlength="50" placeholder="Buscar por nome…"
                        value="<?php echo isset($_POST['filtro']) ? htmlspecialchars($_POST['filtro']) : ''; ?>">
                </div>
                <button type="submit" class="btn-search">Pesquisar</button>
                <a href="incluir.php" class="btn-add">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    Novo Enfermeiro
                </a>
            </div>
        </form>

        <!-- tave -->
        <?php
        try {
            include "conexao.php";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $filtro = $_POST["filtro"];
                $sql = "SELECT ID, nome, endereço, COREN, datanasc, foto FROM enfermeiros WHERE nome LIKE '%$filtro%' ORDER BY nome";
            } else {
                $sql = "SELECT ID, nome, endereço, COREN, datanasc, foto FROM enfermeiros ORDER BY ID";
            }

            $query = $conexao->query($sql);
            $total = $query->num_rows;
            ?>

            <p style="font-size:.8rem;color:var(--muted);margin-bottom:.75rem;">
                <?= $total ?> registro<?= $total !== 1 ? 's' : '' ?> encontrado<?= $total !== 1 ? 's' : '' ?>
            </p>

            <div class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th class="td-id">ID</th>
                            <th>Nome</th>
                            <th class="hide-mobile">Endereço</th>
                            <th>COREN</th>
                            <th class="hide-mobile">Nascimento</th>
                            <th>Foto</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($total === 0): ?>
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5"
                                            viewBox="0 0 24 24">
                                            <circle cx="11" cy="11" r="8" />
                                            <path d="m21 21-4.35-4.35" />
                                        </svg>
                                        <p>Nenhum enfermeiro encontrado.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php while ($dados = mysqli_fetch_array($query)):
                                $datanasc = date("d/m/Y", strtotime($dados['datanasc']));
                                $foto = empty($dados['foto']) ? "SemImagem.png" : $dados['foto'];
                                $id = base64_encode($dados['ID']);
                                ?>
                                <tr>
                                    <td class="td-id"><?= $dados['ID'] ?></td>
                                    <td class="td-nome"><?= htmlspecialchars($dados['nome']) ?></td>
                                    <td class="hide-mobile" style="color:var(--muted);font-size:.82rem;">
                                        <?= htmlspecialchars($dados['endereço']) ?>
                                    </td>
                                    <td><span class="td-coren"><?= htmlspecialchars($dados['COREN']) ?></span></td>
                                    <td class="td-data hide-mobile"><?= $datanasc ?></td>
                                    <td>
                                        <a href="verenfermeiro.php?id=<?= $id ?>" class="avatar-link">
                                            <div class="avatar-wrap">
                                                <img src="img/<?= $foto ?>" alt="<?= htmlspecialchars($dados['nome']) ?>"
                                                    loading="lazy">
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="verenfermeiro.php?id=<?= $id ?>" class="btn-act btn-view">
                                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                                Ver
                                            </a>
                                            <a href="editar.php?id=<?= $id ?>" class="btn-act btn-edit">
                                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                                Editar
                                            </a>
                                            <a href="#" class="btn-act btn-del" data-bs-toggle="modal"
                                                data-bs-target="#excluirModal" data-enfermeiro="<?= $id ?>">
                                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <polyline points="3 6 5 6 21 6" />
                                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                                    <path d="M10 11v6M14 11v6" />
                                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                                </svg>
                                                Apagar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php
        } catch (Exception $e) {
            echo '<div class="alert-custom alert-danger-custom">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span><strong>Erro:</strong> ' . htmlspecialchars($e->getMessage()) . '</span>
              </div>';
        }
        ?>

    </div>

    <?php include "modal.php"; ?>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/dialogo.js"></script>

</body>

</html>