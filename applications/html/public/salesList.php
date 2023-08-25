<?php include 'header.php'; ?>

<body>
    <div class="container mt-5">

        <div class="row align-items-start">

            <div class="col">
                <h1>Listagem de vendas</h1>

                <form id="listagemVendas" method="post" action="http://localhost:8080/controller/salesController.php">
                    <input type="hidden" id="salesOperacao" name="salesOperacao" value="Listagem">
                    <input type="hidden" id="saleId" name="saleId">
                    <div class="form-group">
                        <select class="form-control" id="venda" name="venda"></select>
                    </div>
                    <button id="pesquisarVendaBtn" type="submit" class="btn btn-primary">Listar Venda</button>
                </form>
            </div>

            <div class="col">
                <table class="table table-success table-striped">
                    <thead>
                        <tr>
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
                        <button id="delete" type="button" class="btn btn-danger" onclick="deleteSale()">Deletar Venda</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets\js\salesList.js"></script>
</body>
<?php include 'footer.php'; ?>