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

        return array_filter($events, function ($id) use ($date, $past) {
            return $past ? strcmp($id, $date) < 0 : strcmp($id, $date) >= 0;
        }, ARRAY_FILTER_USE_KEY);
    }
}
