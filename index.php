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

            if (totalSelecionados >= 5) {
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
    </script>
</head>
<body>
    <div class="container">
        <img src="cabelalho.png" alt="Cabeçalho" class="cabecalho-img mb-3">
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

            <button type="submit" class="btn btn-primary">Enviar Pedido</button>
        </form>
    </div>
</body>
</html>
