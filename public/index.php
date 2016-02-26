<?php

namespace lol;

require_once '../models/user.php';
require_once '../controllers/users_controller.php';

$controller = new UsersController();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $controller->handleGet();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller->handlePost();
} else {
    echo 'unhandled request method';
}
