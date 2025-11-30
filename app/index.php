<?php
declare(strict_types=1);

use App\FakeBookRepository;
use App\Repository\SessionUserRepository;
use App\Service\AuthService;
use App\User;
use App\ValueObject\Email;
use App\ValueObject\Id;
use App\ValueObject\Password;
use App\ValueObject\Role;

require __DIR__ . '/functions/functions.php';
require __DIR__ . '/vendor/autoload.php';

$user = new User(
    new Id('550e8400-e29b-41d4-a716-446655440007'),
    new Email('test5@example.com'),
    Password::fromPlain('password'),
    new Role('moderator')
);

$repo = new SessionUserRepository();


$authServise = new AuthService($repo);

//$user = $authServise->register('test9@example.com', 'password222', 'moderator');
$authUser = $authServise->login('test9@example.com', 'password222');
//$authServise->logout();
$authUserFromMethod = $authServise->getCurrentUser();
//$repo->save($user);

$authUserFromMethod->setRole(new Role('admin'));


//dd($authUserFromMethod);
//$repo->delete( new Id('550e8400-e29b-41d4-a716-446655440000'));
// $repo->delete( new Id('550e8400-e29b-41d4-a716-446655440003'));
//$user = $repo->getById(new Id('550e8400-e29b-41d4-a716-446655440003'));

$fakerepo = new FakeBookRepository();

$res = $fakerepo->fakeDeleteBook();

dd($res);

//$user->setId(new Id('new_id'));
//$user->setEmail(new Email('new_email@gmail.com'));
//$user->setPassword(Password::fromPlain('new_password'));
//$user->setRole(new Role('new_user_role'));

//foreach ($user as $value){
//
//dd($value);
//}


//$email = new Email('test@example.com');
//$pwd = Password::fromPlain('ggggg');

//echo $email; // test@example.com
//echo $pwd->getHash();
//var_dump($pwd->verify('gggg'));

//dd($pwd->verify('ggggg'));

//$role = new Role('admin');
//$role2 = new Role('user');
//var_dump($role->equals($role2));

//$id = new Id('550e8400-e29b-41d4-a716-446655440000');
//dd($id);