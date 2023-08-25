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
        $info = $_POST['info'];
        $taxes = $_POST['taxes'];
    
        $resultado = $crud->create('prodtype', ["info", "taxes"], [$info, $taxes]);
    
        if ($resultado) {
            header("Location: http://localhost/type.php");
        } else {
            echo "Erro ao cadastrar o produto.";
        }
    }
    else
    {
        $id = $_POST['identificador'];
        $info = $_POST['info'];
        $taxes = $_POST['taxes'];
    
        $resultado = $crud->update('prodtype', ["info", "taxes"], [$info, $taxes], $id);
    
        if ($resultado) {
            header("Location: http://localhost/type.php");
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
        $resultado = $crud->delete("prodtype", 'id', $id);
        header("Location: http://localhost/type.php");
    }
    elseif($action === 'update')
    {


        header("Location: http://localhost/type.php?id=$id&info=$info&taxes=$taxes");
    }
    else
    {
        $resultado = $crud->readByID("prodtype", $id);
        $id = $resultado['id'];
        $info = $resultado['info'];
        $taxes = $resultado['taxes'];

        header("Location: http://localhost/type.php?id=$id&info=$info&taxes=$taxes");
    }

}

if (isset($_GET['listAll']))
{
    $result = $crud->read("prodtype");

    echo json_encode($result);
}
