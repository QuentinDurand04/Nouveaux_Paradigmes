<?php
namespace iutnc\hellokant\query;

class Query
{
    private $sqltable;
    private $fields = '*';
    private $where = null;
    private $args = [];
    private $sql = '';

    private function __construct(string $table){
        $this->sqltable = $table;
    }

    public static function table(string $table): Query
    {
        $query = new Query($table);
        return $query;
    }

    public function where(string $col, string $op, mixed $val): Query
    {
        if ($this->where) {
            $this->where .= ' AND ';
        } else {
            $this->where = ' WHERE ';
        }
        $this->where .= "$col $op ?";
        $this->args[] = $val;
        return $this;
    }


    public function get(): array
    {
        $this->sql = 'select ' . $this->fields .
            ' from ' . $this->sqltable;
        /* … */
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute($this->args);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function select(array $fields): Query
    {
        $this->fields = implode(',', $fields);
        return $this;
    }

    public function delete(): int
    {
        $this->sql = 'DELETE FROM ' . $this->sqltable;
        if ($this->where) {
            $this->sql .= $this->where;
        }

        echo $this->sql . "\n";
        print_r($this->args);

        return 0;
    }

    public function insert(array $data): int
    {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $this->sql = 'INSERT INTO ' . $this->sqltable . " ($columns) VALUES ($placeholders)";

        $this->args = array_values($data);

        echo $this->sql . "\n";
        print_r($this->args);

        // Exécution (à connecter plus tard)
        // $stmt = $pdo->prepare($this->sql);
        // $stmt->execute($this->args);
        // return $stmt->rowCount(); // Nombre de lignes insérées
        return 0;
    }



}
