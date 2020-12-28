<?php

namespace App\Models\Db;

use PDO;
use PDOException;

class Db {
    private $pdo;

    private $sql = '';
    private $wheres = [];
    private $bindings = [];

    protected $table = '';

    public function __construct()
    {
        $this->pdo = new PDO("sqlite:".__DIR__."/../../../database.sql");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function getAll()
    {
        return $this->query("SELECT * FROM ". $this->table)->get()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        return $this->query("SELECT * FROM ". $this->table)
            ->where('id', '=', $id)
            ->get()
            ->fetch(PDO::FETCH_ASSOC);
    }

    public function getBy($col, $value)
    {
        return $this->query("SELECT * FROM ". $this->table)
            ->where($col, '=', $value)
            ->get()
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function query($sql)
    {
        $this->sql = $sql;
        return $this;
    }

    public function get()
    {
        $sql = $this->prepareSql();

        $stm = $this->pdo->prepare($sql);

        $stm = $this->prepareBindings($stm);

        $stm->execute();

        $this->clear();

        return $stm;
    }

    public function where($col, $operator, $value)
    {
        $this->wheres[] = $col .' '. $operator .' ? ';
        $this->bindings[] = $value;
        return $this;
    }

    private function prepareSql()
    {
        $sql = $this->sql;

        if(count($this->wheres)) {
            $sql .= ' WHERE '. implode(' AND ', $this->wheres);
        }

        return $sql;
    }

    private function prepareBindings($stm)
    {
        if(count($this->wheres)) {
            foreach ($this->bindings as $param) {
                $stm->bindValue(1, $param);
            }
        }

        return $stm;
    }

    private function clear()
    {
        $this->sql = '';
        $this->wheres = [];
        $this->bindings = [];
    }
}