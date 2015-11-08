<?php

namespace App\Model\Event;

use App\Model\Repository;

class EventRepository extends Repository implements EventRepositoryInterface
{
    public function getNext()
    {
        $futureEvents = $this->getFuture();

        if (count($futureEvents) < 1) {
            return null;
        }

        return $futureEvents[0];
    }

    public function getPast()
    {
        return $this->filterEventsByDate(true);
    }

    public function getFuture()
    {
        return $this->filterEventsByDate(false);
    }

    private function filterEventsByDate($past)
    {
        $events = $this->getAll();
        $date = date('Y-m-d');

        $filteredEvents = [];

        foreach ($events as $id => $event) {
            if ($past ? strcmp($id, $date) < 0 : strcmp($id, $date) >= 0) {
                $filteredEvents[] = $event;
            }
        }

        return $filteredEvents;
    }
}
