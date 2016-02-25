<?php

class User {
    public $db;
    public $id;
    public $name;

    private static function getDb() {
        return new mysqli('127.0.0.1:3306', 'homestead', 'secret', 'homestead');
    }

    private function __construct($name, $id) {
        $this->db = self::getDb();
        $this->id = $id;
        $this->name = $name;
    }

    public static function create($name) {
        $db = self::getDb();
        if ($db->query("INSERT INTO users (name) VALUES ('$name')") === TRUE) {
            return new User($name, $db->insert_id);
        } else {
            echo "failed to create user\n";
            return FALSE;
        }
    }

    public static function find($id) {
        $db = self::getDb();
        $q = $db->query("SELECT * FROM users WHERE id = $id");
        if (!$q) {
            echo 'query error';
            exit;
        }
        if ($q->num_rows === 0) {
            echo "no match or id $id";
            exit;
        }
        $row = $q->fetch_object();
        return new User($row->name, $row->id);
    }

    public static function findAll() {
        $db = self::getDb();
        $q = $db->query("SELECT * FROM users");
        if (!$q) {
            echo 'query error';
            exit;
        }
        if ($q->num_rows === 0) {
            echo "no match or id $id";
            exit;
        }
        $user_array = array();
        while ($row = $q->fetch_object()) {
            array_push($user_array, new User($row->name, $row->id));
        }
        return $user_array;
    }
}
