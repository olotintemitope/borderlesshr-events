<?php


namespace Laztopaz\Controller;

use Laztopaz\Controller\Traits\QueryTrait;
use Laztopaz\Lib\Request;
use Laztopaz\PotatoORM\DatabaseHandler;

class EventController extends BaseController
{
    use QueryTrait;

    /**
     * @var DatabaseHandler
     */
    private $dbHandler;

    public function __construct()
    {
        parent::__construct();

        $this->dbHandler = new DatabaseHandler('attendees');
    }

    public function indexAction()
    {
        $events = $this->getEvents();

        $this->render('events/list', [
            'events' => $events
        ]);
    }

    public function viewAction(Request $request)
    {
        $slug = $request->params[0];
        $splitSlug = explode("--", $slug);
        $id = count($splitSlug) > 1 ? end($splitSlug) : 0;

        if ($id === 0) {
            header('Location: /events');
            return;
        }

        $event = $this->getEvents($id);

        $applied = false;

        if (isset($_SESSION['id'])) {
            $applied = $this->hasUserAppliedToEvent($_SESSION['id'], $id);
        }


        $this->render('events/view', [
            'event' => $event[0],
            'applied' => $applied,
        ]);
    }

    public function searchAction($request)
    {
        $query = explode("=", $request->params[0]);
        $searchQuery = strtolower(strip_tags(end($query)));

        $events = $this->getSearchEvents($searchQuery);

        $this->render('events/search', [
            'events' => $events
        ]);

    }

    public function applyAction($request)
    {
        $host = "http://".$_SERVER['HTTP_HOST'];

        $slug = $request->params[0];
        $splitSlug = explode("--", $slug);
        $id = count($splitSlug) > 1 ? end($splitSlug) : 0;

        if ($id === 0) {
            header('Location: /events');
            return;
        }

        if (!$_SESSION['loggedin']) {
            $_SESSION['referral'] = $_SERVER['REQUEST_URI'];
            header('Location: /auth/login');
            return;
        }

        $token = bin2hex(\random_bytes(40));
        $event = $this->getEvents($id)[0];

        $data = [];
        $data['user_id'] = $_SESSION['id'];
        $data['event_id'] = $event['id'];
        $data['token'] = $token;
        $data['application_date'] = date('Y-m-d');

        try {
            $this->dbHandler->create($data, 'attendees');

            $_SESSION['success'] = "You application was successful, pls check your email for the confirmation link";

            $link = $host . "/events/{$slug}/confirm/{$token}";

            $message = $this->getEmailMessage($link);
            $this->sendEmail($_SESSION['email'], 'Application Confirmation', $message);
        } catch (Exception $exception) {
            $_SESSION['error'] = $exception->getMessage();
        }

        header("Location: /events/{$slug}");
    }

    /**
     * @param string $link
     */
    public function getEmailMessage(string $link): string
    {
         return"
            <html>
                <head>
                <title>Confimation email</title>
                </head>
                <body>
                <p>Dear {$_SESSION['username']},</p>
                <br/>
                <p>
                    Thank you your application. <br>
                    Please use the link below to confirm your application
                </p>
                <p>
                    <a style='background: green; color: #FFFFFF; padding: 20px; border-radius: 50%;' href={$link} title='Confirm your application'>CONFIRM</a>
                </p>
               <hr>
            </html>
            ";
    }

    protected function sendEmail($to, $subject, $message)
    {
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <webmaster@example.com>' . "\r\n";

        mail($to, $subject, $message, $headers);
    }

    public function confirmAction(Request $request)
    {
        $token = $request->params[1];
        $slug = $request->params[0];

        $attendee = $this->findApplicationByToken($token);

        if (count($attendee) <= 0) {
            $_SESSION['error'] = 'Confirmation token is invalid';

            header("Location: /events/{$slug}");

            return;
        }

        if ($this->updateAttendeeByToken($token)) {
            $_SESSION['success'] = 'Your attendance has been confirmed';
            header("Location: /events/{$slug}");

            return;
        }
    }

}