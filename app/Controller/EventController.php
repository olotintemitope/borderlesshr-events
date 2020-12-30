<?php


namespace Laztopaz\Controller;


use Laztopaz\Controller\Traits\QueryTrait;
use Laztopaz\Lib\Request;
use Laztopaz\PotatoORM\DatabaseHandler;
use PDO;

class EventController extends BaseController
{
    use QueryTrait;

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
            'event' => $event[0]
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

}