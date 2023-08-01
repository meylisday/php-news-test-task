<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Repositories\MySQLUserRepository;

class UserController extends Controller
{
    public function login() {
        if (isset($data['username']) || isset($data['password'])) {
            $mySQLUserRepository = new MySQLUserRepository();
            $username = $data['username'];
            $password = $data['password'];
            $user = $mySQLUserRepository->getUserByUsername($username);

            if ($user && password_verify($password, $user->getPassword())) {
                session_start();
                $_SESSION['user_id'] = $user->getId();
                return ['status' => 'success'];
            }
            return ['status' => 'error', 'message' => 'Login failed.'];
        }
        View::renderTemplate('index.html');
    }

    public function logout() {
        session_start();
        unset($_SESSION['user_id']);
        session_destroy();
        return ['status' => 'success'];
    }
}