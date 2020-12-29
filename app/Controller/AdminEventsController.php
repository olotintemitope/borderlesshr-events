<?php


namespace Laztopaz\Controller;


use Exception;
use Laztopaz\Controller\Traits\ImageUpload;
use Laztopaz\PotatoORM\DatabaseHandler;

class AdminEventsController extends BaseController
{
    private $dbHandler;

    use ImageUpload;

    public function __construct()
    {
        parent::__construct();

        $this->dbHandler = new DatabaseHandler('events', $this->db);
    }

    public function eventsAction()
    {
        try {
            $events = $this->dbHandler::read($id=false,'events', $this->db);

            $this->render('events/list', [
                'events' => $events,
            ]);
        } catch (Exception $exception) {
            $_SESSION['error'] = $exception->getMessage();
            header('Location: /admin/events');
        }
    }

    public function eventAction()
    {
        $this->render('events/create');
    }

    public function createEventAction($request)
    {
        $data = $request->getBody();

        $validateRequest = $this->validateRequest($data);
        [$uploadErrors, $fileName] = $this->upload($_FILES);

        $errors = array_merge($validateRequest, $uploadErrors);

        if (count($errors) > 0) {
            $_SESSION['error'] = implode("\n", $errors);

            header('Location: /admin/event');
            exit();
        }

        try {
            $data['img_cover'] = $fileName;
            $data['date_opened'] = (new \DateTime($data['date_opened']))->format('Y-m-d');
            $data['registration_deadline_date'] = (new \DateTime($data['registration_deadline_date']))->format('Y-m-d');
            $data['user_id'] = $_SESSION['id'];

            $this->dbHandler->create($data, 'events');

            $_SESSION['success'] = 'Event added successfully';
            header('Location: /admin/events');
            exit();
        } catch (Exception $exception) {
            $_SESSION['error'] = $exception->getMessage();
            header('Location: /admin/event');
            exit();
        }
    }

    public function editEventAction($request)
    {
        $id = $request->params[0];

        try {
            $events = $this->dbHandler::read($id, 'events', $this->db);

            if (count($events) <= 0) {
                $_SESSION['error'] = 'Event not found';

                header('Location: /admin/events');
                exit();
            }

            $this->render('events/edit', [
                'event' => $events[0],
            ]);
        } catch (Exception $exception) {
            $_SESSION['error'] = $exception->getMessage();
            header('Location: /admin/events');
        }
    }


    private function validateRequest(array $data): array
    {
        $errors = [];

        if (empty($data['title'])) {
            $errors[] = 'Title is required';
        }

        if (empty($data['description'])) {
            $errors[] = 'Description is required';
        }

        if (empty($data['date_opened'])) {
            $errors[] = 'Date Opened is required';
        }

        if (empty($data['registration_deadline_date'])) {
            $errors[] = 'Registration Deadline is required';
        }

        try {
            $dateOpened = new \DateTime($data['date_opened']);
            $deadline = new \DateTime($data['registration_deadline_date']);
            if ($deadline < $dateOpened) {
                $errors[] = 'Registration deadline must be a future date of Date Opened';
            }
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }

        return $errors;
    }

    public function updateEventAction($request)
    {
        $id = $request->params[0];
        $data = $request->getBody();
        $uploadErrors = [];

        $events = $this->dbHandler::read($id, 'events', $this->db);

        if (count($events) <= 0) {
            $_SESSION['error'] = 'Event not found';

            header('Location: /admin/events');
            exit();
        }

        if (!empty($_FILES['img_cover']['name'])) {
            [$uploadErrors, $fileName] = $this->upload($_FILES);
            $data['img_cover'] = $fileName;
        }

        $validateRequest = $this->validateRequest($data);
        $errors = array_merge($validateRequest, $uploadErrors);

        if (count($errors) > 0) {
            $_SESSION['error'] = implode("\n", $errors);

            header('Location: /admin/event');
            exit();
        }

        try {
            $data['date_opened'] = (new \DateTime($data['date_opened']))->format('Y-m-d');
            $data['registration_deadline_date'] = (new \DateTime($data['registration_deadline_date']))->format('Y-m-d');
            $data['user_id'] = $_SESSION['id'];

            $this->dbHandler->update(['id' => $id], 'events', $data);

            $_SESSION['success'] = 'Event updated successfully';
            header('Location: /admin/events');
            exit();
        } catch (Exception $exception) {
            $_SESSION['error'] = $exception->getMessage();
            header('Location: /admin/event');
            exit();
        }
    }

}