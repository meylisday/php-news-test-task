<?php

namespace App\Repositories;

use App\Core\Model;
use PDO;
use PDOException;

class MySQLNewsRepository extends Model
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = static::getDB();
    }

    public function createNews($title, $description)
    {
        try {
            $query = "INSERT INTO news (title, description) VALUES (:title, :description)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['title' => $title, 'description' => $description]);
            return $this->getNewsById($this->pdo->lastInsertId());
        } catch (PDOException $e) {
            die("Error creating news: " . $e->getMessage());
        }
    }

    public function updateNews($id, $title, $description)
    {
        try {
            $query = "UPDATE news SET title = :title, description = :description WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id' => $id, 'title' => $title, 'description' => $description]);
            return $this->getNewsById($id);
        } catch (PDOException $e) {
            die("Error updating news: " . $e->getMessage());
        }
    }

    public function deleteNews($id)
    {
        try {
            $query = "DELETE FROM news WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            die("Error deleting news: " . $e->getMessage());
        }
    }

    public function getAllNews(): array
    {
        try {
            $query = "SELECT * FROM news";
            return $this->pdo->query($query)->fetchAll();
        } catch (PDOException $e) {
            die("Error fetching all news: " . $e->getMessage());
        }
    }

    public function getNewsById($id)
    {
        try {
            $query = "SELECT * FROM news WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            die("Error fetching news by id: " . $e->getMessage());
        }
    }
}