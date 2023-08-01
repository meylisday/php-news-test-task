<?php
namespace App\Repositories\Interfaces;

interface NewsRepositoryInterface
{
    public function createNews($title, $description);
    public function updateNews($id, $title, $description);
    public function deleteNews($id);
    public function getAllNews(): array;
    public function getNewsById($id);
}