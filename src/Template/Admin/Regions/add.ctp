<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?php
$this->extend('/Layout/TwitterBootstrap/dashboard');

$this->start('tb_actions');
?>
    <li><?= $this->Html->link(__('List Regions'), ['action' => 'index']) ?></li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?= $this->Html->link(__('List Regions'), ['action' => 'index']) ?></li>
</ul>
<?php
$this->end();
?>
<?= $this->Form->create($region); ?>
<fieldset>
    <legend><?= __('Add {0}', ['Region']) ?></legend>
    <div class="form-group">
        <?= $this->Form->control('name', ['class' => 'form-control']); ?>
    </div>
    <div class="form-group">
        <?= $this->Form->control('country_id', ['options' => $countries, 'class' => 'form-control']); ?>
    </div>
</fieldset>
<?= $this->Form->button(__("Add"), ['class' => 'btn btn-primary mb-2']); ?>
<?= $this->Form->end() ?>
