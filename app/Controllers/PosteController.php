<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\Route;
use App\Models\Poste;

class PosteController extends AbstractController
{
    #[Route('app.poste.show', '/postes/details/([0-9]+)', ['GET'])]
    public function show(int $id): void
    {
        $poste = (new Poste)->find($id);
        require DIR_ROOT . '/Views/postes/show.php';
        var_dump($poste);
    }
}