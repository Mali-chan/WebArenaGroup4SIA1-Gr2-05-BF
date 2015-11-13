<?php

/**
 * Description of UsersController
 *
 * @author Mali
 */
App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public $uses = array(
        'Player');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'register');
    }

    public function register() {
        if ($this->request->is('post')) {
            if ($this->Player->save($this->request->data)) {
                $this->Flash->success('The user has been saved.');
                $this->Auth->login($this->Player->id);
                return $this->redirect(array('controller' => 'arenas', 'action' => 'index'));
            }
            $this->Flash->error('The user could not be saved. Please, try again.');
        }
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Invalid username or password, try again.');
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

}
