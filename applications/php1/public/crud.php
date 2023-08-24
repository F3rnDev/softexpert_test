<?php

class Crud
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function create($table, array $fields, array $values)
    {
        try {
            $query = "INSERT INTO $table (" . $this->addValuesToQuery($fields, "create") . "VALUES (" . $this->addValuesToQuery($fields, "create", ":");
            $stmt = $this->connection->prepare($query);

            for ($curr = 0; $curr < count($values); $curr++) {
                $stmt->bindParam(':' . $fields[$curr], $values[$curr]);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao cadastrar o produto: " . $e->getMessage();
            return false;
        }
    }

    public function createAndReturnId($table, array $fields, array $values)
    {
        try {
            $query = "INSERT INTO $table (" . $this->addValuesToQuery($fields, "create") . "VALUES (" . $this->addValuesToQuery($fields, "create", ":")." RETURNING id";
            $stmt = $this->connection->prepare($query);

            for ($curr = 0; $curr < count($values); $curr++) {
                $stmt->bindParam(':' . $fields[$curr], $values[$curr]);
            }

            return [$stmt->execute(), $stmt->fetch(PDO::FETCH_ASSOC)['id']];
        } catch (PDOException $e) {
            echo "Erro ao cadastrar o produto: " . $e->getMessage();
            return false;
        }
    }

    public function delete($table, $id)
    {
        try {
            $query = "DELETE FROM $table WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao deletar o produto: " . $e->getMessage();
            return false;
        }
    }

    public function update($table, array $fields, array $values, $id)
    {
        try {
            $query = "UPDATE $table SET ".$this->addValuesToQuery($fields, "update", ":") ." WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);

            for ($curr = 0; $curr < count($values); $curr++) {
                $stmt->bindParam(':' . $fields[$curr], $values[$curr]);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao alterar o produto: " . $e->getMessage();
            return false;
        }
    }

    public function read($table)
    {
        try {
            $query = "SELECT * FROM $table";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao ler os produtos: " . $e->getMessage();
            var_dump($e->getMessage());
            return false;
        }
    }

    public function readByID($table, $id)
    {
        try {
            $query = "SELECT * FROM $table WHERE id=:id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao ler os produtos: " . $e->getMessage();
            var_dump($e->getMessage());
            return false;
        }
    }

    public function readByField($table, $field, $value)
    {
        try {
            $query = "SELECT * FROM $table WHERE $field=:$field";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(":$field", $value);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao ler os produtos: " . $e->getMessage();
            var_dump($e->getMessage());
            return false;
        }
    }

    private function addValuesToQuery(array $keys, $action, $extra = "")
    {
        $valueToAdd = "";
        $keyLength = count($keys);

        if($action === "create")
        {
            for ($curr = 0; $curr < $keyLength; $curr++) {
                $valueToAdd .= $extra . $keys[$curr];
                if ($curr === $keyLength - 1) {
                    $valueToAdd .= ") ";
                } else {
                    $valueToAdd .= ",";
                }
            }
        }
        else
        {
            for ($curr = 0; $curr < $keyLength; $curr++) 
            {   
                $valueToAdd .= $keys[$curr] . " = " . $extra . $keys[$curr];
                if ($curr !== $keyLength - 1) {
                    $valueToAdd .= ",";
                }
            }
        }
        

        return $valueToAdd;
    }
}
