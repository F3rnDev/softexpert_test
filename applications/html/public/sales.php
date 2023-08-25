<?php include 'header.php'; ?>

<body>
    <div class="container mt-5">

        <div class="row align-items-start">

            <div class="col">
                <h1>Cadastro de Vendas</h1>

                <form id="vendaCadastroForm" method="post" action="http://localhost:8080/salesRequests.php">
                    <input type="hidden" id="salesOperacao" name="salesOperacao">
                    <input type="hidden" id="saleId" name="saleId">
                    <div class="form-group">
                        <label for="info">Descrição da venda</label>
                        <input type="text" class="form-control" id="info" name="info" required>
                    </div>
                    <button id="cadastrarVendaBttn" type="submit" class="btn btn-primary">Cadastrar Venda</button>
                </form>

                <h1>Cadastro de Produtos da Venda</h1>

                <form id="produtoCadastroForm" method="post" action="http://localhost:8080/salesItemsRequests.php">
                    <input type="hidden" id="itensOperacao" name="itensOperacao">
                    <input type="hidden" id="itemId" name="itemId">
                    <input type="hidden" id="saleItemId" name="saleItemId">
                    <div class="form-group">
                        <select class="form-control" id="produto" name="produto"></select>
                    </div>
                    <div class="form-group">
                        <label for="quantidade">Quantidade</label>
                        <input type="number" step="1" class="form-control" id="quantidade" name="quantidade" required>
                    </div>
                    <button id="cadastrarProdBttn" type="submit" class="btn btn-primary">Cadastrar Produto</button>
                </form>
            </div>

            <div class="col">
                <h1>Lista de Itens desta venda</h1>
                <table class="table table-success table-striped">
                    <thead>
                        <tr>
                            <th scope="col">delete</th>
                            <th scope="col">Produto</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Preço Unitário</th>
                            <th scope="col">Imposto</th>
                            <th scope="col">Imposto da venda</th>
                            <th scope="col">Valor Total</th>
                        </tr>
                    </thead>

                    <tbody id="table-body"></tbody>
                </table>
                <div id="endSale">
                    <h5 align="right" id="totalTax"></h5>
                    <h4 align="right" id="totalSale"></h4>
                    <div align="right">
                        <button id="cancel" type="button" class="btn btn-danger" onclick="cancelSale()">Cancelar</button>
                        <button id="finish" type="button" class="btn btn-success" onclick="finishSale()">Finalizar Venda</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets\js\sales.js"></script>
</body>
<?php include 'footer.php'; ?>