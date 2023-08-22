    // Recupera o valor da variável 'valor' da URL
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');
    var info = urlParams.get('info');
    var taxes = urlParams.get('taxes');

    // Define o valor padrão no campo de entrada
    var campoInfo = document.getElementById('info');
    var campoTaxes = document.getElementById('taxes');
    var typeCadastroForm = document.getElementById('typeCadastroForm');
    var bttn = document.getElementById('cadastrarTypeBttn');
    var operation = document.getElementById('operacao');
    var docId = document.getElementById('identificador');

    if (id) {
        bttn.innerHTML = 'Atualizar Tipo';
        campoInfo.value = info;
        campoTaxes.value = taxes;
        operation.value = 'update';
        docId.value = id;
    } else {
        bttn.innerHTML = 'Cadastrar Tipo';
        operation.value = 'create';
    }

    // Função para carregar os dados da tabela
function loadTableData() {
    console.log("Solicitando dados...");
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "http://localhost:8080/typeRequests.php?listAll=true", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log("Resposta recebida:", xhr.responseText);
                var data = JSON.parse(xhr.responseText);
                console.log("Dados JSON:", data);
                updateTable(data);
            } else {
                console.log("Erro na solicitação. Status:", xhr.status);
            }
        }
    };
    xhr.send();
}

// Função para atualizar a tabela com os dados obtidos
function updateTable(data) {
    var tableBody = document.getElementById("table-body");
    tableBody.innerHTML = ""; // Limpa a tabela

    data.forEach(function(row) {
        var newRow = document.createElement("tr");
        newRow.innerHTML = `
        <td><a href="http://localhost:8080/typeRequests.php?id=${row.id}&action=edit"><img src="assets/img/edit.png" width="30" height="30"></a></td>
        <td><a href="http://localhost:8080/typeRequests.php?id=${row.id}&action=delete"><img src="assets/img/delete.png" width="30" height="30"></a></td>
        <td>${row.id}</td>
        <td>${row.info}</td>
        <td>${row.taxes}</td>
    `;
        tableBody.appendChild(newRow);
    });
}

// Carregar os dados da tabela ao carregar a página
window.onload = function() {
    loadTableData();
};