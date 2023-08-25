// Recupera o valor da variável 'valor' da URL
var urlParams = new URLSearchParams(window.location.search);
var saleid = urlParams.get("saleId");
var info = urlParams.get("info");
var itemid = urlParams.get("itemId");

let saleIdField = document.getElementById("saleId");
let saleItemIdField = document.getElementById("saleItemId");
let infoField = document.getElementById("info");
let cadastrarVendaBttn = document.getElementById("cadastrarVendaBttn");
let salesOperation = document.getElementById("salesOperacao");
let quantityField = document.getElementById("quantidade");
let productField = document.getElementById("produto");
let cadastrarProdBttn = document.getElementById("cadastrarProdBttn");
let itensOperation = document.getElementById("itensOperacao");
let produtoCadastroForm = document.getElementById("produtoCadastroForm");
produtoCadastroForm.action =
  `http://localhost:8080/salesItemsRequests.php?info=${info}`;

let endSaleField = document.getElementById("endSale");
let totalTaxField = document.getElementById("totalTax");
let totalSaleField = document.getElementById("totalSale");
let totalTax = 0;
let totalSale = 0;

if (saleid) {
  saleIdField.value = saleid;
  saleItemIdField.value = saleid;
  infoField.value = info;
  infoField.disabled = true;
  cadastrarVendaBttn.disabled = true;
  quantityField.disabled = false;
  productField.disabled = false;
  cadastrarProdBttn.disabled = false;
  endSaleField.hidden = false;
} else {
  salesOperation.value = "create";
  quantityField.disabled = true;
  productField.disabled = true;
  cadastrarProdBttn.disabled = true;
  endSaleField.hidden = true;
}

if (itemid) {
} else {
  itensOperation.value = "create";
}

function cancelSale() 
{
  window.location.href = `http://localhost:8080/salesItemsRequests.php?id=${saleid}&action=deleteAll`;
}

function finishSale()
{
  window.location.href = 'http://localhost/sales.php'
}

function loadTableData2() {
  console.log("Solicitando dados...");
  let xhr = new XMLHttpRequest();
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
  let selectElements = document.querySelectorAll(".form-control");

  // Itera sobre todos os elementos <select>
  selectElements.forEach(function (selectElement) {
    // Limpa todas as opções existentes
    selectElement.innerHTML = "";

    // Preenche o <select> com as opções do JSON
    data.forEach(function (item) {
      let option = document.createElement("option");
      option.value = item.id; // Valor associado à opção
      option.text = item.prodname; // Texto visível da opção
      selectElement.appendChild(option);
    });
  });
}

// Função para carregar os dados da tabela
function loadTableData() {
  console.log("Solicitando dados...");
  let xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    "http://localhost:8080/salesItemsRequests.php?listAll=true&saleId=" +
      saleid,
    true
  );
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        console.log("Resposta recebida:", xhr.responseText);
        let data = JSON.parse(xhr.responseText);
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
  let tableBody = document.getElementById("table-body");
  tableBody.innerHTML = ""; // Limpa a tabela

  data.forEach(function (row) {
    let newRow = document.createElement("tr");
    newRow.innerHTML = `
      <td><a href="http://localhost:8080/salesItemsRequests.php?id=${row.id}&action=delete&saleId=${saleid}&info=${info}"><img src="assets/img/delete.png" width="30" height="30"></a></td>
      <td>${row.prodname}</td>
      <td>${row.quantity}</td>
      <td>${row.price}</td>
      <td>${row.taxes}</td>
      <td>${row.taxPrice}</td>
      <td>${row.salePrice}</td>
    `;
    tableBody.appendChild(newRow);

    totalTax += parseFloat(row.taxPrice);
    totalSale += parseFloat(row.salePrice);
  });

  totalTaxField.innerHTML =
    "Valor Total dos Impostos: R$" + parseFloat(totalTax.toFixed(2));
  totalSaleField.innerHTML =
    "Valor Total da Venda: R$" + parseFloat(totalSale.toFixed(2));
}

// Carregar os dados da tabela ao carregar a página
window.onload = function () {
  loadTableData2();
  loadTableData();
};
