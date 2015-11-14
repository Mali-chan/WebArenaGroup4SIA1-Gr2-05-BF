<?php

echo $this->Form->create('Player');
if (empty($recoverPassword)) {
    echo $this->Form->input('email', array('label' => 'Email'));
} else {
    echo $this->Form->input('password', array('label' => 'New password'));
}
echo $this->Form->end('Recover password');
