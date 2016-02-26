<?php

namespace lol;

use mysqli;

class User {
    public $db;
    public $id;
    public $name;
    public $errors = array();

    private static function getDb()
    {
        return new mysqli('127.0.0.1:3306', 'homestead', 'secret', 'homestead');
    }

    private function __construct($name, $id)
    {
        $this->db = self::getDb();
        $this->id = $id;
        $this->name = $name;
    }

    public static function create($name)
    {
        $db = self::getDb();
        if ($db->query("INSERT INTO users (name) VALUES ('$name')") === TRUE) {
            return new User($name, $db->insert_id);
        } else {
            echo "failed to create user\n";
            return FALSE;
        }
    }

    public static function find($id)
    {
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

    public static function findAll()
    {
        $db = self::getDb();
        $q = $db->query("SELECT * FROM users");
        if (!$q) {
            echo 'query error';
            exit;
        }
        if ($q->num_rows === 0) {
            echo "no match";
            exit;
        }
        $user_array = array();
        while ($row = $q->fetch_object()) {
            array_push($user_array, new User($row->name, $row->id));
        }
        return $user_array;
    }

    public static function initialize()
    {
        return new User(NULL, NULL);
    }

    public function save()
    {
        if (!$this->validate()) {
            echo "not a valid user:\n";
            foreach ($this->errors as $err) {
                echo "\t$err\n";
            }
            return FALSE;
        }
        $q_string = "UPDATE users SET name='$this->name' WHERE id=$this->id";
        $q = $this->db->query($q_string);
        if ($q) {
            echo 'save success';
            return TRUE;
        } else {
            echo 'save failure';
            return FALSE;
        }
    }

    public function destroy()
    {
        $q = $this->db->query("DELETE FROM users WHERE id = $this->id");
        if ($q) {
            echo 'destroy success';
            return TRUE;
        } else {
            echo 'destroy failure';
            return FALSE;
        }
    }

    public function validate()
    {
        $this->errors = array();
        if ($this->name) {
            return TRUE;
        } else {
            array_push($this->errors, 'no name');
        }
        return FALSE;
    }
}
