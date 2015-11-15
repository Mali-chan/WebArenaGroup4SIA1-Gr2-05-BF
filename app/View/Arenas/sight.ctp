<?php $this->assign('title', 'Sight'); ?>

<?php
    if (!empty($playerFighter)) {
?>
<div id="map" class="row container">
<?php
        foreach ($map as $row) {
            foreach ($row as $col) {
                echo $this->Html->image($col);
            }
        }
?>
</div>
<?php
        echo $this->Form->create('Fightermove', array('class' => 'form-inline', 'inputDefaults' => array('div' => 'form-group', 'label' => false, 'class' => 'form-control')));
        echo $this->Form->input('direction', array('options' => array('north' => 'north', 'east' => 'east', 'south' => 'south', 'west' => 'west'), 'default' => 'east'));
        echo $this->Form->submit('Move', array('div' => 'form-group', 'class' => 'btn btn-default'));
        echo $this->Form->end();
?>

<?php
        echo $this->Form->create('Fighterattack', array('class' => 'form-inline', 'inputDefaults' => array('div' => 'form-group', 'label' => false, 'class' => 'form-control')));
        echo $this->Form->input('direction', array('options' => array('north' => 'north', 'east' => 'east', 'south' => 'south', 'west' => 'west'), 'default' => 'east'));
        echo $this->Form->submit('Attack', array('div' => 'form-group', 'class' => 'btn btn-default'));
        echo $this->Form->end();
?>
<?php
    }
?>
