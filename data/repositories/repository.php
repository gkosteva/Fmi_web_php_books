<?php

namespace repositories;

require __DIR__ . '/../../data/database.php';

use Database;
use PDO;

class Repository
  {
    protected Database $database;
    protected string $tableName;

    public function __construct($tableName)
    {
      $this->database = new Database();
      $this->tableName = $tableName;
    }

    public function __destruct()
    {
      $this->database->close();
    }

    public function getAll(): false|array
    {
      $command = 'SELECT * FROM ' . $this->tableName;
      $query = $this->database->getConnection()->prepare($command);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchPDFs($query) {
      $stmt = $this->database->getConnection()->prepare("SELECT * FROM pdfs WHERE title LIKE ? OR descript LIKE ?");
      $searchTerm = '%' . $query . '%';
      $stmt->execute([$searchTerm, $searchTerm]);
      return $stmt->fetchAll();
  }
  
    public function filter(Array $data, $operator = "&&")
    {
        $columns = array_keys($data);
        $placeholders = array_map(function($value) {
            return "$value=?";
        }, $columns);

        $valuesPlaceholders = implode($operator, $placeholders);

        $command = "SELECT * FROM $this->tableName WHERE $valuesPlaceholders";
        $query = $this->database->getConnection()->prepare($command);

        $index = 1;
        foreach ($data as $key => $value) {
            $query->bindValue($index++, $value);
        }

        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data): bool|object
    {
      $columns = array_keys($data);
      $placeholders = array_map(function ($value) {
        return "?";
      }, $columns);

      $valuesPlaceholders = implode(", ", $placeholders);
      $columnsAsString = implode(", ", $columns);
      $command = "INSERT INTO $this->tableName ($columnsAsString) VALUES ($valuesPlaceholders)";
      $query = $this->database->getConnection()->prepare($command);

      $index = 0;
      foreach ($data as $key => $value) {
        $index++;
        $query->bindValue($index, $value);
      }

      return $query->execute();
    }

    public function update($id, $data): bool
    {
      $columns = array_keys($data);
      $placeholders = array_map(function ($value) {
        return "$value=?";
      }, $columns);

      $valuesPlaceholders = implode(", ", $placeholders);
      $command = "UPDATE $this->tableName SET $valuesPlaceholders WHERE id=?";
      $query = $this->database->getConnection()->prepare($command);

      $index = 1;
      foreach ($data as $key => $value) {
        $query->bindValue($index++, $value);
      }

      $query->bindValue($index, $id);

      return $query->execute();
    }

    public function select($data, $operator = "&&"): false|array
    {
      $columns = array_keys($data);
      $placeholders = array_map(function ($value) {
        return "$value=?";
      }, $columns);

      $valuesPlaceholders = implode($operator, $placeholders);

      $command = "SELECT * FROM $this->tableName WHERE $valuesPlaceholders";
      $query = $this->database->getConnection()->prepare($command);

      $index = 1;
      foreach ($data as $key => $value) {
        $query->bindValue($index++, $value);
      }

      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLastInsertId(): int
    {
      return $this->database->getConnection()->lastInsertId();
    }

  //   public function delete($conditions): bool {
  //     $placeholders = [];
  //     $values = [];
  //     foreach ($conditions as $column => $value) {
  //         $placeholders[] = "$column = ?";
  //         $values[] = $value;
  //     }
  //     $placeholders = implode(' AND ', $placeholders);
  //     $sql = "DELETE FROM $this->tableName WHERE $placeholders";
  //     $stmt = $this->database->getConnection()->prepare($sql);
      
  //     return $stmt->execute($values);
  // }
}