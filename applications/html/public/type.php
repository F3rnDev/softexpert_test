<?php include 'header.php'; ?>

<body>
    <div class="container mt-5">

        <div class="row align-items-start">

            <div class="col">
                <h1>Cadastro de Tipos</h1>

                <?php if (isset($mensagem)) : ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $mensagem; ?>
                </div>
                <?php endif; ?>

                <form id="typeCadastroForm" method="post" action="http://localhost:8080/typeRequests.php">
                    <input type="hidden" id="operacao" name="operacao">
                    <input type="hidden" id="identificador" name="identificador">
                    <div class="form-group">
                        <label for="info">Informação</label>
                        <input type="text" class="form-control" id="info" name="info" required>
                    </div>
                    <div class="form-group">
                        <label for="taxes">Imposto (%)</label>
                        <input type="number" step="0.01" class="form-control" id="taxes" name="taxes" required>
                    </div>
                    <button id="cadastrarTypeBttn" type="submit" class="btn btn-primary">Cadastrar Produto</button>
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
                            <th scope="col">info</th>
                            <th scope="col">taxes</th>
                        </tr>
                    </thead>

                    <tbody id="table-body"></tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="assets\js\type.js"></script>
</body>
<?php include 'footer.php'; ?>