<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'WebArena');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
        
<!DOCTYPE html>
<html>
    <head>
    <?php echo $this->Html->charset(); ?>
        <title>
        <?php echo $cakeDescription ?>:
        <?php echo $this->fetch('title'); ?>
        </title>
    
    <?php
        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('bootstrap-theme.min');
        echo $this->Html->css('webarena');
        
        echo $this->Html->script('jquery-1.11.3.min');        
        echo $this->Html->script('bootstrap.min');
    ?>
        
    <?php
        echo $this->Html->meta('icon');
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <nav class="navbar navbar-inverse">
                    <div class="container-fluid">
                        <div class="navbar-header">
                             <?php echo $this->Html->link('WebArena', DS, array('class' => 'navbar-brand')); ?>
                        </div>
                        <div>
                            <ul class="nav navbar-nav">
                                <li><?php echo $this->Html->link('Home', DS); ?></li>
                                <li><?php echo $this->Html->link('Fighter', array('controller' => 'arenas', 'action' => 'fighter')); ?></li> 
                                <li><?php echo $this->Html->link('Sight', array('controller' => 'arenas', 'action' => 'sight')); ?></li>
                                <li><?php echo $this->Html->link('Diary', array('controller' => 'arenas', 'action' => 'diary')); ?></li>
                                <li><?php 
                                        if (empty($authUser)) {
                                            echo $this->Html->link('Login', array('controller' => 'users', 'action' => 'login'));
                                        } else {
                                            echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'));
                                        }
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

            <div id="content" class="container">
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->Session->flash('auth'); ?>
                <?php echo $this->fetch('content'); ?>
            </div>

            <div id="footer">
                <p>
                    <?php echo 'WebArena - Gr2-05 - HU & MUGARUKA'; ?>
                </p>
                <p>
                    <?php echo 'Option F - Bonus: ' . $this->Html->link('versions.log', DS . 'files' . DS . 'versions.log'); ?>
                </p>
            </div>
        </div>
    </body>
</html>
