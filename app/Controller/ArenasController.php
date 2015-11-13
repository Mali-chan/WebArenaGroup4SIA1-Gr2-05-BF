<?php

/**
 * Main controller of the application
 *
 * @author Mali
 */
App::uses('AppController', 'Controller');

class ArenasController extends AppController {

    public $uses = array(
        'Fighter', 'Event');
    
    public function beforefilter() {
        parent::beforeFilter();
//        $this->Auth->allow(); // Allow all actions
        $this->Auth->allow('index');
    }

    /**
     * Index method : first page
     */
    public function index() {
        
    }

    /**
     * Fighter page
     * @todo with sessions, parameter playerId must be the currently connected player
     */
    public function fighter() {
        pr($this->request->data);
        if ($this->request->is('post')) {
            // Create
            if (isset($this->request->data['Fighter']['name'])) {
                $this->Fighter->doCreate('545f827c-576c-4dc5-ab6d-27c33186dc3e',
                        $this->request->data['Fighter']['name']);
            }
            // Level up
            else if (isset($this->request->data['Fighterlevelup']['skill'])) {
                $this->Fighter->doLevelUp(1,
                        $this->request->data['Fighterlevelup']['skill']);
            }
        }
        $this->set('fighter',
                $this->Fighter->findByPlayerId('545f827c-576c-4dc5-ab6d-27c33186dc3e'));
    }

    /**
     * Sight page
     * @todo pass the correct fighterId parameter
     */
    public function sight() {
        pr($this->request->data);
        if ($this->request->is('post')) {
            // Move
            if (isset($this->request->data['Fightermove']['direction'])) {
                $this->Fighter->doMove(1,
                        $this->request->data['Fightermove']['direction']);
            }
            // Attack
            else if (isset($this->request->data['Fighterattack']['direction'])) {
                $this->Fighter->doAttack(1,
                        $this->request->data['Fighterattack']['direction']);
            }
        }
        $this->set('fighters', $this->Fighter->find('all'));
    }

    /**
     * Diary page
     */
    public function diary() {
        if($this->Event->getEvent()){
        $this->set('raw', $this->Event->getEvent());
        }
    }

}
