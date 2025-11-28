<?php

namespace Core;

use Core\Database;
use PDO;
use PDOException;

class BaseModel
{
    protected PDO $db;
    public $table;
    protected array $with = [];
    protected ?string $where = null;
    protected array $cols = ["*"];
    protected array $joins = [];

    public function __construct()
    {
        $this->db = Database::connect();
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function findOne($value, string $column = 'id'): mixed
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE $column = ? LIMIT 1");
            $stmt->execute([$value]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (PDOException $e) {
            return "Database error: " . $e->getMessage();
        }
    }

    public function findAttr(string $columns, ?string $where = null): mixed
    {
        $bindings = [];
        $sqlWhere = '';

        if ($where) {
            preg_match_all('/\$([a-zA-Z_][a-zA-Z0-9_]*)/', $where, $matches);

            foreach ($matches[1] as $var) {
                if (!isset($$var)) {
                    throw new \Exception("Variable \$$var is not defined");
                }
                $bindings[] = $$var;
            }

            $sqlWhere = 'WHERE ' . preg_replace('/\$([a-zA-Z_][a-zA-Z0-9_]*)/', '?', $where);
        }

        try {
            $sql = "SELECT $columns FROM {$this->table} $sqlWhere LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($bindings);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (PDOException $e) {
            return "Database error: " . $e->getMessage();
        }
    }


    public function find(array $cols = ["*"]): self
    {
        $this->cols = $cols;
        return $this;
    }

    public function where(string $where): self
    {
        $this->where = $where;
        return $this;
    }


    public function select(array $cols): self
    {
        $this->cols = $cols;
        return $this;
    }

    public function join(string $table, string $foreignKey, string $localKey = 'id'): self
    {
        $this->joins[] = [
            'table' => $table,
            'foreign' => $foreignKey,
            'local' => $localKey
        ];
        return $this;
    }

    public function with(string $table, string $foreignKey, string $localKey = 'id'): self
    {
        $this->with[] = [
            'table' => $table,
            'foreign' => $foreignKey,
            'local' => $localKey
        ];
        return $this;
    }

    protected function buildQuery(): array
    {
        $columns = implode(', ', $this->cols);
        $sql = "SELECT $columns FROM {$this->table}";
        $bindings = [];

        foreach ($this->joins as $join) {
            $sql .= " LEFT JOIN {$join['table']} ON {$join['table']}.{$join['foreign']} = {$this->table}.{$join['local']}";
        }

        if ($this->where) {
            preg_match_all('/\$([a-zA-Z_][a-zA-Z0-9_]*)/', $this->where, $matches);

            foreach ($matches[1] as $var) {
                if (!isset($$var)) {
                    throw new \Exception("Variable \$$var is not defined");
                }
                $bindings[] = $$var;
            }

            $sqlWhere = preg_replace('/\$([a-zA-Z_][a-zA-Z0-9_]*)/', '?', $this->where);
            $sql .= " WHERE $sqlWhere";
        }

        return [$sql, $bindings];
    }

    public function get(): mixed
    {
        try {
            [$sql, $bindings] = $this->buildQuery();
            $stmt = $this->db->prepare($sql);
            $stmt->execute($bindings);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as &$row) {
                foreach ($this->with as $relation) {
                    $stmtRel = $this->db->prepare(
                        "SELECT * FROM {$relation['table']} WHERE {$relation['foreign']} = ?"
                    );
                    $stmtRel->execute([$row[$relation['local']]]);
                    $row[$relation['table']] = $stmtRel->fetchAll(PDO::FETCH_ASSOC);
                }
            }

            $this->resetState();
            return $rows;
        } catch (PDOException $e) {
            $this->resetState();
            return "Database error: " . $e->getMessage();
        }
    }

    public function first(): mixed
    {
        try {
            [$sql, $bindings] = $this->buildQuery();
            $sql .= " LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($bindings);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                foreach ($this->with as $relation) {
                    $stmtRel = $this->db->prepare(
                        "SELECT * FROM {$relation['table']} WHERE {$relation['foreign']} = ?"
                    );
                    $stmtRel->execute([$row[$relation['local']]]);
                    $row[$relation['table']] = $stmtRel->fetchAll(PDO::FETCH_ASSOC);
                }
            }

            $this->resetState();
            return $row ?: null;
        } catch (PDOException $e) {
            $this->resetState();
            return "Database error: " . $e->getMessage();
        }
    }

    public function findOrCreate(array $search, array $data = []): mixed
    {
        $whereParts = [];

        foreach ($search as $col => $val) {
            $var = "w_$col";
            $$var = $val;
            $whereParts[] = "$col = \$$var";
        }

        $this->where(implode(' AND ', $whereParts));
        $row = $this->first();

        if (is_string($row) && strpos($row, 'Database error:') === 0) {
            return $row;
        }

        if ($row) {
            return (int) $row['id'];
        }

        $res = $this->insert(array_merge($search, $data));

        if (is_string($res) && strpos($res, 'Database error:') === 0) {
            return $res;
        }

        return (int) $res;
    }

    protected function resetState()
    {
        $this->cols = ['*'];
        $this->joins = [];
        $this->with = [];
        $this->where = null;
    }

    public function insert(array $data): mixed
    {
        try {
            $colStr = implode(', ', array_keys($data));
            $num = count($data);
            $placeholders = implode(', ', array_fill(0, $num, '?'));
            $sql = "INSERT INTO {$this->table} ($colStr) VALUES ($placeholders)";
            $stmt = $this->db->prepare($sql);
            $values = array_values($data);
            $stmt->execute($values);
            return (int) $this->db->lastInsertId();
        } catch (PDOException $e) {
            return "Database error: " . $e->getMessage();
        }
    }

    public function insertMany(array $rows): mixed
    {
        if (empty($rows)) {
            throw new \Exception("Rows array cannot be empty");
        }

        try {
            $columns = array_keys($rows[0]);
            $colStr = implode(', ', $columns);

            $values = [];
            foreach ($rows as $row) {
                $values[] = '(' . implode(', ', array_fill(0, count($columns), '?')) . ')';
            }
            $valuesStr = implode(', ', $values);

            $sql = "INSERT INTO {$this->table} ($colStr) VALUES $valuesStr";
            $stmt = $this->db->prepare($sql);

            $allBindings = [];
            foreach ($rows as $row) {
                foreach (array_values($row) as $v) {
                    $allBindings[] = $v;
                }
            }
            $stmt->execute($allBindings);

            return (int) $this->db->lastInsertId();
        } catch (PDOException $e) {
            return "Database error: " . $e->getMessage();
        }
    }

    public function update(int $id, array $data): mixed
    {
        try {
            $setParts = [];
            foreach ($data as $col => $v) {
                $setParts[] = "$col = ?";
            }

            $sql = "UPDATE {$this->table} SET " . implode(', ', $setParts) . " WHERE id = ?";

            $stmt = $this->db->prepare($sql);

            $bindings = array_values($data);
            $bindings[] = $id;

            $stmt->execute($bindings);
            return true;
        } catch (PDOException $e) {
            return "Database error: " . $e->getMessage();
        }
    }

    public function updateWhere(array $data, string $where): mixed
    {
        preg_match_all('/\$([a-zA-Z_][a-zA-Z0-9_]*)/', $where, $matches);

        $whereBindings = [];
        foreach ($matches[1] as $var) {
            if (!isset($$var)) {
                throw new \Exception("Variable \$$var is not defined");
            }
            $whereBindings[] = $$var;
        }

        $sqlWhere = preg_replace('/\$([a-zA-Z_][a-zA-Z0-9_]*)/', '?', $where);

        $setParts = [];
        foreach ($data as $col => $val) {
            $setParts[] = "$col = ?";
        }
        $setBindings = array_values($data);

        $setStr = implode(', ', $setParts);
        $sql = "UPDATE {$this->table} SET $setStr WHERE $sqlWhere";

        $bindings = array_merge($setBindings, $whereBindings);
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($bindings);
        } catch (PDOException $e) {
            return "Database error: " . $e->getMessage();
        }
    }

    public function delete(int $id): mixed
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return "Database error: " . $e->getMessage();
        }
    }

    public function deleteWhere(string $where): mixed
    {
        preg_match_all('/\$([a-zA-Z_][a-zA-Z0-9_]*)/', $where, $matches);

        $bindings = [];
        foreach ($matches[1] as $var) {
            if (!isset($$var)) {
                throw new \Exception("Variable \$$var is not defined");
            }
            $bindings[] = $$var;
        }

        $sqlWhere = preg_replace('/\$([a-zA-Z_][a-zA-Z0-9_]*)/', '?', $where);

        try {
            $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE $sqlWhere");
            return $stmt->execute($bindings);
        } catch (PDOException $e) {
            return "Database error: " . $e->getMessage();
        }
    }
}
