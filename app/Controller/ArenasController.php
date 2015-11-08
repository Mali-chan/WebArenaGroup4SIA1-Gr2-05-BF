<?php

/**
 * Main controller of the application
 *
 * @author Mali
 */
App::uses('AppController', 'Controller');

class ArenasController extends AppController {

    public $uses = array(
        'Fighter');

    /**
     * Index method : first page
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
     * @todo with sessions, parameter playerId must be the currently connected player
     */
    public function fighter() {
        pr($this->request->data);
        if ($this->request->is('post')) {
            if (isset($this->request->data['Fighterlevelup']['skill'])) {
                $this->Fighter->doLevelUp(1,
                        $this->request->data['Fighterlevelup']['skill']);
            }
        }
        $this->set('fighters',
                $this->Fighter->findByPlayerId('545f827c-576c-4dc5-ab6d-27c33186dc3e'));
    }

    /**
     * Sight page
     * @todo pass the correct fighterId parameter
     */
    public function sight() {
        pr($this->request->data);
        if ($this->request->is('post')) {
            if (isset($this->request->data['Fightermove']['direction'])) {
                $this->Fighter->doMove(1,
                        $this->request->data['Fightermove']['direction']);
            } else if (isset($this->request->data['Fighterattack']['direction'])) {
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
        $this->set('raw', $this->Event->find());
    }

}
