<?php


namespace Laztopaz\Controller;


use Exception;
use Laztopaz\Controller\Traits\ImageUpload;
use Laztopaz\PotatoORM\DatabaseHandler;
use Laztopaz\PotatoORM\TableFieldUndefinedException;

class AdminEventsController extends BaseController
{
    private $dbHandler;
    private $dbHandler2;

    use ImageUpload;

    public function __construct()
    {
        parent::__construct();

        $this->dbHandler = new DatabaseHandler('events');
        $this->dbHandler2 = new DatabaseHandler('event_event_types');
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
        $eventTypes = $this->dbHandler::read($id=false,'event_types', $this->db);

        $this->render('events/create', [
            'eventTypes' => $eventTypes,
        ]);
    }

    public function createEventAction($request)
    {
        $data = $request->getBody();
        $fields = [];

        $validateRequest = $this->validateRequest($data);
        [$uploadErrors, $fileName] = $this->upload($_FILES);

        $errors = array_merge($validateRequest, $uploadErrors);

        if (count($errors) > 0) {
            $_SESSION['error'] = implode("\n", $errors);

            header('Location: /admin/event');
            return;
        }

        try {
            $fields['img_cover'] = $fileName;
            $fields = $this->setEventData($data, $fields, $fileName);

            $this->dbHandler->create($fields, 'events');
            $lastInsertId = $this->db->lastInsertId();

            $this->addEventTypesToEvent($data, $lastInsertId);

            $_SESSION['success'] = 'Event added successfully';
            header('Location: /admin/events');
            return;
        } catch (Exception $exception) {
            $_SESSION['error'] = $exception->getMessage();
            header('Location: /admin/event');
            return;
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
                return;
            }

            $eventTypes = $this->dbHandler::read($id=false,'event_types', $this->db);
            $eventEventTypes = $this->dbHandler2::read($id,'event_event_types', $this->db);

            $evenTypeIds = $this->getEventTypeIds($eventEventTypes);

            $this->render('events/edit', [
                'event' => $events[0],
                'eventTypes' => $eventTypes,
                'evenTypeIds' => $evenTypeIds,
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
        $fields = [];

        $events = $this->dbHandler::read($id, 'events', $this->db);

        if (count($events) <= 0) {
            $_SESSION['error'] = 'Event not found';

            header('Location: /admin/events');
            return;
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
            return;
        }

        try {
            $fields = $this->setEventData($data, $fields);

            $this->dbHandler->update(['id' => $id], 'events', $fields);

            if ($this->deleteEventsFromEventTypes($id)) {
                $this->addEventTypesToEvent($data, $id);
            }

            $_SESSION['success'] = 'Event updated successfully';
            header('Location: /admin/events');
            return;
        } catch (Exception $exception) {
            $_SESSION['error'] = $exception->getMessage();
            header('Location: /admin/event');
            return;
        }
    }

    /**
     * @param array $data
     * @param string $lastInsertId
     * @throws TableFieldUndefinedException
     */
    public function addEventTypesToEvent(array $data, string $lastInsertId): void
    {
        $fields = [];

        foreach ($data['event_types'] as $eventType) {
            $fields['event_type_id'] = $eventType;
            $fields['event_id'] = $lastInsertId;

            $this->dbHandler2->create($fields, 'event_event_types');
        }
    }

    /**
     * @param array $eventEventTypes
     * @return mixed
     */
    public function getEventTypeIds(array $eventEventTypes)
    {
        return array_reduce($eventEventTypes, function ($acc = [], $eventEventType) {
            $acc[] = $eventEventType['event_type_id'];
            return $acc;
        });
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteEventsFromEventTypes($id): bool
    {
        $stmt = $this->db->prepare( "DELETE FROM event_event_types WHERE event_id =:event" );
        $stmt->bindParam(':event', $id);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    /**
     * @param $data
     * @param array $fields
     * @return array
     * @throws Exception
     */
    public function setEventData($data, array $fields): array
    {
        $fields['title'] = $data['title'];
        $fields['number_of_participants'] = $data['number_of_participants'];
        $fields['description'] = $data['description'];
        $fields['date_opened'] = (new \DateTime($data['date_opened']))->format('Y-m-d');
        $fields['registration_deadline_date'] = (new \DateTime($data['registration_deadline_date']))->format('Y-m-d');
        $fields['user_id'] = $_SESSION['id'];
        return $fields;
    }

}