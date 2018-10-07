<?php

?>

<div class="row">
	<h2>HELo</h2>
    <div class="columns large-6">
        <h4>View</h4>
        <?= $this->Html->link(__('Published documents'), array('controller' => 'Documents', 'action' => 'index')); ?>
        <?php
        $logUser = $this->request->session()->read('Auth.User');
        if ($logUser) {
            if ($logUser['role'] == "admin") {
                echo '<br />';
                echo $this->Html->link(__('All documents'), array('controller' => 'Documents', 'action' => 'viewAllDocuments'));
            }
        }
        ?>
    </div>
    <div class="columns large-6">
        <h4>my stuff</h4>
        <?= $this->Html->link(__('My work'), array('controller' => 'Documents', 'action' => 'myWork')); ?>
    </div>
    <hr />
</div>