<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Event
 *
 * @author Mali
 */
App::uses('AppModel', 'Model');
class Event extends AppModel {
    
    public $name = "Event";
   /* public $hasOne = array(
        'Event_Fighter' => array('className' => 'Fighter')
    );*/
    public function getEvent(){
            
    //put your code here
    $allData = $this->find('all');
    return $allData;
    }

    public function createEvent($name,$date,$coord_x,$coord_y)
    {
    $this->create();
    $js = array(
    "Event" =>array ("name" => $name,
        
        "date" => $date,
        "coordinate_x" => $coord_x,
        "coordinate_y" => $coord_y
        )
        );  
    $this->save($js);    
    }
   
}

