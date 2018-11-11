<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?php 
    echo $this->Html->css([
            'base.css',
            'style.css',
            'my_style.css',
            'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css',
            // 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css',
            // '/bootstrap/open-iconic-master/font/css/open-iconic.css',
            'Regions/basic',
            'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
            'mono_page.css',
        ]);
    ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?php
        echo $this->Html->script([
            'https://code.jquery.com/jquery-1.12.4.js',
            'https://code.jquery.com/ui/1.12.1/jquery-ui.js',
            'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js',
            // 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js',
            'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js',
                ], ['block' => 'scriptLibraries']
        );
    ?>
</head>
<body>
<!-- 
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <?= $this->Html->link(__('Home'), array('controller' => 'Pages', 'action' => 'myhome')) ?>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">

            <?php
            $loguser = $this->request->session()->read('Auth.User');
            if($loguser) {
               // user is logged in, show logout..user menu etc
                if ($loguser['role']['role'] == 'creator') {
                    if ($loguser['verified'] != true) {
                        echo $this->Html->link(__('Resend a verification email'), array('controller' => 'EmailVerifications', 'action' => 'verifyQuery'), array('class' => 'nav-item nav-link'));
                    }
                }
               echo $this->Html->link(__('My favorites'), array('controller' => 'Documents', 'action' => 'myFavorites'), array('class' => 'nav-item nav-link'));
               $my_menu_text = __('{0} {1}', $loguser['role']['role'], $loguser['username']);
               echo $this->Html->link($my_menu_text, array('controller' => 'Documents', 'action' => 'myWork'), array('class' => 'nav-item nav-link'));
               echo $this->Html->link($loguser['email'] . ' Logout', array('controller' => 'users', 'action' => 'logout'), array('class' => 'nav-item nav-link'));
            } else {
               // the user is not logged in
               echo $this->Html->link(__('Log in'), array('controller' => 'users', 'action' => 'login'), array('class' => 'nav-item nav-link'));
               echo $this->Html->link(__('sign up'), array('controller' => 'users', 'action' => 'add'), array('class' => 'nav-item nav-link'));
            }
            ?>

            <?=$this->Html->link(__('About'), ['controller' => 'Pages','action' => 'about'], ['escape' => false, 'class' => 'nav-item nav-link'])?>
            <?=$this->Html->link('Français', ['controller' => 'Pages','action' => 'changeLang', 'fr_CA'], ['escape' => false, 'class' => 'nav-item nav-link'])?>
            <?=$this->Html->link('English', ['controller' => 'Pages','action' => 'changeLang', 'en_US'], ['escape' => false, 'class' => 'nav-item nav-link'])?>
            <?=$this->Html->link('中文', ['controller' => 'Pages','action' => 'changeLang', 'zh_CN'], ['escape' => false, 'class' => 'nav-item nav-link'])?>

        </div>
      </div>
    </nav>
 -->

    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><?= $this->Html->link(__('Home'), array('controller' => 'Pages', 'action' => 'myhome')) ?></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
                <?php
                $loguser = $this->request->session()->read('Auth.User');
                if($loguser) {
                   // user is logged in, show logout..user menu etc
                    if ($loguser['role']['role'] == 'creator') {
                        if ($loguser['verified'] != true) {
                            echo '<li>'.$this->Html->link(__('Resend a verification email'), array('controller' => 'EmailVerifications', 'action' => 'verifyQuery')).'</li>';
                        }
                    }
                   echo '<li>'.$this->Html->link(__('My favorites'), array('controller' => 'Documents', 'action' => 'myFavorites')).'</li>';
                   $my_menu_text = __('{0} {1}', $loguser['role']['role'], $loguser['username']);
                   echo '<li>'.$this->Html->link($my_menu_text, array('controller' => 'Documents', 'action' => 'myWork')).'</li>';
                   echo '<li>'.$this->Html->link($loguser['email'] . ' Logout', array('controller' => 'users', 'action' => 'logout')).'</li>';
                } else {
                   // the user is not logged in
                   echo '<li>'.$this->Html->link(__('Log in'), array('controller' => 'users', 'action' => 'login')).'</li>';
                   echo '<li>'.$this->Html->link(__('sign up'), array('controller' => 'users', 'action' => 'add')).'</li>';
                }
                ?>
                <li>
                    <?= $this->Html->link(__('About'), ['controller' => 'Pages','action' => 'about'], ['escape' => false]) ?>
                </li>

                <li>
                    <?= $this->Html->link('Français', ['controller' => 'Pages','action' => 'changeLang', 'fr_CA'], ['escape' => false]) ?>
                </li>
                <li>
                    <?= $this->Html->link('English', ['controller' => 'Pages','action' => 'changeLang', 'en_US'], ['escape' => false]) ?>
                </li>
                <li>
                    <?= $this->Html->link('中文', ['controller' => 'Pages','action' => 'changeLang', 'zh_CN'], ['escape' => false]) ?>
                </li>

            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
        <?= $this->fetch('scriptLibraries') ?>
        <?= $this->fetch('script'); ?>
        <?= $this->fetch('scriptBottom') ?>
    </footer>
</body>
</html>
