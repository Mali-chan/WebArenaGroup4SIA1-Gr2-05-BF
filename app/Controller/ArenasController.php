<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Main controller of the application
 *
 * @author Mali
 */
App::uses('AppController', 'Controller');
class ArenasController extends AppController {
    
    /**
     * Index method : first page
     *
     * @return void
     */
    public function index() {

    }

    /**
     * Login page
     */
    public function login() {
        
    }

    /**
     * Fighter page
     */
    public function fighter() {
        
    }

    /**
     * Sight page
     */
    public function sight()
    {
            
        if ($this->request->is('post'))       
    {            pr($this->request->data);
                 $this->set('raw',$this->Fighter->find('all'));
    $this->Fighter->doMove(1, $this->request->data['Fightermove']['direction']);
    $this->Fighter->doAttack(1, $this->request->data['Fighterattack']['attack']);
    }
        
    }

    /**
     * Diary page
     */
    public function diary() {
         $this->set('raw',$this->Event->find());
    }
    
}
