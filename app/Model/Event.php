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
    public function getEvent(){
            
    //put your code here
    $allData = $this->find('all');
    return $allData;
    }
}
