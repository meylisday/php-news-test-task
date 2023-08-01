<?php

namespace App\Repositories;

use App\Core\Model;
use App\Models\User;
use PDO;
use PDOException;

class MySQLUserRepository extends Model
{
    private PDO $pdo;

    public function __construct() {
        $this->pdo = static::getDB();
    }

    public function getUserByUsername($username) {
        try {
            $query = "SELECT * FROM users WHERE username = :username";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['username' => $username]);
            $userData = $stmt->fetch();
            if ($userData) {
                return new User($userData['id'], $userData['username'], $userData['password']);
            }
            return null;
        } catch (PDOException $e) {
            die("Error fetching user by username: " . $e->getMessage());
        }
    }
}