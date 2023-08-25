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

// Função para carregar os dados da tabela
function loadTableData() {
    console.log("Solicitando dados...");
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "http://localhost:8080/controller/productController.php?listAll=true", true);
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
        <td><a href="http://localhost:8080/controller/productController.php?id=${row.id}&action=edit"><img src="assets/img/edit.png" width="30" height="30"></a></td>
        <td><a href="http://localhost:8080/controller/productController.php?id=${row.id}&action=delete"><img src="assets/img/delete.png" width="30" height="30"></a></td>
        <td>${row.id}</td>
        <td>${row.prodname}</td>
        <td>${row.price}</td>
        <td>${row.typeid}</td>
    `;
        tableBody.appendChild(newRow);
    });
}

function loadTableData2() {
    console.log("Solicitando dados...");
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "http://localhost:8080/controller/typeController.php?listAll=true", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log("Resposta recebida:", xhr.responseText);
                var data = JSON.parse(xhr.responseText);
                console.log("Dados JSON:", data);
                setSelectOption(data);
            } else {
                console.log("Erro na solicitação. Status:", xhr.status);
            }
        }
    };
    xhr.send();
}

function setSelectOption(data) {
    // Seleciona todos os elementos <select> com a classe "form-control"
    var selectElements = document.querySelectorAll(".form-control");

    // Itera sobre todos os elementos <select>
    selectElements.forEach(function (selectElement) {
        // Limpa todas as opções existentes
        selectElement.innerHTML = '';

        // Preenche o <select> com as opções do JSON
        data.forEach(function (item) {
            var option = document.createElement("option");
            option.value = item.id; // Valor associado à opção
            option.text = item.info; // Texto visível da opção
            selectElement.appendChild(option);
        });
    });
}


// Carregar os dados da tabela ao carregar a página
window.onload = function() {
    loadTableData();
    loadTableData2();
};