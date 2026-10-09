<?php
require 'conexao.php';

$campos = [
    'nickname'      => ['rotulo' => 'Nickname',            'tipo' => 'text',  'dica' => 'Como você aparece no jogo'],
    'nome_completo' => ['rotulo' => 'Nome completo',       'tipo' => 'text',  'dica' => 'Ex.: João da Conceição'],
    'email'         => ['rotulo' => 'E-mail',              'tipo' => 'email', 'dica' => 'voce@email.com'],
    'telefone'      => ['rotulo' => 'Telefone/WhatsApp',   'tipo' => 'text',  'dica' => '(11) 91234-5678'],
    'discord'       => ['rotulo' => 'Usuário do Discord',  'tipo' => 'text',  'dica' => 'seu_usuario'],
    'cidade'        => ['rotulo' => 'Cidade',              'tipo' => 'text',  'dica' => 'Ex.: São Caetano do Sul'],
    'plataforma'    => ['rotulo' => 'Plataforma',          'tipo' => 'text',  'dica' => 'PC, console ou celular',
                        'opcoes' => ['PC', 'Console', 'Celular']],
    'jogo'          => ['rotulo' => 'Jogo',                'tipo' => 'text',  'dica' => 'Valorant, League of Legends ou EA FC',
                        'opcoes' => ['Valorant', 'League of Legends', 'EA FC']],
];

$dados  = array_fill_keys(array_keys($campos), '');
$vazios = [];
$aviso  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($campos as $coluna => $config) {
        $dados[$coluna] = trim($_POST[$coluna] ?? '');
        if ($dados[$coluna] === '') {
            $vazios[] = $coluna;
        }
    }

    if ($vazios) {
        $nomes = array_map(fn($c) => $campos[$c]['rotulo'], $vazios);
        $aviso = 'Preencha todos os campos para se inscrever. Faltou: ' . implode(', ', $nomes) . '.';
    } elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
        $vazios[] = 'email';
        $aviso = 'O e-mail digitado não é válido. Confira e tente de novo.';
    } else {
        $sql  = 'INSERT INTO jogadores (nickname, nome_completo, email, telefone, discord, cidade, plataforma, jogo)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssssss', ...array_values($dados));
        $stmt->execute();
        header('Location: index.php?sucesso=' . urlencode($dados['nickname']));
        exit;
    }
}

$sucesso = $_GET['sucesso'] ?? null;

function e($texto) {
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscrição | Copa Arena</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@500;700&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="topo">
        <a href="index.php" class="marca">Arena Game House</a>
        <nav>
            <a href="index.php" class="ativo">Inscrição</a>
            <a href="lista.php">Inscritos</a>
        </nav>
    </header>

    <main class="inscricao">
        <section class="chamada">
            <h1>Copa<br>Arena</h1>
            <p>O primeiro campeonato de e-sports da Arena. Preencha sua ficha de jogador e garanta sua vaga.</p>
            <ul class="jogos">
                <li class="valorant">Valorant</li>
                <li class="lol">League of Legends</li>
                <li class="eafc">EA FC</li>
            </ul>
        </section>

        <section class="ficha">
            <h2>Ficha de inscrição</h2>

            <?php if ($aviso): ?>
                <div class="alerta alerta-aviso" role="alert"><?= e($aviso) ?></div>
            <?php endif; ?>

            <?php if ($sucesso !== null): ?>
                <div class="alerta alerta-sucesso" role="status">
                    Inscrição confirmada! Boa sorte na Copa Arena, <strong><?= e($sucesso) ?></strong>.
                </div>
            <?php endif; ?>

            <form method="post" action="index.php" novalidate id="form-inscricao">
                <?php foreach ($campos as $coluna => $config): ?>
                    <div class="campo <?= in_array($coluna, $vazios) ? 'campo-erro' : '' ?>">
                        <label for="<?= $coluna ?>"><?= e($config['rotulo']) ?></label>
                        <input
                            type="<?= $config['tipo'] ?>"
                            id="<?= $coluna ?>"
                            name="<?= $coluna ?>"
                            value="<?= e($dados[$coluna]) ?>"
                            placeholder="<?= e($config['dica']) ?>"
                            <?= isset($config['opcoes']) ? 'list="lista-' . $coluna . '"' : '' ?>
                            autocomplete="off">
                        <?php if (isset($config['opcoes'])): ?>
                            <datalist id="lista-<?= $coluna ?>">
                                <?php foreach ($config['opcoes'] as $opcao): ?>
                                    <option value="<?= e($opcao) ?>">
                                <?php endforeach; ?>
                            </datalist>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <button type="submit">Confirmar inscrição</button>
            </form>
        </section>
    </main>

    <script src="main.js"></script>
</body>
</html>
