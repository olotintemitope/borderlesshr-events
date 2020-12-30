<?php


namespace Laztopaz\Controller;


use Laztopaz\Lib\Request;
use Laztopaz\PotatoORM\DatabaseHandler;
use PDO;

class EventController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
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
        $id = count($splitSlug) > 1 ? end($splitSlug): 0;

        if ($id === 0) {
            header('Location: /events');
            return;
        }

        $event = $this->getEvents($id);

        $this->render('events/view', [
            'event' => $event
        ]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function getEvents($id = null): array
    {
        $sql = null === $id
            ? "SELECT 
                      et.id,
                      et.title, 
                      et.description, 
                      et.img_cover, 
                      et.number_of_participants, 
                      et.date_opened, 
                      et.registration_deadline_date, 
                      GROUP_CONCAT(ep.type) As types
                       
                FROM event_event_types ee 
                    JOIN events et ON et.id = ee.event_id  
                    JOIN event_types ep ON ep.id=ee.event_type_id  
                GROUP BY ee.event_id 
                ORDER BY et.registration_deadline_date"

            : "SELECT
                      et.id,
                      et.title, 
                      et.description, 
                      et.img_cover, 
                      et.number_of_participants, 
                      et.date_opened, 
                      et.registration_deadline_date, 
                      GROUP_CONCAT(ep.type, '') As types
                FROM event_event_types ee 
                    JOIN events et ON et.id = ee.event_id  
                    JOIN event_types ep ON ep.id=ee.event_type_id  
                    WHERE event_id = :event
                GROUP BY ee.event_id 
                ORDER BY et.registration_deadline_date";

        $stmt = $this->db->prepare( $sql);

        if (null !== $id) {
            $stmt->bindParam(':event', $id);
        }

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        return $stmt->fetchAll();
    }

}