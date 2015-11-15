<?php

/**
 * Description of Event
 *
 * @author Mali
 */
App::uses('AppModel', 'Model');

class Event extends AppModel {

    public function getEventsWithin24h() {
        $start_date = date('Y-m-d H:i:s', time() - 60 * 60 * 24);
        $events = $this->find('all', array('conditions' => array('Event.date >=' => $start_date), 'order' => array('Event.date DESC')));
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
