<?php
namespace App\Controllers;
use App\Core\AbstractController;
use App\Core\Route;

class HomeController extends AbstractController
{
    #[Route('app.home', '/', ['GET'])]
    public function index(): void
    {
        require DIR_ROOT . '/Views/home/index.php';
    }

    #[Route('app.test', '/test', ['GET'])]
    public function test(): void
    {
        echo "Page de test";
    }

    #[Route('app.login', '/login', ['GET'])]
    public function login(): void
    {
        echo "Page de login";
    }

    #[Route('app.login', '/recrue', ['GET'])]
    public function recrue(): void
    {
        echo "Recrue";
    }
}