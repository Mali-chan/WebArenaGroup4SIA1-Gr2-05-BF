<?php $this->assign('title', 'Password recovery'); ?>

<div class="row">
<?php
    echo $this->Form->create('Player', array('inputDefaults' => array('class' => 'form-control', 'div' => 'form-group')));
    if (empty($recoverPassword)) {
        echo $this->Form->input('email', array('placeholder' => 'Email'));
        echo $this->Form->submit('Send email', array('class' => 'btn btn-default', 'div' => 'form-group'));
    } else {
        echo $this->Form->input('password', array('placeholder' => 'Password'));
        echo $this->Form->submit('Recover password', array('class' => 'btn btn-default', 'div' => 'form-group'));
    }
    echo $this->Form->end();
?>
</div>
