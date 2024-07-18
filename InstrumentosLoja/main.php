
<?php 
$host = "localhost";
$user = "root";
$pass = "";
$db   = "base_teste01";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

session_start(); // Iniciar a sessão

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (isset($_POST['logout'])) {
        // Lógica de logout
        session_destroy();
        header("Location: loginPage.php"); // Redirecionar para a página de login
        exit;
    }

    if (isset($_POST['codigo']) && !isset($_POST['editar']) && !isset($_POST['excluir'])) {
        $codigo = mysqli_real_escape_string($conn, $_POST['codigo']);

        $sql = "SELECT * FROM instrumentos WHERE codigo = '$codigo'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $nome = $row['nome'];
                $categoria = $row['categoria'];
                $tipo = $row['tipo'];
                $preco = $row['preco'];
            } else {
                $error = "Instrumento não encontrado!";
            }
        } else {
            $error = "Erro na consulta: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['editar'])) {
        $codigo = mysqli_real_escape_string($conn, $_POST['codigo']);
        $nome = mysqli_real_escape_string($conn, $_POST['nome']);
        $categoria = mysqli_real_escape_string($conn, $_POST['categoria']);
        $tipo = mysqli_real_escape_string($conn, $_POST['tipo']);
        $preco = mysqli_real_escape_string($conn, $_POST['preco']);

        $sql = "UPDATE instrumentos SET nome='$nome', categoria='$categoria', tipo='$tipo',preco='$preco' WHERE codigo='$codigo'";
        if (mysqli_query($conn, $sql)) {
            $message = "Instrumento atualizado com sucesso!";
        } else {
            $error = "Erro ao atualizar o instrumento: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['excluir'])) {
        $codigo = mysqli_real_escape_string($conn, $_POST['codigo']);

        $sql = "DELETE FROM instrumentos WHERE codigo='$codigo'";
        if (mysqli_query($conn, $sql)) {
            $message = "Instrumento excluído com sucesso!";
        } else {
            $error = "Erro ao excluir o instrumento: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sol Instrumentos</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
  <div class="wrapper">
    <aside id="sidebar">
        <div class="d-flex">
            <button class="toggle-btn" type="button">
                <i class="lni lni-grid-alt"></i>
            </button>
            <div class="sidebar-logo">
                <a href="#">Sol instrumentos</a>
            </div>
        </div>
        <ul class="sidebar-nav">
          <li class="sidebar-item">
              <a href="#" class="sidebar-link" data-toggle="modal" data-target="#cadastrarInstrumentoModal">
                  <i class="lni lni-plus"></i> <span >Cadastrar instrumentos</span>
              </a>
          </li>
      </ul>
      <div class="sidebar-footer">
    <a href="#" class="sidebar-link" id="logout-button">
        <i class="lni lni-exit"></i>
        <span>Logout</span>
    </a>
</div>

    </aside>
    <div class="modal fade" id="cadastrarInstrumentoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cadastro de instrumentos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
          <div class="modal-body">
              <!-- Formulário de cadastro -->
              <form id="cadastrarInstrumentoForm"method="post" action="inserir.php">
                  <div class="mb-3">
                      <label for="nomeInstrumento" class="form-label">Nome do Instrumento</label>
                      <input type="text" class="form-control" id="nomeInstrumento" name="nome" required>
                  </div>
                  <div class="mb-3">
                    <label for="categoriaInstrumento" class="form-label">Categoria</label>
                    <input type="text" class="form-control" id="categoriaInstrumento " name="categoria" required>
                </div>
                  <div class="mb-3">
                      <label for="tipoInstrumento" class="form-label">Tipo do Instrumento</label>
                      <input type="text" class="form-control" id="tipoInstrumento" name="tipo" required>
                  </div>
                  <div class="mb-3">
                      <label for="precoInstrumento" class="form-label">Preço do Instrumento</label>
                      <input type="number" class="form-control" id="precoInstrumento" name="valor" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Cadastrar</button>
              </form>
          </div>
      </div>
  </div>
</div>
    <div class="main p-3">
      <div class="text-center">
  <header>
  <div class="container d-flex justify-content-center my-4">
        <form class="d-flex" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="position-relative">
                <input class="form-control custom-search-bar" type="search" name="codigo" placeholder="Pesquisar" aria-label="Pesquisar" required>
                <span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                </span>
            </div>
            <button class="btn btn-outline-success custom-button ml-2" type="submit">Pesquisar</button>
        </form>
    </div>
      
          <div class="container centered-card">
          <div class="container centered-card">
    <?php if (isset($nome)) { ?>
        <div class="card shadow" style="width: 25rem;">
        <div class="card-body">
            <h5 class="card-title">Código do produto: <?php echo htmlspecialchars($codigo); ?></h5>
            <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($nome); ?></h6>
            <br>
            <div class="card-text">R$<?php echo htmlspecialchars($preco); ?></div>
            <div class="card-text">Categoria: <?php echo htmlspecialchars($categoria); ?></div>
            <div class="card-text">Tipo: <?php echo htmlspecialchars($tipo); ?></div>
            <br>
            <div class="card-buttons">
                <!-- Botão Editar -->
                <button class="btn btn-outline-primary " type="button" data-toggle="modal" data-target="#editarModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                      <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                    </svg>
                    
                </button>
                <!-- Botão Excluir -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="display: inline;">
                    <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($codigo); ?>">
                    <button class="btn btn-outline-danger" type="submit" name="excluir">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                      <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                    </svg>
                        
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php } elseif (isset($message)) { ?>
    <div class="alert alert-success" role="alert">
        <?php echo htmlspecialchars($message); ?>
    </div>
    <?php } elseif (isset($error)) { ?>
    <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($error); ?>
    </div>
    <?php } ?>
</div>

<!-- Modal de Edição -->
<div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar Instrumento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($codigo); ?>">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoria</label>
                        <input type="text" class="form-control" name="categoria" value="<?php echo htmlspecialchars($categoria); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <input type="text" class="form-control" name="tipo" value="<?php echo htmlspecialchars($tipo); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="preco">Preço</label>
                        <input type="text" class="form-control" name="preco" value="<?php echo htmlspecialchars($preco); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="editar">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>
        </div>

        <script>
document.getElementById('logout-button').addEventListener('click', function(event) {
    event.preventDefault(); // Previne o comportamento padrão do link
    fetch('logout.php')
        .then(response => response.text())
        .then(data => {
            if (data === 'success') {
                window.location.href = 'loginPage.php'; // Redireciona para a página de login
            } else {
                alert('Falha ao fazer logout.');
            }
        });
});
</script>
      
        <script src="JS/jquery-3.3.1.slim.min.js"></script>
        <script src="JS/bootstrap.bundle.min.js"></script>   
        <script src="JS/popper.min.js"></script>
        <script src="JS/bootstrap.min.js"></script>
        <script src="JS/script.js"></script>
    <script src="JS/script.js"></script>
</body>

</html>