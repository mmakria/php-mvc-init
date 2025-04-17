<?php

use App\Autoloader;
use App\Models\Poste;
use App\Models\User;
use App\Core\App;
require_once '/app/Autoloader.php';
Autoloader::register();

define('DIR_ROOT', dirname(__DIR__));



// On va instancier l'objet App (qui représente notre application)
$app = new App();

// On va lancer l'app (méthode start)
$app->start();


//$user2 = new User();
//$user2->setFirstName('momo');
//$user2->setLastName('mak');
//$user2->setEmail('momo@momotestete.com');
//$user2->setPassword(password_hash('momo', PASSWORD_ARGON2ID));
//$user2->setRoles(['ROLE_ADMIN']);
//var_dump($user2);

//$user2 = (new User())
//        ->setFirstName('momo')
//        ->setLastName('mak')
//        ->setEmail('momo@momo1111.com')
//        ->setPassword(password_hash('momo', PASSWORD_ARGON2ID))
//        ->setRoles(['ROLE_ADMIN']);
//var_dump($user2);


//$donnees = [
//    'title' => 'Mon titre est ',
//    'description' => 'My life',
//    'enabled' => true,
//    'createdAt' => '2025-10-01 12:00:00',
//];
//
////$poste = (new Poste())->hydrate($donnees)->create();
//$poste = (new Poste())->findAll();
//
//var_dump($poste);