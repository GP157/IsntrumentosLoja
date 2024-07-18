<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar</title>
</head>
<body>
    <?php  
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db   = "base_teste01";

        $conn = mysqli_connect($host, $user, $pass, $db );

        if (!$conn) {
            header("Location: cadastro_inserir.html");
            exit();
        } else {
            if ($_SERVER["REQUEST_METHOD"] == 'POST') {
                $nome      = mysqli_real_escape_string($conn, $_POST["nome"]);
                $categoria = mysqli_real_escape_string($conn, $_POST["categoria"]);
                $tipo      = mysqli_real_escape_string($conn, $_POST["tipo"]);
                $valor     = mysqli_real_escape_string($conn, $_POST["valor"]);

                $sql = "INSERT INTO instrumentos (nome, categoria, tipo,preco) VALUES ('$nome', '$categoria', '$tipo','$valor')";

                if (mysqli_query($conn, $sql)) {
                    echo "Instrumento cadastrado com sucesso";
                } else {
                    echo "Erro ao inserir instrumento: " . mysqli_error($conn);
                }
            }
        }

        mysqli_close($conn);
    ?>
    
</body>
</html>