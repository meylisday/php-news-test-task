<?php

namespace App\Controllers;


use App\Core\BaseController;
use App\Core\View;
use App\Repositories\MySQLNewsRepository;

class NewsController extends BaseController
{
    public function create()
    {
        $this->checkAuthentication();

        $title = $_POST['title'];
        $description = $_POST['description'];

        if (empty($title) || empty($description)) {
            //error
        } else {
            $newsRepository = new MySQLNewsRepository();
            $newsRepository->createNews($title, $description);
            header('Location: /news');
            exit;
        }
    }

    public function update($id, $title, $description)
    {
        (new MySQLNewsRepository())->updateNews($id, $title, $description);
    }

    public function delete(int $id)
    {
        $this->checkAuthentication();
        if (empty($id)) {
            //error
        } else {
            $newsRepository = new MySQLNewsRepository();
            $newsRepository->deleteNews($id);

            header('Location: /news');
            exit;
        }
    }

    public function index()
    {
        $this->checkAuthentication();

        $newsRepository = new MySQLNewsRepository();
        $news = $newsRepository->getAllNews();

        View::renderTemplate('news.html.twig', ['news' => $news]);
    }

    public function getNewsById($id)
    {
        return (new MySQLNewsRepository())->getNewsById($id);
    }
}