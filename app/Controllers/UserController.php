<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\View;
use App\Repositories\MySQLUserRepository;

class UserController extends BaseController
{
    public function index(): void
    {
        View::renderTemplate('index.html.twig');
    }

    public function login() {
        if (isset($_POST['username']) || isset($_POST['password'])) {
            $mySQLUserRepository = new MySQLUserRepository();
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user = $mySQLUserRepository->getUserByUsername($username);

            if ($user && $password === $user->getPassword()) {
                session_start();
                $_SESSION['user_id'] = $user->getId();

                header('Location: /news');
                exit();
            } else {
                echo 'Error';
                View::renderTemplate('index.html.twig');
            }
        }
        View::renderTemplate('index.html.twig');
    }

    public function logout() {
        session_start();
        unset($_SESSION['user_id']);
        session_destroy();

        header('Location: /');
        exit;
    }
}