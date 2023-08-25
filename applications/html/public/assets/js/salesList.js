let urlParams = new URLSearchParams(window.location.search);
let saleid = urlParams.get("saleId");

let venda = document.getElementById("venda");

let totalTaxField = document.getElementById("totalTax");
let totalSaleField = document.getElementById("totalSale");

let totalTax = 0;
let totalSale = 0;

let endSale = document.getElementById("endSale");

if(saleid)
{
  endSale.hidden = false;
}
else
{
  endSale.hidden = true;
}

function deleteSale() 
{
  window.location.href = `http://localhost:8080/controller/salesItemsController.php?id=${saleid}&action=deleteAll&deleteFromListing=true`;
}

function loadTableData() {
  console.log("Solicitando dados...");
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "http://localhost:8080/controller/salesItemsController.php?listAll=true&saleId=" + saleid, true);
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

function loadTableData2() {
  console.log("Solicitando dados...");
  let xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    "http://localhost:8080/controller/salesController.php?listAll=true",
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
      option.text = item.info; // Texto visível da opção
      selectElement.appendChild(option);
    });

    venda.value = saleid;
  });
}

// Carregar os dados da tabela ao carregar a página
window.onload = function () {
  loadTableData2();
  loadTableData();
};
