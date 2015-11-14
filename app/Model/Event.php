<?php

/**
 * Description of Event
 *
 * @author Mali
 */
App::uses('AppModel', 'Model');

class Event extends AppModel {

    public $name = "Event";

    public function getAllEvents() {
        $events = $this->find('all');
        return $events;
    }

    public function createEvent($name, $date, $coordinate_x, $coordinate_y) {
        $this->create(array(
            "name" => $name,
            "date" => $date,
            "coordinate_x" => $coordinate_x,
            "coordinate_y" => $coordinate_y
        ));
        $this->save();
    }

}
