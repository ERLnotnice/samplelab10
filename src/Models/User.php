<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class User extends BaseModel
{
    public $id;
    public $username;
    public $email;
    public $password_hash;
    public $first_name;
    public $last_name;

    // Method to register a new user
    public function register()
{
    try {
        $sql = "INSERT INTO users (username, email, password_hash, first_name, last_name) 
                VALUES (:username, :email, :password_hash, :first_name, :last_name)";
        $statement = $this->db->prepare($sql);
        $result = $statement->execute([
            'username' => $this->username,
            'email' => $this->email,
            'password_hash' => $this->password_hash,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ]);
        return $result; // Returns true on success
    } catch (\PDOException $e) {
        // Log the error message for debugging
        if ($e->getCode() == 23000) {
            // Handle specific SQL error codes (e.g., duplicate entry)
            error_log("Duplicate username: " . $e->getMessage());
            return false; // Optionally return a specific error message
        }
        error_log($e->getMessage());
        return false; // General failure
    }
}

    // Method to handle user login
    public function login($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $statement = $this->db->prepare($sql);
        $statement->execute(['username' => $username]);
        $user = $statement->fetchObject('\App\Models\User');

        if ($user && password_verify($password, $user->password_hash)) {
            // Successfully authenticated
            return $user; // Return user object
        }
        return null; // Authentication failed
    }

    // Optional: Method to fetch all users (if needed)
    public function all()
    {
        $sql = "SELECT * FROM users";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\User');
        return $result;
    }

    // Optional: Method to fetch a single user by ID
    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $statement = $this->db->prepare($sql);
        $statement->execute(['id' => $id]);
        return $statement->fetchObject('\App\Models\User'); // Returns a User object or null
    }
}
