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

                <form id="produtoCadastroForm" method="post" action="http://localhost:8080/productRequests.php">
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
                        <select class="form-control" id="tipo" name="tipo"></select>
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
                    <tbody id="table-body"></tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="assets\js\product.js"></script>
</body>
<?php include 'footer.php'; ?>