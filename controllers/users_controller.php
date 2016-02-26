<?php

namespace lol;

class UsersController
{
    private $user;

    public function __construct() {
        $this->user = User::initialize();
    }

    public function handleGet() {
        $uri = $_SERVER['REQUEST_URI'];
        switch($uri) {
            case '/':
                $this->index();
                break;
            case '/new':
                $this->new();
                break;
            case preg_match('/\d+\/edit/', $uri) ? $uri : !$uri:
                preg_match('/\d+/', $uri, $matches);
                $this->edit($matches[0]);
                break;
            case preg_match('/\d+/', $uri, $matches) ? $uri : !$uri:
                $this->show($matches[0]);
                break;
        }

    }

    public function handlePost() {
        switch($_GET['method']) {
            case 'delete':
                preg_match('/\d+/', $_SERVER['REQUEST_URI'], $matches);
                $this->destroy($matches[0]);
                break;
            case 'update':
                preg_match('/\d+/', $_SERVER['REQUEST_URI'], $matches);
                $this->update($matches[0]);
                break;
            case 'create':
                $this->create();
                break;
        }
    }

    public function show($id) {
        $user = User::find($id);
        include '../views/users/show.php';
    }

    public function index() {
        $users = User::findAll();
        include '../views/users/index.php';
    }

    public function edit($id) {
        $user = User::find($id);
        include '../views/users/edit.php';
    }

    public function new() {
        include '../views/users/new.php';
    }

    public function create() {
        $user = User::initialize();
        $user->name = $_POST['name'];
        if ($user->validate()) {
            $user->save();
            include '../views/users/show.php';
        } else {
            foreach($user->errors as $err) {
                echo $err."\n";
            }
            include '../views/users/new.php';
        }
    }

    public function update($id) {
        $user = User::find($id);
        $user->name = $_POST['name'];
        if ($user->validate()) {
            $user->save();
            include '../views/users/show.php';
        } else {
            foreach($user->errors as $err) {
                echo $err."\n";
            }
            include '../views/users/show.php';
        }
    }

    public function destroy($id) {
        $user = User::find($id);
        $user->destroy();
        $users = User::findAll();
        include '../views/users/index.php';
    }
}