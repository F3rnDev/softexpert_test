<?php
    $host = "postgres";
    $user = "postgres";
    $password = "postgres";
    $dbname = "postgres";
    $port = "5432";
    
    // Conectar ao banco de dados
    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
    
    if (!$conn) {
        echo "Connection error";
        exit;
    }

    //Querries
    $queryProducts = "CREATE TABLE products (
        id serial PRIMARY KEY,
        prodName VARCHAR(100),
        price FLOAT,
        typeId INT
    )";

    $queryType = "CREATE TABLE prodType (
        id serial PRIMARY KEY,
        info VARCHAR(255),
        taxes INT
    )";

    $querySales = "CREATE TABLE sales (
        id serial PRIMARY KEY,
        saleTime timestamp,
        info VARCHAR(255)
    )";

    $queryItem = "CREATE TABLE salesItem (
        id serial PRIMARY KEY,
        prodId INT,
        quantity INT,
        saleId INT
    )";
    
    function createTable($currQuerry, $name, $connection)
    {
        $result = pg_query($connection, $currQuerry);
    
        if ($result) {
            echo "Table $name was created sucessfully.";
        } else {
            echo "Error when creating the table $name: " . pg_last_error($connection);
        }

        echo "</br>";
    }

    createTable($queryProducts, "products", $conn);
    createTable($queryType, "types", $conn);
    createTable($querySales, "sales", $conn);
    createTable($queryItem, "sale items", $conn);
?>
