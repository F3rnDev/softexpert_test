<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: DNT,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Range");
header("Access-Control-Expose-Headers: Content-Length,Content-Range");

require 'connection.php';
require 'crud.php';

$crud = new Crud($connection);

//  Criar na base de dados tabela product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['itensOperacao'] === 'create') {
        $product = $_POST['produto'];
        $quantity = $_POST['quantidade'];
        $saleId = $_POST['saleItemId'];
        $info = $_GET['info'];

        $resultado = $crud->create('salesitem', ["prodid", "quantity", "saleid"], [$product, $quantity, $saleId]);

        if ($resultado) {
            header("Location: http://localhost/sales.php?saleId=$saleId&info=$info");
        } else {
            echo "Erro ao cadastrar o produto.";
        }
    }
}


if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    if ($action === 'delete') {
        $resultado = $crud->delete("products", $id);
        header("Location: http://localhost/product.php");
    } else {
        $resultado = $crud->readByID("products", $id);
        $id = $resultado['id'];
        $name = $resultado['prodname'];
        $price = $resultado['price'];
        $type = $resultado['typeid'];

        header("Location: http://localhost/product.php?id=$id&name=$name&price=$price&type=$type");
    }
}

if (isset($_GET['listAll'])) {
    $id = $_GET['saleId'];

    $result = $crud->readByField("salesItem", "saleid", $id);

    $cart = [];

    for ($curr = 0; $curr < count($result); $curr++) {
        $product = $crud->readByField("products", "id", $result[$curr]["prodid"]);
        $type = $crud->readByField("prodtype", "id", $product[0]["typeid"]);
        $salePrice = number_format($product[0]['price'] * $result[$curr]['quantity'], 2, '.', '');
        $taxPrice = number_format(($salePrice * $type[0]['taxes']) / 100, 2, '.', '');

        $items = array(
            "prodname" => $product[0]['prodname'],
            "quantity" => $result[$curr]['quantity'],
            "price" => $product[0]['price'],
            "taxes" => $type[0]['taxes'],
            "taxPrice" => $taxPrice,
            "salePrice" => $salePrice
        );

        array_push($cart, $items);
    }

    header('Content-Type: application/json');
    echo json_encode($cart);
}