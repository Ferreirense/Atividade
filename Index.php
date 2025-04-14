<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "investimentos";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo'];
    $valor = $_POST['valor'];
    $data = $_POST['data'];
    $descricao = $_POST['descricao'];


    if (empty($tipo) || empty($valor) || empty($data)) {
        echo "Todos os campos são obrigatórios.";
    } else {
        $sql = "INSERT INTO investimentos (tipo, valor, data, descricao) VALUES ('$tipo', '$valor', '$data', '$descricao')";
        if ($conn->query($sql) === TRUE) {
            echo "Novo investimento cadastrado com sucesso!";
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    }
}


$sql = "SELECT * FROM investimentos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Investimentos</title>
</head>
<body>
    <h1>Cadastro de Investimentos</h1>
    <form method="POST" action="">
        <label for="tipo">Tipo:</label>
        <input type="text" id="tipo" name="tipo" required><br>

        <label for="valor">Valor:</label>
        <input type="number" id="valor" name="valor" step="0.01" required><br>

        <label for="data">Data:</label>
        <input type="date" id="data" name="data" required><br>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao"></textarea><br>

        <input type="submit" value="Cadastrar">
    </form>

    <h2>Investimentos Cadastrados</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Valor</th>
            <th>Data</th>
            <th>Descrição</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['tipo']}</td>
                        <td>{$row['valor']}</td>
                        <td>{$row['data']}</td>
                        <td>{$row['descricao']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nenhum investimento cadastrado.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
