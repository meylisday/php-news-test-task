<?php
namespace App\Core;

abstract class BaseController extends Controller
{
    public function checkAuthentication(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }
    }
}
