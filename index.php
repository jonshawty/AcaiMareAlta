<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personalize seu Açaí</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script>
    function limitarComplementos() {
        var checkboxes = document.querySelectorAll('input[name="complementos[]"]');
        var totalSelecionados = 0;

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                totalSelecionados++;
            }
        });

        var tamanhoSelecionado = document.getElementById('tamanho').value;

        // Defina o número máximo de complementos com base no tamanho escolhido
        var maxComplementos = (tamanhoSelecionado == 300) ? 3 : 5;

        if (totalSelecionados >= maxComplementos) {
            checkboxes.forEach(function(checkbox) {
                if (!checkbox.checked) {
                    checkbox.disabled = true;
                }
            });
        } else {
            checkboxes.forEach(function(checkbox) {
                checkbox.disabled = false;
            });
        }
    }

    function limitarFrutas() {
        var checkboxes = document.querySelectorAll('input[name="frutas[]"]');
        var totalSelecionados = 0;

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                totalSelecionados++;
            }
        });

        if (totalSelecionados >= 2) {
            checkboxes.forEach(function(checkbox) {
                if (!checkbox.checked) {
                    checkbox.disabled = true;
                }
            });
        } else {
            checkboxes.forEach(function(checkbox) {
                checkbox.disabled = false;
            });
        }
    }

    function mostrarFormularioAdicional() {
        var continuarPedindoBtn = document.getElementById('continuarPedindoBtn');
        var enviarPedidoBtn = document.getElementById('enviarPedidoBtn');
        var formularioAdicional = document.getElementById('formularioAdicional');

        continuarPedindoBtn.style.display = 'none';
        enviarPedidoBtn.style.display = 'block';
        formularioAdicional.style.display = 'block';
    }
    </script>
</head>
<body>
    <div class="container">
        <img src="img/cabelalho.png" alt="Cabeçalho" class="cabecalho-img mb-3">
        <h1>Personalize seu Açaí</h1>

        <form action="processar_pedido.php" method="post">

            <!-- Tamanho do Açaí -->
            <div class="form-group">
                <strong><label for="tamanho">Escolha o tamanho:</label></strong>
                <select class="form-control" name="tamanho" id="tamanho">
                    <option value="300">300ml - 14 R$</option>
                    <option value="500">500ml - 16 R$</option>
                    <option value="700">700ml - 18 R$</option>
                </select>
            </div>
            <hr>

            <!-- Complementos -->
            <div class="form-group">
                <strong><label>Escolha até 5 complementos:</label></strong>
                <div class="row">
                    <?php
                    $complementos = [
                        'Amendoim Triturado', 'Granola', 'Paçoca', 'Leite em Pó',
                        'Sucrilhos Cereal', 'Sucrilhos Chocolate', 'Disquete', 'Granulado',
                        'Ovo Maltine', 'Leite Condensado'
                    ];

                    $complementosPorColuna = ceil(count($complementos) / 2);

                    for ($i = 0; $i < 2; $i++) {
                        echo '<div class="col-md-6">';
                        for ($j = 0; $j < $complementosPorColuna; $j++) {
                            $index = $i * $complementosPorColuna + $j;
                            if ($index < count($complementos)) {
                                echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="checkbox" name="complementos[]" value="' . $complementos[$index] . '" onchange="limitarComplementos()">';
                                echo '<label class="form-check-label">' . $complementos[$index] . '</label>';
                                echo '</div>';
                            }
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <hr>

            <!-- Frutas -->
            <div class="form-group">
                <strong><label>Escolha até 2 frutas:</label></strong>
                <?php
                $frutasDisponiveis = ['Morango', 'Banana', 'Kiwi', 'Uva'];

                foreach ($frutasDisponiveis as $fruta) {
                    echo '<div class="form-check">';
                    echo '<input class="form-check-input" type="checkbox" name="frutas[]" value="' . $fruta . '" onchange="limitarFrutas()">';
                    echo '<label class="form-check-label">' . $fruta . '</label>';
                    echo '</div>';
                }
                ?>
            </div>
            <hr>

            <!-- Coberturas -->
            <div class="form-group">
                <strong><label>Escolha até 2 coberturas:</label></strong>
                <?php
                $coberturas = ['Morango', 'Chocolate'];

                foreach ($coberturas as $cobertura) {
                    echo '<div class="form-check">';
                    echo '<input class="form-check-input" type="checkbox" name="coberturas[]" value="' . $cobertura . '">';
                    echo '<label class="form-check-label">' . $cobertura . '</label>';
                    echo '</div>';
                }
                ?>
            </div>
            <hr>

            <!-- Adicionais -->
            <div class="form-group">
                <strong><label>Escolha os adicionais (R$ 2 cada):</label></strong>
                <?php
                $adicionais = ['Nutella', 'Bis', 'Kitkat', 'Ovo Maltine', 'Oreo'];

                foreach ($adicionais as $adicional) {
                    echo '<div class="form-check">';
                    echo '<input class="form-check-input" type="checkbox" name="adicionais[]" value="' . $adicional . '">';
                    echo '<label class="form-check-label">' . $adicional . ' (R$ 2)</label>';
                    echo '</div>';
                }
                ?>
            </div>
            <hr>

            <button type="button" id="continuarPedindoBtn" onclick="mostrarFormularioAdicional()" class="btn btn-primary">Continuar pedindo</button>

            <!-- Formulário Adicional (inicialmente oculto) -->
            <div id="formularioAdicional" style="display: none;">
                <div class="form-row">
                    <div class="form-group col-md-9">
                        <label for="rua">Rua:</label>
                        <input type="text" id="rua" name="rua" class="form-control">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="numero">Número:</label>
                        <input type="text" id="numero" name="numero" class="form-control" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="pontoReferencia">Ponto de Referência:</label>
                    <input type="text" id="pontoReferencia" name="pontoReferencia" class="form-control" >
                </div>

                <div class="form-group">
                    <label for="metodoPagamento">Método de Pagamento:</label>
                    <select id="metodoPagamento" name="metodoPagamento" class="form-control">
                        <option value="Pix">Pix</option>
                        <option value="cartao">Cartão de Crédito/Débito</option>
                        <option value="dinheiro">Dinheiro</option>
                    </select>
                </div>
            </div>


            <button type="submit" id="enviarPedidoBtn" style="display: none;" class="btn btn-primary">Enviar Pedido</button>
        </form>
    </div>
</body>
</html>
