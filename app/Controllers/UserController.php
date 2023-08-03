<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\View;
use App\Repositories\MySQLUserRepository;
use JsonException;

class UserController extends BaseController
{
    public function index(): void
    {
        View::renderTemplate('index.html.twig');
    }

    /**
     * @throws JsonException
     */
    public function login()
    {
        if (!isset($_POST['username'], $_POST['password'])) {
            return json_encode(['status' => 'error', 'message' => 'Invalid input data'], JSON_THROW_ON_ERROR);
        }

        $mySQLUserRepository = new MySQLUserRepository();
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = $mySQLUserRepository->getUserByUsername($username);

        if (!$user) {
            return json_encode(['status' => 'error', 'message' => 'Wrong login data!'], JSON_THROW_ON_ERROR);
        }

        if (!password_verify($password, $user->getPassword())) {
            return json_encode(['status' => 'error', 'message' => 'Wrong login data!'], JSON_THROW_ON_ERROR);
        }

        session_start();
        $_SESSION['user_id'] = $user->getId();

        return json_encode(['status' => 'success'], JSON_THROW_ON_ERROR);
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['user_id']);
        session_destroy();

        header('Location: /');
        exit;
    }
}