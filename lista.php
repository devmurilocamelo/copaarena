<?php
require 'conexao.php';

$resultado = $conn->query('SELECT nickname, nome_completo, discord, jogo, cidade, plataforma FROM jogadores ORDER BY id');
$jogadores = $resultado->fetch_all(MYSQLI_ASSOC);

function e($texto) {
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function classeJogo($jogo) {
    $j = mb_strtolower($jogo);
    if (str_contains($j, 'valorant')) return 'valorant';
    if (str_contains($j, 'league') || str_contains($j, 'lol')) return 'lol';
    if (str_contains($j, 'fc') || str_contains($j, 'fifa')) return 'eafc';
    return '';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscritos | Copa Arena</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@500;700&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="topo">
        <a href="index.php" class="marca">Arena Game House</a>
        <nav>
            <a href="index.php">Inscrição</a>
            <a href="lista.php" class="ativo">Inscritos</a>
        </nav>
    </header>

    <main class="lista">
        <div class="lista-cabecalho">
            <h1>Inscritos</h1>
            <p><?= count($jogadores) ?> <?= count($jogadores) === 1 ? 'jogador confirmado' : 'jogadores confirmados' ?></p>
        </div>

        <?php if (!$jogadores): ?>
            <div class="vazio">
                <p>Ninguém se inscreveu ainda.</p>
                <a href="index.php" class="botao">Fazer a primeira inscrição</a>
            </div>
        <?php else: ?>
            <div class="tabela-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nickname</th>
                            <th>Discord</th>
                            <th>Nome</th>
                            <th>Jogo</th>
                            <th>Cidade</th>
                            <th>Plataforma</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jogadores as $i => $j): ?>
                            <tr>
                                <td class="pos"><?= $i + 1 ?></td>
                                <td class="nick"><?= e($j['nickname']) ?></td>
                                <td class="dis"><?= e($j['discord']) ?></td>
                                <td><?= e($j['nome_completo']) ?></td>
                                <td><span class="tag <?= classeJogo($j['jogo']) ?>"><?= e($j['jogo']) ?></span></td>
                                <td class="City"> <?= e($j['cidade']) ?></td>
                                <td class="Plat"> <?= e($j['plataforma']) ?> </td>
                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
