<?php

namespace Core;

use Core\Database;
use PDO;

class BaseModel
{
    protected PDO $db;
    protected array $with = [];
    protected ?string $where = null;
    protected array $cols = [];
    public $table;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function findOne($value, string $column = 'id'): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE $column = :val LIMIT 1");
        $stmt->execute(['val' => $value]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function find(?string $where = null, ?array $cols = null): array
    {
        $columns = $cols ? implode(', ', $cols) : '*';
        $bindings = [];
        $sqlWhere = '';

        if ($where) {
            preg_match_all('/\$([a-zA-Z_][a-zA-Z0-9_]*)/', $where, $matches);

            foreach ($matches[1] as $var) {
                if (!isset($$var)) {
                    throw new \Exception("Variable \$$var is not defined");
                }
                $bindings[":$var"] = $$var;
            }

            $sqlWhere = 'WHERE ' . preg_replace('/\$([a-zA-Z_][a-zA-Z0-9_]*)/', ':$1', $where);
        }

        $sql = "SELECT $columns FROM {$this->table} $sqlWhere";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($bindings);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function findAttr(string $columns, ?string $where = null): ?array
    {
        $bindings = [];
        $sqlWhere = '';

        if ($where) {
            preg_match_all('/\$([a-zA-Z_][a-zA-Z0-9_]*)/', $where, $matches);

            foreach ($matches[1] as $var) {
                if (!isset($$var)) {
                    throw new \Exception("Variable \$$var is not defined");
                }
                $bindings[":$var"] = $$var;
            }

            $sqlWhere = 'WHERE ' . preg_replace('/\$([a-zA-Z_][a-zA-Z0-9_]*)/', ':$1', $where);
        }

        $sql = "SELECT $columns FROM {$this->table} $sqlWhere LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($bindings);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function get(?string $where = null, ?array $cols = null): self
    {
        $this->where = $where;
        $this->cols = $cols ?? ['*'];
        $this->with = [];
        return $this;
    }

    public function with(string $relationTable, string $foreignKey, string $localKey = 'id'): self
    {
        $this->with[] = [
            'table' => $relationTable,
            'foreign' => $foreignKey,
            'local' => $localKey
        ];
        return $this;
    }

    public function go(): array
    {
        $columns = implode(', ', $this->cols);
        $sql = "SELECT $columns FROM {$this->table}";
        $bindings = [];

        if ($this->where) {
            preg_match_all('/\$([a-zA-Z_][a-zA-Z0-9_]*)/', $this->where, $matches);
            foreach ($matches[1] as $var) {
                if (!isset($$var)) {
                    throw new \Exception("Variable \$$var is not defined");
                }
                $bindings[":$var"] = $$var;
            }
            $sqlWhere = preg_replace('/\$([a-zA-Z_][a-zA-Z0-9_]*)/', ':$1', $this->where);
            $sql .= " WHERE $sqlWhere";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($bindings);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Eager load relations
        foreach ($rows as &$row) {
            foreach ($this->with as $relation) {
                $stmtRel = $this->db->prepare(
                    "SELECT * FROM {$relation['table']} WHERE {$relation['foreign']} = :val"
                );
                $stmtRel->execute([':val' => $row[$relation['local']]]);
                $row[$relation['table']] = $stmtRel->fetchAll(PDO::FETCH_ASSOC);
            }
        }

        // Reset state
        $this->with = [];
        $this->where = null;
        $this->cols = [];

        return $rows;
    }


    public function insert(array $data): int
    {
        if (empty($data)) {
            throw new \Exception("Data array cannot be empty");
        }

        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $stmt = $this->db->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();

        return (int) $this->db->lastInsertId();
    }

    public function insertMany(array $rows): int
    {
        if (empty($rows)) {
            throw new \Exception("Rows array cannot be empty");
        }

        $columns = array_keys($rows[0]);
        $columnsStr = implode(', ', $columns);

        $placeholdersArr = [];
        $bindings = [];

        foreach ($rows as $i => $row) {
            $placeholders = [];
            foreach ($columns as $col) {
                $param = ":{$col}_{$i}";
                $placeholders[] = $param;
                $bindings[$param] = $row[$col];
            }
            $placeholdersArr[] = '(' . implode(', ', $placeholders) . ')';
        }

        $placeholdersStr = implode(', ', $placeholdersArr);

        $sql = "INSERT INTO {$this->table} ($columnsStr) VALUES $placeholdersStr";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($bindings);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        if (empty($data)) {
            throw new \Exception("Data array cannot be empty");
        }

        $setParts = [];
        foreach ($data as $col => $value) {
            $setParts[] = "$col = :$col";
        }
        $setStr = implode(', ', $setParts);

        $stmt = $this->db->prepare("UPDATE {$this->table} SET $setStr WHERE id = :id");
        $stmt->bindValue(':id', $id);

        foreach ($data as $col => $value) {
            $stmt->bindValue(":$col", $value);
        }

        return $stmt->execute();
    }

    public function updateWhere(array $data, string $where): bool
    {
        if (empty($data)) {
            throw new \Exception("Data array cannot be empty");
        }

        preg_match_all('/\$([a-zA-Z_][a-zA-Z0-9_]*)/', $where, $matches);
        $bindings = [];

        foreach ($matches[1] as $var) {
            if (!isset($$var)) {
                throw new \Exception("Variable \$$var is not defined");
            }
            $bindings[":$var"] = $$var;
        }

        $sqlWhere = preg_replace('/\$([a-zA-Z_][a-zA-Z0-9_]*)/', ':$1', $where);
        $setParts = [];
        foreach ($data as $col => $value) {
            $setParts[] = "$col = :set_$col";
            $bindings[":set_$col"] = $value;
        }
        $setStr = implode(', ', $setParts);

        $sql = "UPDATE {$this->table} SET $setStr WHERE $sqlWhere";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($bindings);
    }
}
