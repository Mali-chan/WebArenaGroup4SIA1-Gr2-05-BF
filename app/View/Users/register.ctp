<?php

echo $this->Form->create('Player');
echo $this->Form->input('email', array('label' => 'Email'));
echo $this->Form->input('password', array('label' => 'Password'));
echo $this->Form->end('Register');

?>
