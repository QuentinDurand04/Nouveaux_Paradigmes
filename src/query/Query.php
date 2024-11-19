<?php
namespace iutnc\hellokant\query;

use iutnc\hellokant\ConnectionFactory;
use PDO;
use PDOException;

class Query
{
    private string $sqltable;
    private string $fields = '*';
    private ?string $where = null;
    private array $args = [];
    private string $sql = '';

    private function __construct(string $table)
    {
        $this->sqltable = $table;
    }

    public static function table(string $table): Query
    {
        return new Query($table);
    }

    public function where(string $col, string $op, $val): Query
    {
        if (!is_null($this->where)) {
            $this->where .= ' AND ';
        } else {
            $this->where = '';
        }
        $this->where .= " $col $op ? ";
        $this->args[] = $val;
        return $this;
    }

    public function orWhere(string $col, string $op, $val): Query
    {
        if (!is_null($this->where)) {
            $this->where .= ' OR ';
        } else {
            $this->where = '';
        }
        $this->where .= " $col $op ? ";
        $this->args[] = $val;
        return $this;
    }

    public function get(): array
    {
        $this->sql = 'SELECT ' . $this->fields . ' FROM ' . $this->sqltable;

        if (!is_null($this->where)) {
            $this->sql .= ' WHERE ' . $this->where;
        }

        $pdo = ConnectionFactory::getConnection();
        $stmt = $pdo->prepare($this->sql);

        try {
            $stmt->execute($this->args);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Erreur lors de l'exécution de la requête SELECT : " . $e->getMessage());
        }
    }

    public function select(array $fields): Query
    {
        $this->fields = implode(',', $fields);
        return $this;
    }

    public function delete(): int
    {
        $this->sql = 'DELETE FROM ' . $this->sqltable;

        if (!is_null($this->where)) {
            $this->sql .= ' WHERE ' . $this->where;
        }

        $pdo = ConnectionFactory::getConnection();
        $stmt = $pdo->prepare($this->sql);

        try {
            $stmt->execute($this->args);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new PDOException("Erreur lors de l'exécution de la requête DELETE : " . $e->getMessage());
        }
    }

    public function insert(array $data): int
    {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $this->sql = "INSERT INTO {$this->sqltable} ($columns) VALUES ($placeholders)";
        $this->args = array_values($data);

        $pdo = ConnectionFactory::getConnection();
        $stmt = $pdo->prepare($this->sql);

        try {
            $stmt->execute($this->args);
            return (int)$pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new PDOException("Erreur lors de l'exécution de la requête INSERT : " . $e->getMessage());
        }
    }
}

