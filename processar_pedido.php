<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Resumo do Pedido</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="cssprocesso.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            /* Adicione uma cor de fundo de sua escolha */
        }

        .container {
            margin-top: 20px;
        }

        .resumo {
            background-color: #fff;
            /* Adicione uma cor de fundo de sua escolha */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Resumo do Pedido</h1>

        <?php
        // Lógica para processar o pedido e calcular o valor final
        $tamanho = isset($_POST['tamanho']) ? $_POST['tamanho'] : '';
        $complementos = isset($_POST['complementos']) ? $_POST['complementos'] : [];
        $frutas = isset($_POST['frutas']) ? $_POST['frutas'] : [];
        $coberturas = isset($_POST['coberturas']) ? $_POST['coberturas'] : [];
        $adicionais = isset($_POST['adicionais']) ? $_POST['adicionais'] : [];

        // Informações de endereço
        $enderecoRua = isset($_POST['rua']) ? $_POST['rua'] : '';
        $enderecoNumero = isset($_POST['numero']) ? $_POST['numero'] : '';
        $pontoReferencia = isset($_POST['pontoReferencia']) ? $_POST['pontoReferencia'] : '';
        $metodoPagamento = isset($_POST['metodoPagamento']) ? $_POST['metodoPagamento'] : '';

        // Preços
        $precoTamanho = ($tamanho == '300') ? 14 : (($tamanho == '500') ? 16 : 18);
        $precoComplemento = 0; // Preço por complemento
        $precoFruta = 0; // Preço por fruta
        $precoAdicional = 2; // Preço por adicional

        // Calcular o valor total
        $valorTotal = $precoTamanho;

        // Construir a lista de itens selecionados
        $listaItens = [];

        if (!empty($complementos)) {
            $listaItens[] = "Complementos: " . implode(", ", $complementos);
            foreach ($complementos as $complemento) {
                $valorTotal += $precoComplemento;
            }
        }

        if (!empty($frutas)) {
            $contagemFrutas = count($frutas);
            if ($contagemFrutas <= 2) {
                $listaItens[] = "Frutas: " . implode(", ", $frutas);
                foreach ($frutas as $fruta) {
                    $valorTotal += $precoFruta;
                }
            } else {
                // Limite de 2 frutas, remover extras
                $frutas = array_slice($frutas, 0, 2);
                $listaItens[] = "Frutas: " . implode(", ", $frutas);
                foreach ($frutas as $fruta) {
                    $valorTotal += $precoFruta;
                }
            }
        }

        if (!empty($coberturas)) {
            $contagemCoberturas = count($coberturas);
            if ($contagemCoberturas <= 2) {
                $listaItens[] = "Coberturas: " . implode(", ", $coberturas);
                foreach ($coberturas as $cobertura) {
                    $valorTotal += $precoComplemento;
                }
            } else {
                // Limite de 2 coberturas, remover extras
                $coberturas = array_slice($coberturas, 0, 2);
                $listaItens[] = "Coberturas: " . implode(", ", $coberturas);
                foreach ($coberturas as $cobertura) {
                    $valorTotal += $precoComplemento;
                }
            }
        }

        if (!empty($adicionais)) {
            $listaAdicionais = [];
            foreach ($adicionais as $adicional) {
                $valorTotal += $precoAdicional;
                $listaAdicionais[] = "$adicional (R$ $precoAdicional)";
            }
            $listaItens[] = "Adicionais: " . implode(", ", $listaAdicionais);
        }

// Adicionar informações de endereço ao resumo
$listaEndereco = [];
$listaEndereco[] = "Rua: $enderecoRua";
$listaEndereco[] = "Número: $enderecoNumero";
$listaEndereco[] = "Ponto de Referência: $pontoReferencia";

// Adicionar informações do método de pagamento
$listaPagamento = [];
$listaPagamento[] = "Forma de Pagamento: $metodoPagamento";
?>

<!-- Seu HTML para exibir o resumo -->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- ... (o restante do seu cabeçalho HTML permanece o mesmo) ... -->
</head>

<body>
    <div class="container">
        <h1 class="text-center">Resumo do Pedido</h1>

        <div class="resumo">
            <p><strong>Tamanho:</strong> <?= $tamanho ?>ml (R$ <?= $precoTamanho ?>)</p>

            <?php
            if (!empty($listaItens)) {
                echo '<p><strong>Itens Adicionados:</strong></p>';
                echo '<ul>';
                foreach ($listaItens as $item) {
                    echo "<li>$item</li>";
                }
                echo '</ul>';
            }
            ?>

            <?php
            if (!empty($listaEndereco)) {
                echo '<p><strong>Endereço:</strong></p>';
                echo '<ul>';
                foreach ($listaEndereco as $enderecoItem) {
                    echo "<li>$enderecoItem</li>";
                }
                echo '</ul>';
            }
            ?>

            <?php
            if (!empty($listaPagamento)) {
                echo '<p><strong>Método de pagamento:</strong></p>';
                echo '<ul>';
                foreach ($listaPagamento as $pagamentoItem) {
                    echo "<li>$pagamentoItem</li>";
                }
                echo '</ul>';
            }
            ?>

            <p><strong>Valor Total:</strong> R$ <?= $valorTotal ?></p>

            <?php
            $numeroWhatsApp = '5528999872176'; // Substitua pelo número de WhatsApp desejado
            $mensagemWhatsApp = "Olá, gostaria de fazer um pedido!\n\nTamanho: $tamanho ml\n\n";

            if (!empty($listaItens)) {
                $mensagemWhatsApp .= "Itens Adicionados:\n- " . implode("\n- ", $listaItens) . "\n\n";
            }

            if (!empty($listaEndereco)) {
                $mensagemWhatsApp .= "Endereço:\n- " . implode("\n- ", $listaEndereco) . "\n\n";
            }

            if (!empty($listaPagamento)) {
                $mensagemWhatsApp .= "Método de pagamento:\n- " . implode("\n- ", $listaPagamento) . "\n\n";
            }

            $mensagemWhatsApp .= "Valor Total: R$ $valorTotal";

            $linkWhatsApp = "https://api.whatsapp.com/send?phone=$numeroWhatsApp&fbclid&text=" . urlencode($mensagemWhatsApp);
            ?>
            <a href="<?= $linkWhatsApp ?>" target="_blank" class="btn btn-success">Enviar ao WhatsApp</a>

            <button onclick="window.history.back()" class="btn btn-primary">Editar Pedido</button>
        </div>
    </div>
</body>
</html>
