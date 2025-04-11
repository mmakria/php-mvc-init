<?php

use App\Autoloader;
use App\Models\Poste;
use App\Models\User;

require_once '/app/Autoloader.php';
Autoloader::register();

$user2 = new User();
$user2->setFirstName('momo');
$user2->setLastName('mak');
$user2->setEmail('momo@momotestete.com');
$user2->setPassword(password_hash('momo', PASSWORD_ARGON2ID));
$user2->setRoles(['ROLE_ADMIN']);
var_dump($user2);

//$user2 = (new User())
//        ->setFirstName('momo')
//        ->setLastName('mak')
//        ->setEmail('momo@momo1111.com')
//        ->setPassword(password_hash('momo', PASSWORD_ARGON2ID))
//        ->setRoles(['ROLE_ADMIN']);
//var_dump($user2);

$user = new User();
$user->setFirstName('momo');
$user->setLastName('mak');
$user->setEmail('momo@momo111.com');
$user->setPassword(password_hash('momo', PASSWORD_ARGON2ID));
$user->setRoles(['ROLE_ADMIN']);
$user->create();


var_dump($user);
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