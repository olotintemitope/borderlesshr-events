<?php

namespace Laztopaz\Controller;

class HomeController extends BaseController
{
    public function indexAction()
    {
        $this->render('index');
    }

    public function loginAction()
    {
        $this->render('auth/login');
    }

    public function processLoginAction($request)
    {
        $data = $request->getBody();
        $username = $data['username'];
        $password = $data['password'];

        if ($stmt = $this->db->prepare('SELECT id, role_id, password FROM users WHERE username = :username')) {
            $stmt->execute(['username' => $username]);
            $row = $stmt->fetchAll()[0];

            if ($row > 0) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['username'] = $username;
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['isAdmin'] = (int) $row['role_id'] === 1;
                    // Redirect to homepage
                    header('Location: /'); exit();
                }
            }
            $_SESSION['error'] = 'Incorrect username and/or password!';
            header('Location: /auth/login');
        }
    }

    public function logoutAction()
    {
        session_destroy();
        unset($_SESSION['loggedin'], $_SESSION['username'], $_SESSION['id']);

        header('Location: /');
    }
}