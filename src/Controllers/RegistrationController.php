<?php

namespace App\Controllers;

use App\Models\User;
use App\Controllers\BaseController;

class RegistrationController extends BaseController
{
    // List all registered users
    public function list()
    {
        $userModel = new User();
        $users = $userModel->all();

        $template = 'registrations';
        $data = [
            'title' => 'Registered Users',
            'items' => $users
        ];

        $output = $this->render($template, $data);
        return $output;
    }

    // Show registration form
    public function create()
    {
        $template = 'single-registration';
        $data = [
            'title' => 'Register New User',
            'user' => []
        ];

        $output = $this->render($template, $data);
        return $output;
    }

    // View single registered user's details
    public function single($id)
    {
        $userModel = new User();
        $user = $userModel->getUser($id);

        $template = 'single-registration';
        $data = [
            'title' => 'User Details',
            'user' => $user
        ];

        $output = $this->render($template, $data);
        return $output;
    }

    // Handle registration form submission
    public function store()
    {
        // Validate and sanitize input
        if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
            // Handle validation error (e.g., return an error message)
            return;
        }

        $user = new User();
        $user->username = $_POST['username'];
        $user->email = $_POST['email'];

        // Hash the password before saving it to the model
        $user->password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];

        // Attempt to register the user
        if ($user->register()) {
            // Registration successful, redirect or show success message
            // e.g., header("Location: /login");
        } else {
            // Handle registration failure (e.g., show an error message)
            // e.g., echo "Registration failed.";
        }
    }

    // Handle updating user registration details
    public function update($id)
    {
        $userModel = new User();
        $user = $userModel->getUser($id);
        $user->fill($_POST); // Update user fields from form input
        $user->save(); // Save updated user info

        // Redirect after update
        header('Location: /registrations');
        exit;
    }
}
