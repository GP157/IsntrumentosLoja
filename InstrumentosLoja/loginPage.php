<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body class="text-white" style="background-color: #050949;">
    <div class="container mx-auto shadow m-5 p-3 bg-dark rounded" style="width: 500px; height: 500px">
        <img class="mx-auto d-block rounded-circle" src="img/logo.jpg" alt="Logotipo da Sol instrumentos" style="width: 90px; height: 90px">
        <h4 class="text-center m-4">Boas-vindas ao sistema de estoque da Sol Instrumentos</h4>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="form-group px-2 m-3">
                <label for="InputCodigoFuncionario">Código de identificação:</label>
                <input type="text" class="form-control" id="codigo_funcionario" name="codigo_funcionario" placeholder="Digite seu código:" required autofocus>
            </div>
            <div class="form-group px-2 m-3">
                <label for="InputSenhaFuncionario">Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha:" required>
            </div>
            <button type="submit" class="btn btn-primary mx-auto d-block m-2 mt-5" style="width: 75%; height: 60%">Entrar</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>





<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "base_teste01";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
} else {
    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        $codigo_funcionario = mysqli_real_escape_string($conn, $_POST["codigo_funcionario"]);
        $senha = mysqli_real_escape_string($conn, $_POST["senha"]);

        // Verifica se o funcionário existe no banco de dados
        $sql = "SELECT * FROM funcionarios WHERE codigo_funcionario='$codigo_funcionario' AND senha='$senha'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Login realizado com sucesso, redireciona para a página principal
            header("Location: main.php");
            exit();
        } else {
            // Redireciona para a página de erro de login
            header("Location: modalNaoLogado.html");
            exit();
        }
    }
}

mysqli_close($conn);
?>


  </html>