<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<?= $this->Flash->render() ?>	
<div class="row">
	<div class="users form columns large-8">
	<?= $this->Form->create() ?>
	    <fieldset>
	    	<h2>Login</h2>
	        <legend><?= __('Please enter your username and password.') ?></legend>
	        <?= $this->Form->input('username') ?>
	        <?= $this->Form->input('password') ?>
	    </fieldset>
	<?= $this->Form->button(__('Login')); ?>
	<?= $this->Form->end() ?>
	<?php
	echo $this->Html->link(
	    'Create an account',
	    ['controller' => 'Users', 'action' => 'add', '_full' => true]
	);
	?>
	</div>
</div>