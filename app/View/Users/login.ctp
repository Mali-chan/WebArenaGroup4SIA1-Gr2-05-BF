<?php

echo $this->Form->create('Player');
echo $this->Form->input('email', array('label' => 'Email'));
echo $this->Form->input('password', array('label' => 'Password'));
echo $this->Form->end('Login');

echo $this->Html->link('Register', array('controller' => 'users', 'action' => 'register'));
echo $this->Html->link('Recover password', array('controller' => 'users', 'action' => 'recover'));
