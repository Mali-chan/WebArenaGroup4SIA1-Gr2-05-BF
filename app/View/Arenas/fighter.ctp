<?php
echo $this->Form->create('Fightermove');
echo $this->Form->input('direction',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
echo $this->Form->end('Move');
?>

 <?php
echo $this->Form->create('Fighterattack');
echo $this->Form->input('Combat',array('options' => array('attack1'=>'attack1','attack2'=>'attack2','attack3'=>'attack3','attack4'=>'attack4'), 'default' => 'attack1'));
echo $this->Form->end('Attack');
 ?>
