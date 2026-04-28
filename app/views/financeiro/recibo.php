<?php
if (ob_get_level()) ob_end_clean();

require BASE_PATH . "/config/conexao.php";

// CONFIG
$sql = $pdo->query("SELECT * FROM configuracoes LIMIT 1");
$config = $sql->fetch(PDO::FETCH_ASSOC);

// LOGO
$logo = (!empty($config['logo']) && file_exists(BASE_PATH . "/public/assets/img/" . $config['logo']))
    ? BASE_URL . "/assets/img/" . $config['logo']
    : BASE_URL . "/assets/img/logo9.png";

// DOCUMENTO
$doc = $config['documento'] ?? '';
$docNumero = preg_replace('/\D/', '', $doc);
$tipoDoc = strlen($docNumero) > 11 ? 'CNPJ' : 'CPF';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recibo</title>

    <style>
        body {
            font-family: Arial;
            padding: 30px;
            background: #fff;
        }

        .recibo {
            max-width: 750px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 8px;
        }

        .topo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .logo {
            height: 70px;
        }

        .clinica {
            text-align: right;
            /* font-size: 14px; */
        }

        .clinica strong {
            font-size: 14px; /* nome da clínica maior */
        }

        .clinica small {
            font-size: 12px;
            color: #555;
        }

       
        .titulo {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .linha {
            margin-bottom: 12px;
            font-size: 16px;
        }

        .assinatura {
            margin-top: 60px;
            text-align: center;
        }

        .btn-print {
            margin-top: 20px;
            text-align: center;
        }

        @media print {
            .btn-print { display: none; }
        }
    </style>
</head>

<body>

<div class="recibo">

    <!-- 🔥 CABEÇALHO -->
    <div class="topo">

        <!-- LOGO -->
        <div>
            <img src="<?= $logo ?>" class="logo" style='border-radius: 10px;'>
        </div>

        <!-- DADOS -->
        <div class="clinica">

            <strong><?= htmlspecialchars($config['nome_clinica'] ?? 'Clínica') ?></strong><br>

            <?php if(!empty($doc)): ?>
                <small><?= $tipoDoc ?>: <?= htmlspecialchars($doc) ?></small><br>
            <?php endif; ?>

            <small>
                <?= htmlspecialchars($config['endereco'] ?? '') ?>, <?= htmlspecialchars($config['numero'] ?? '') ?><br>
                <?= htmlspecialchars($config['bairro'] ?? '') ?> -
                <?= htmlspecialchars($config['cidade'] ?? '') ?> - <?= htmlspecialchars($config['estado'] ?? '') ?><br>
            </small>

            <?php if(!empty($config['telefone'])): ?>
                <small>
                    <small>Telefone:</small> <?= htmlspecialchars($config['telefone']) ?>
                </small>
            <?php endif; ?>

        </div>

    </div>

    <!-- TÍTULO -->
    <div class="titulo">🧾 Recibo de Pagamento</div>

    <!-- DADOS -->
    <div class="linha">
        Recebi de: 
        <strong><?= htmlspecialchars($conta['paciente'] ?? 'Paciente') ?></strong>
    </div>

    <div class="linha">
        Valor: 
        <strong>R$ <?= number_format($conta['valor'] ?? 0, 2, ',', '.') ?></strong>
    </div>

    <div class="linha">
        Referente a: 
        <?= htmlspecialchars($conta['descricao'] ?? '-') ?>
    </div>

    <div class="linha">
        Forma de pagamento: 
        <strong><?= strtoupper($conta['forma_pagamento'] ?? 'Não informado') ?></strong>
    </div>

    <div class="linha">
        Data: 
        <?= date('d/m/Y', strtotime($conta['data_pagamento'] ?? date('Y-m-d'))) ?>
    </div>

    <!-- ASSINATURA -->
    <div class="assinatura">
        _______________________________<br>
        <?= htmlspecialchars($config['nome_clinica'] ?? '') ?>
    </div>

    <div class="btn-print">
        <button onclick="window.print()">🖨 Imprimir</button>
    </div>

</div>

</body>
</html>