<?php
namespace Laztopaz\Controller;

use Laztopaz\Lib\Request;
use Laztopaz\PotatoORM\DatabaseHandler;

class AdminEventTypesController extends BaseController
{
    private $dbHandler;

    public function __construct()
    {
        parent::__construct();

        $this->dbHandler = new DatabaseHandler('event_types', $this->db);
    }

    public function eventTypesAction()
    {
        try {
            $eventTypes = $this->dbHandler::read($id=false,'event_types', $this->db);

            $this->render('event_types/list', [
                'eventTypes' => $eventTypes,
            ]);
        } catch (Exception $exception) {
            $_SESSION['error'] = $exception->getMessage();
            header('Location: /admin/event-types');
        }

    }

    public function eventTypeAction()
    {
        $this->render('event_types/create');
    }

    public function createEventTypeAction(Request $request)
    {
        $data = $request->getBody();

        if (empty($data['type'])) {
            $_SESSION['error'] = 'Event Type is a required field';
        }

        try {
            $this->dbHandler->create([
                'type' => $data['type'],
                'is_premium' => isset($data['is_premium']) ? $data['is_premium'] : 0
            ], 'event_types');

            $_SESSION['success'] = 'Event Type added successfully';
            header('Location: /admin/event-types');
            return;
        } catch (Exception $exception) {
            $_SESSION['error'] = $exception->getMessage();
        }

        header('Location: /admin/event-type');
    }

    public function editEventTypeAction($request)
    {
        $id = $request->params[0];

        try {
            $eventType = $this->dbHandler::read($id,'event_types', $this->db);

            if (count($eventType) <= 0) {
                $_SESSION['error'] = 'Event Type not found';

                header('Location: /admin/event-types');
                return;
            }

            $this->render('event_types/edit', [
                'eventType' => $eventType[0],
            ]);
        } catch (Exception $exception) {
            $_SESSION['error'] = $exception->getMessage();
            header('Location: /admin/event-types');
        }

    }

    public function updateEventTypeAction($request)
    {
        $id = $request->params[0];
        $data = $request->getBody();

        try {
            $eventType = $this->dbHandler::read($id,'event_types', $this->db);

            if (count($eventType) <= 0) {
                $_SESSION['error'] = 'Event Type not found';

                header('Location: /admin/event-types');
                return;
            }

            if (empty($data['type'])) {
                $_SESSION['error'] = 'Event Type is a required field';
            }

            $this->dbHandler->update(['id' => $id], 'event_types', [
                'type' => $data['type'],
                'is_premium' => isset($data['is_premium']) ? $data['is_premium'] : 0
            ]);
            $_SESSION['success'] = 'Event Type updated successfully';

            header('Location: /admin/event-types');
            return;
        } catch (Exception $exception) {
            $_SESSION['error'] = $exception->getMessage();
            header('Location: /admin/event-types');
        }

    }
}