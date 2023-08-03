<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\View;
use App\Repositories\MySQLNewsRepository;
use JsonException;

class NewsController extends BaseController
{
    /**
     * @throws JsonException
     */
    public function create()
    {
        $this->checkAuthentication();

        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';

        if (empty($title) || empty($description)) {
            return json_encode(['status' => 'error', 'message' => 'Error creating news'], JSON_THROW_ON_ERROR);
        }

        $title = trim($title);
        $description = trim($description);

        if (strlen($title) > 255 || strlen($description) > 1000) {
            return json_encode(['status' => 'error', 'message' => 'Invalid input data'], JSON_THROW_ON_ERROR);
        }

        $newsRepository = new MySQLNewsRepository();
        $createdNews = $newsRepository->createNews($title, $description);

        return json_encode([
            'status' => 'success',
            'message' => 'News was successfully created',
            'news' => [
                'id' => $createdNews['id'],
                'title' => $createdNews['title'],
                'description' => $createdNews['description']
            ]
        ], JSON_THROW_ON_ERROR);
    }

    /**
     * @throws JsonException
     */
    public function update(int $id): string
    {
        $this->checkAuthentication();

        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';

        if (empty($title) || empty($description)) {
            return json_encode(['status' => 'error', 'message' => 'Error updating news'], JSON_THROW_ON_ERROR);
        }

        $title = trim($title);
        $description = trim($description);

        if (strlen($title) > 255 || strlen($description) > 1000) {
            return json_encode(['status' => 'error', 'message' => 'Invalid input data'], JSON_THROW_ON_ERROR);
        }

        $newsRepository = new MySQLNewsRepository();
        $news = $newsRepository->getNewsById($id);
        if (!$news) {
            return json_encode(['status' => 'error', 'message' => 'Error updating news'], JSON_THROW_ON_ERROR);
        }

        $updatedNews = $newsRepository->updateNews($id, $title, $description);
        return json_encode([
            'status' => 'success',
            'message' => 'News was successfully changed',
            'news' => [
                'id' => $updatedNews['id'],
                'title' => $updatedNews['title'],
                'description' => $updatedNews['description']
            ]
        ], JSON_THROW_ON_ERROR);
    }

    /**
     * @throws JsonException
     */
    public function delete(int $id): string
    {
        $this->checkAuthentication();
        if (empty($id)) {
            return json_encode(['status' => 'error', 'message' => 'Error deleting news'], JSON_THROW_ON_ERROR);
        }
        $newsRepository = new MySQLNewsRepository();

        $news = $newsRepository->getNewsById($id);
        if (!$news) {
            return json_encode(['status' => 'error', 'message' => 'News not found'], JSON_THROW_ON_ERROR);
        }
        $newsRepository->deleteNews($id);
        return json_encode(['status' => 'success', 'message' => 'News deleted successfully'], JSON_THROW_ON_ERROR);
    }

    public function index(): void
    {
        $this->checkAuthentication();

        $newsRepository = new MySQLNewsRepository();
        $news = $newsRepository->getAllNews();

        View::renderTemplate('news.html.twig', ['news' => $news]);
    }
}