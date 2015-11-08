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
        $date = date('Y-m-d');

        return $this->filterEvents(function ($id) use ($date) {
            return strcmp($id, $date) < 0;
        });
    }

    public function getFuture()
    {
        $date = date('Y-m-d');

        return $this->filterEvents(function ($id) use ($date) {
            return strcmp($id, $date) >= 0;
        });
    }

    private function filterEvents(callable $filter)
    {
        $events = $this->getAll();

        return array_filter($events, $filter, ARRAY_FILTER_USE_KEY);
    }
}
