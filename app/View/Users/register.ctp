<?php $this->assign('title', 'Register'); ?>

<div class="row">
<?php
    echo $this->Form->create('Player', array('inputDefaults' => array('class' => 'form-control', 'div' => 'form-group')));
    echo $this->Form->input('email', array('placeholder' => 'Email'));
    echo $this->Form->input('password', array('placeholder' => 'Password'));
    echo $this->Form->submit('Register', array('class' => 'btn btn-default', 'div' => 'form-group'));
    echo $this->Form->end();
?>
</div>
