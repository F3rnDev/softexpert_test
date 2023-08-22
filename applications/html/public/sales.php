<?php include 'header.php'; ?>

<body>
    <div class="container mt-5">

        <div class="row align-items-start">

            <div class="col">
                <h1>Cadastro de Produtos</h1>

                <?php if (isset($mensagem)) : ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $mensagem; ?>
                </div>
                <?php endif; ?>

                <form id="produtoCadastroForm" method="post" action="http://localhost:8080/requests.php">
                    <input type="hidden" id="operacao" name="operacao">
                    <input type="hidden" id="identificador" name="identificador">
                    <div class="form-group">
                        <label for="nome">Nome do Produto</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="form-group">
                        <label for="preco">Preço</label>
                        <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <input type="number" step="0.01" class="form-control" id="tipo" name="tipo" required>
                    </div>
                    <button id="cadastrarProdBttn" type="submit" class="btn btn-primary">Cadastrar Produto</button>
                </form>
            </div>

            <div class="col">
                <h1>Lista de Produtos</h1>
                <table class="table table-success table-striped">
                    <thead>
                        <tr>
                            <th scope="col">edit</th>
                            <th scope="col">delete</th>
                            <th scope="col">id</th>
                            <th scope="col">name</th>
                            <th scope="col">price</th>
                            <th scope="col">type</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $host = "postgres";
                            $user = "postgres";
                            $password = "postgres";
                            $dbname = "postgres";
                            $port = "5432";
                            
                            try {
                                $connection = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
                                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                echo "Conectei com sucesso!";
                            } catch (PDOException $e) {
                                echo "Erro na conexão com o banco de dados: " . $e->getMessage();
                                exit;
                            }

                            try {
                                $query = "SELECT * FROM products";
                                $stmt = $connection->prepare($query);
                                $stmt->execute();
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            } catch (PDOException $e) {
                                echo "Erro ao ler os produtos: " . $e->getMessage();
                            }

                            foreach ($result as $row) {
                                echo "<tr>";
                                echo '<th scope="row"><a href="http://localhost:8080/requests.php?id='. $row['id'].'&action=edit"><img src="assets\img\edit.png" width="30" height="30"></a></th>';
                                echo '<td><a href="http://localhost:8080/requests.php?id='. $row['id'].'&action=delete"><img src="assets\img\delete.png" width="30" height="30"></a></td>';
                                echo "<td>{$row['id']}</td>";
                                echo "<td>{$row['prodname']}</td>";
                                echo "<td>{$row['price']}</td>";
                                echo "<td>{$row['typeid']}</td>";
                                echo "</tr>";
                            }

                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
    // Recupera o valor da variável 'valor' da URL
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');
    var name = urlParams.get('name');
    var price = urlParams.get('price');
    var type = urlParams.get('type');

    // Define o valor padrão no campo de entrada
    var campoNome = document.getElementById('nome');
    var campoPreco = document.getElementById('preco');
    var campoTipo = document.getElementById('tipo');
    var produtoCadastroForm = document.getElementById('produtoCadastroForm');
    var bttn = document.getElementById('cadastrarProdBttn');
    var operation = document.getElementById('operacao');
    var docId = document.getElementById('identificador');

    if (id) {
        bttn.innerHTML = 'Atualizar Produto';
        campoNome.value = name;
        campoPreco.value = price;
        campoTipo.value = type;
        operation.value = 'update';
        docId.value = id;
    } else {
        bttn.innerHTML = 'Cadastrar Produto';
        operation.value = 'create';
    }
    </script>
</body>
<?php include 'footer.php'; ?>