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
    if ($_POST['operacao'] === 'create') 
    {
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $tipo = $_POST['tipo'];

        echo "nome: $nome";
        echo "tipo: $tipo";
    
        $resultado = $crud->create('products', ["prodname", "price", "typeid"], [$nome, $preco, $tipo]);
    
        if ($resultado) {
            header("Location: http://localhost/product.php");
        } else {
            echo "Erro ao cadastrar o produto.";
        }
    }
    else
    {
        $id = $_POST['identificador'];
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $tipo = $_POST['tipo'];
    
        $resultado = $crud->update('products', ["prodname", "price", "typeid"], [$nome, $preco, $tipo], $id);
    
        if ($resultado) {
            header("Location: http://localhost/product.php");
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
    elseif($action === 'update')
    {


        header("Location: http://localhost/product.php?id=$id&name=$name&price=$price&type=$type");
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
