<?php

namespace App\Controllers;

use App\Models\User;
use App\Controllers\BaseController;

class LoginController extends BaseController
{
    // Show login form
    public function showLoginForm()
    {
        $template = 'login';
        $data = [
            'title' => 'Login'
        ];

        $output = $this->render($template, $data);
        return $output;
    }

    // Handle login form submission
    public function login()
    {
        $userModel = new User();

        // Fetch input from form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Authenticate the user
        $user = $userModel->login($username, $password);

        if ($user) {
            // Store user data in session
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;

            // Redirect to dashboard or another protected page
            header('Location: /home');
            exit;
        } else {
            // If login fails, redirect back to login with an error
            header('Location: /login?error=invalid_credentials');
            exit;
        }
    }

    // Handle logout
    public function logout()
    {
        // Destroy session data
        session_destroy();

        // Redirect to login page
        header('Location: /login');
        exit;
    }
}
