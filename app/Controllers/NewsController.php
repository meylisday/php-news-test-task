<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Database\DatabaseConnection;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\Repositories\MySQLNewsRepository;

class NewsController extends Controller
{
    private NewsRepositoryInterface $newsRepository;

    public function __construct() {
        $pdo = DatabaseConnection::init();
        $this->newsRepository = new MySQLNewsRepository($pdo);
    }

    public function createNews($title, $description) {
        $this->newsRepository->createNews($title, $description);
    }

    public function updateNews($id, $title, $description) {
        $this->newsRepository->updateNews($id, $title, $description);
    }

    public function deleteNews($id) {
        $this->newsRepository->deleteNews($id);
    }

    public function getAllNews() {
        return $this->newsRepository->getAllNews();
    }

    public function getNewsById($id) {
        return $this->newsRepository->getNewsById($id);
    }
}