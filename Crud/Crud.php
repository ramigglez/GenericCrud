<?php

class Crud {

    protected string $table;
    protected PDO $connection;
    protected string $where;
    protected string $sql;

    public function __construct (string $table = null) {
        $this->where = '';
        #$this->connection = (new Connection())->connect();
        $this->table = $table;
    }

    public function setConnection (PDO $data) {
        $this->connection = $data;
    }

    public function get () {
        try {
            $query = new Strings("SELECT * FROM {$this->table} {$this->where}");
            $this->sql = $query->getTxt();
            $transaction = $this->connection->prepare($this->sql);
            $transaction->execute();
            return $transaction->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            $error = new Strings(
                '<br>ERROR : <br><pre>'
                .$e->getTraceAsString().
                '</pre>'
            );
            echo $error->getTxt();
        }
    }

    public function first () {
        $list = $this->get();
        if (count($list) > 0) {
            return $list[0];
        } else {
            return null;
        }
    }

    public function insert ($obj) {
        try {
            $fields = implode("`, `",array_keys($obj));
            $values = ":" . implode(", :",array_keys($obj));
            $query = new Strings("INSERT INTO {$this->table} (`{$fields}`) VALUES ({$values})");
            $this->sql = $query->getTxt();
            $this->exeSql($obj);
            $id = $this->connection->lastInsertId();
            return $id;
        } catch (Exception $e) {
            $error = new Strings(
                '<br>ERROR : <br><pre>'
                .$e->getTraceAsString().
                '</pre>'
            );
            echo $error->getTxt();
        }
    }

    private function exeSql ($obj = null) {
        $statement = $this->connection->prepare($this->sql);
        if ($obj !== null) {
            foreach ($obj as $key => $value) {
                if (empty($value)) {
                    $value = null;
                }
                $statement->bindValue(":$key",$value);
            }
        }
        $statement->execute();
        $this->resetValues();
        return $statement->rowCount();
    }

    private function resetValues () {
        $this->where = "";
        $this->sql = "";
    }

    public function update ($obj) {
        try {
            $fields = "";
            foreach ($obj as $key => $value) {
                $fields .= "`$key`=:$key,";
            }
            $fields = rtrim($fields,",");
            $query = new Strings ("UPDATE {$this->table} SET {$fields} {$this->where}");
            $this->sql = $query->getTxt();
            $rows = $this->exeSql($obj);
            return $rows;
        } catch (Exception $e) {
            $error = new Strings(
                '<br>ERROR : <br><pre>'
                .$e->getTraceAsString().
                '</pre>'
            );
            echo $error->getTxt();
        }
    }

    public function delete () {
        try {
            $query = new Strings ("DELETE FROM {$this->table} {$this->where}");
            $this->sql = $query->getTxt();
            $rows = $this->exeSql();
            return $rows;
        } catch (Exception $e) {
            $error = new Strings(
                '<br>ERROR : <br><pre>'
                .$e->getTraceAsString().
                '</pre>'
            );
            echo $error->getTxt();
        }
    }

    public function where ($key, $condition, $value) {
        $this->where .= (strpos($this->where, "WHERE")) ? " AND " : " WHERE ";
        $this->where .= "`$key` $condition " . ((is_string($value)) ? "\"$value\"" : $value) . " ";
        return $this;
    }

    public function orWhere ($key, $condition, $value) {
        $this->where .= (strpos($this->where, "WHERE")) ? " OR " : " WHERE ";
        $this->where .= "`$key` $condition " . ((is_string($value)) ? "\"$value\"" : $value) . " ";
        return $this;
    }

}