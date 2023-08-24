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
    if ($_POST['salesOperacao'] === 'create') 
    {
        $info = $_POST['info'];
    
        $resultado = $crud->createAndReturnId('sales', ["info"], [$info]);
    
        if ($resultado[0]) {
            header("Location: http://localhost/sales.php?saleId=". $resultado[1] ."&info=$info");
        } else {
            echo "Erro ao cadastrar o produto.";
        }
    }
}


if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    if($action === 'delete')
    {
        $resultado = $crud->delete("products", $id);
        header("Location: http://localhost/product.php");
    }
    else
    {
        $resultado = $crud->readByID("products", $id);
        $id = $resultado['id'];
        $name = $resultado['prodname'];
        $price = $resultado['price'];
        $type = $resultado['typeid'];

        header("Location: http://localhost/product.php?id=$id&name=$name&price=$price&type=$type");
    }

}

if (isset($_GET['listAll']))
{
    $result = $crud->read("products");
    header('Content-Type: application/json');
    echo json_encode($result);
}
