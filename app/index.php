<?php
declare(strict_types=1);

use App\Repository\BookRepository;
use App\Repository\SessionUserRepository;
use App\Service\AuthService;
use App\Service\BookService;

require __DIR__ . '/functions/functions.php';
require __DIR__ . '/vendor/autoload.php';


$repo = new SessionUserRepository();
$authServise = new AuthService($repo);


//$user = $authServise->register('test9@example.com', 'password222', [$moderatorRoleFactory]);
//$authUser = $authServise->login('test9@example.com', 'password222');

$user = $authServise->getCurrentUser();

$bookRepository = new BookRepository();
$bookService = new BookService($bookRepository);

$res = $bookService->delete($user);

dd($res);