<?php

/**
 * Description of UsersController
 *
 * @author Mali
 */
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController {

    public $uses = array(
        'Player');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'register', 'recover');
    }

    public function register() {
        if ($this->request->is('post')) {
            if ($this->Player->save($this->request->data)) {
                $this->Flash->success('The user has been saved.');
                $this->Auth->login($this->Player->id);
                return $this->redirect(array(
                            'controller' => 'arenas',
                            'action' => 'index'));
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

    public function recover() {
        if ($this->request->is('post')) {
            if (!empty($this->request->data['Player']['email'])) {
                $player = $this->Player->findByEmail($this->request->data['Player']['email']);
                if (!empty($player)) {
                    // Create and send email with double-hashed password
                    $email = new CakeEmail('gmail');
                    $email->to($player['Player']['email']);
                    $email->subject('Password recovery');
                    $link = Router::url(array(
                                'controller' => 'users',
                                'action' => 'recover',
                                '?' => array(
                                    'email' => $player['Player']['email'],
                                    'pass' => Security::hash($player['Player']['password'],
                                            'blowfish'))), true);
                    pr($link);
                    if ($email->send('Click on link to recover your password: ' . $link)) {
                        $this->Flash->success('Instructions successfully sent to email.');
                    } else {
                        $this->Flash->success('Instructions could not be sent to email. Please, try again.');
                    }
                } else {
                    $this->Flash->error('Invalid email, try again.');
                }
            }
        }

        // If URL contains email and corresponding double-hashed password, wait for new password input 
        if (!empty($this->request->query['email']) && !empty($this->request->query['pass'])) {
            $player = $this->Player->findByEmail($this->request->query['email']);
            if (!empty($player) && $this->request->query['pass'] == Security::hash($player['Player']['password'],
                            'blowfish', $this->request->query['pass'])) {
                $this->set('email', $this->request->query['email']);
                $this->set('recoverPassword', true);

                // Save new password
                if ($this->request->is('post')) {
                    if (!empty($this->request->data['Player']['password'])) {
                        $this->Player->id = $player['Player']['id'];
                        if ($this->Player->saveField('password',
                                        $this->request->data['Player']['password'])) {
                            $this->Flash->success('Password successfully updated.');
                            return $this->redirect(array(
                                        'controller' => 'users',
                                        'action' => 'login'));
                        } else {
                            $this->Flash->success('Password coult not be updated, try again.');
                        }
                    }
                }
            }
        }
    }

}
