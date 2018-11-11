<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?php
$this->extend('/Layout/TwitterBootstrap/dashboard');

$this->start('tb_actions');
?>
    <li><?=
    $this->Form->postLink(
        __('Delete'),
        ['action' => 'delete', $region->id],
        ['confirm' => __('Are you sure you want to delete # {0}?', $region->id)]
    )
    ?>
    </li>
    <li><?= $this->Html->link(__('List Regions'), ['action' => 'index']) ?></li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?=
    $this->Form->postLink(
        __('Delete'),
        ['action' => 'delete', $region->id],
        ['confirm' => __('Are you sure you want to delete # {0}?', $region->id)]
    )
    ?>
    </li>
    <li><?= $this->Html->link(__('List Regions'), ['action' => 'index']) ?></li>
</ul>
<?php
$this->end();
?>
<?= $this->Form->create($region, ['class' => 'form-group']); ?>
<fieldset>
    <legend><?= __('Edit {0}', ['Region']) ?></legend>
    <div class="form-group">
        <?= $this->Form->control('name', ['class' => 'form-control']); ?>
    </div>
    <div class="form-group">
        <?= $this->Form->control('country_id', ['options' => $countries, 'class' => 'form-control']); ?>
    </div>
</fieldset>
<?= $this->Form->button(__("Save"), ['class' => 'btn btn-primary mb-2']); ?>
<?= $this->Form->end() ?>
