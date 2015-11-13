<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Player
 *
 * @author Mali
 */
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Player extends AppModel {

    public function beforeSave($options = array()) {
        // Hash password
        if (isset($this->data['Player']['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data['Player']['password'] = $passwordHasher->hash(
                    $this->data['Player']['password']
            );
        }
        return true;
    }

}
