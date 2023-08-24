// Recupera o valor da variável 'valor' da URL
var urlParams = new URLSearchParams(window.location.search);
var saleid = urlParams.get("saleId");
var info = urlParams.get("info");
var itemid = urlParams.get("itemId");

var saleIdField = document.getElementById("saleId");
var saleItemIdField = document.getElementById("saleItemId");
var infoField = document.getElementById("info");
var cadastrarVendaBttn = document.getElementById("cadastrarVendaBttn");
var salesOperation = document.getElementById("salesOperacao");
var quantityField = document.getElementById("quantidade");
var productField = document.getElementById("produto");
var cadastrarProdBttn = document.getElementById("cadastrarProdBttn");
var itensOperation = document.getElementById("itensOperacao");
var produtoCadastroForm = document.getElementById("produtoCadastroForm");
produtoCadastroForm.action = "http://localhost:8080/salesItemsRequests.php?info=" + encodeURIComponent(info);

if (saleid) {
  saleIdField.value = saleid;
  saleItemIdField.value = saleid;
  infoField.value = info;
  infoField.disabled = true;
  cadastrarVendaBttn.disabled = true;
  quantityField.disabled = false;
  productField.disabled = false;
  cadastrarProdBttn.disabled = false;
} else {
  salesOperation.value = "create";
  quantityField.disabled = true;
  productField.disabled = true;
  cadastrarProdBttn.disabled = true;
}

if (itemid) 
{
    itensOperation.value = "update";
}
else
{
    itensOperation.value = "create";
}


function loadTableData2() {
  console.log("Solicitando dados...");
  var xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    "http://localhost:8080/productRequests.php?listAll=true",
    true
  );
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        console.log("Resposta recebida:", xhr.responseText);
        var data = JSON.parse(xhr.responseText);
        console.log("Dados JSON:", data);
        console.log(data);
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
    selectElement.innerHTML = "";

    // Preenche o <select> com as opções do JSON
    data.forEach(function (item) {
      var option = document.createElement("option");
      option.value = item.id; // Valor associado à opção
      option.text = item.prodname; // Texto visível da opção
      selectElement.appendChild(option);
    });
  });
}

// Função para carregar os dados da tabela
function loadTableData() {
    console.log("Solicitando dados...");
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "http://localhost:8080/salesItemsRequests.php?listAll=true&saleId=" + saleid, true);
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

    console.log("fora do each");

    data.forEach(function(row) {
        console.log("dentro do each");

        var newRow = document.createElement("tr");
        newRow.innerHTML = `
        <td><a href="http://localhost:8080/salesItemsRequests.php?id=${row.id}&action=edit"><img src="assets/img/edit.png" width="30" height="30"></a></td>
        <td><a href="http://localhost:8080/salesItemsRequests.php?id=${row.id}&action=delete"><img src="assets/img/delete.png" width="30" height="30"></a></td>
        <td>${row.prodname}</td>
        <td>${row.quantity}</td>
        <td>${row.price}</td>
        <td>${row.taxes}</td>
        <td>${row.taxPrice}</td>
        <td>${row.salePrice}</td>
    `;
        tableBody.appendChild(newRow);
    });
}

// Carregar os dados da tabela ao carregar a página
window.onload = function () {
  loadTableData2();
  loadTableData();
};
