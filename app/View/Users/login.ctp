<?php $this->assign('title', 'Login'); ?>

<div class="row">
<?php
    echo $this->Form->create('Player', array('inputDefaults' => array('class' => 'form-control', 'div' => 'form-group')));
    echo $this->Form->input('email', array('placeholder' => 'Email'));
    echo $this->Form->input('password', array('placeholder' => 'Password'));
    echo $this->Form->submit('Login', array('class' => 'btn btn-default', 'div' => 'form-group'));
    echo $this->Form->end();
?>
</div>
<div class="row">
    <div class="col">
        <?php echo $this->Html->link('Register', array('controller' => 'users', 'action' => 'register')); ?>
    </div>
    <div class="col">
        <?php echo $this->Html->link('Recover password', array('controller' => 'users', 'action' => 'recover'));?>
    </div>
</div>
