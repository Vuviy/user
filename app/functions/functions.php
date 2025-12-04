<?php
function dd(mixed ...$args): void
{
    echo '<pre>';
    foreach ($args as $arg) {

        if (is_bool($arg)) {
            var_dump($arg);
        } else {
            print_r($arg);
            echo "\n";
        }
    }
    echo '</pre>';
    die();
}