<?php

namespace Laztopaz\Controller;

use Laztopaz\Controller\Traits\QueryTrait;
use Laztopaz\Enum\Role;
use Laztopaz\PotatoORM\DatabaseHandler;

class HomeController extends BaseController
{
    use QueryTrait;

    /**
     * @var DatabaseHandler
     */
    private $dbHandler;

    public function __construct()
    {
        parent::__construct();

        $this->dbHandler = new DatabaseHandler('users');
    }

    public function indexAction()
    {
        $events = $this->getEvents();

        $this->render('index', [
            'events' => $events
        ]);
    }

    public function loginAction()
    {
        $this->render('auth/login');
    }

    public function registerAction()
    {
        $this->render('auth/register');
    }

    public function processLoginAction($request)
    {
        $data = $request->getBody();
        $this->loginUser($data);
    }

    public function processRegisterAction($request)
    {
        $data = $request->getBody();
        $fields = [];

        $errors = $this->validateRequest($data);

        if (count($errors) > 0) {
            $_SESSION['error'] = implode("\n", $errors);

            header('Location: /auth/register');
            return;
        }

        $loginData = [];
        $loginData['username'] = $data['username'];
        $loginData['password'] = $data['password'];

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['role_id'] = Role::ATTENDEE;

        $this->dbHandler->create($data, 'users');

        $this->loginUser($loginData);
    }

    public function logoutAction()
    {
        $_SESSION = [];

        unset($_SESSION['loggedin'], $_SESSION['username'], $_SESSION['id']);

        session_destroy();

        header('Location: /');
    }

    /**
     * @param $data
     */
    public function loginUser($data): void
    {
        $username = $data['username'];
        $password = $data['password'];

        if ($stmt = $this->db->prepare('SELECT id, role_id, email, password FROM users WHERE username = :username')) {
            $stmt->execute(['username' => $username]);
            $row = $stmt->fetchAll()[0];

            if ($row > 0) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['isAdmin'] = (int)$row['role_id'] === 1;
                    // Redirect to homepage
                    header('Location: /');
                    exit();
                }
            }

            $_SESSION['error'] = 'Incorrect username and/or password!';

            header('Location: /auth/login');
        }
    }

    /**
     * @param array $data
     * @return array
     */
    private function validateRequest(array $data): array
    {
        $errors = [];

        if (empty($data['username']) || filter_var($data['username'], FILTER_SANITIZE_STRING) === false) {
            $errors[] = 'Username is required';
        }

        if (empty($data['first_name']) || filter_var($data['first_name'], FILTER_SANITIZE_STRING) === false) {
            $errors[] = 'First name is required';
        }

        if (empty($data['last_name']) || filter_var($data['last_name'], FILTER_SANITIZE_STRING) === false) {
            $errors[] = 'Last name is required';
        }

        if (empty($data['email']) || filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'Email is required';
        }

        return $errors;
    }
}