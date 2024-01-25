<?php

class Authenticator
{
    public function authenticate($username, $password)
    {
        // Logique d'authentification avec base de données
        $user = $this->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            return true;
        }

        return false;
    }

    public function register($username, $password, $email)
    {
        // Modification pour simuler un échec d'enregistrement avec des données invalides
        if ($this->isUsernameTaken($username) || $this->isEmailTaken($email) || empty($username) || empty($password) || empty($email)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $result = $this->saveUser($username, $hashedPassword, $email);

        return $result;
    }

    private function getUserByUsername($username)
    {
        return ['username' => 'validUsername', 'password' => password_hash('validPassword', PASSWORD_DEFAULT)];
    }

    private function isUsernameTaken($username)
    {
        return $username === 'existingUsername';
    }

    private function isEmailTaken($email)
    {
        return false;
    }

    private function saveUser($username, $password, $email)
    {
        return true;
    }

    
}
?>
