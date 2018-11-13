<?php
/* @var $this \Cake\View\View */
$this->extend('/Layout/TwitterBootstrap/dashboard');
echo $this->Html->script(['back_to_top'], ['block' => 'scriptBottom']);
?>
<button onclick="topFunction()" id="toTop" title="Go to top"><i class="fa fa-chevron-up"></i></button>
<?php
$this->start('tb_actions');
?>
    <li><?= $this->Html->link(__('New Regions'), ['action' => 'add']); ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav nav-sidebar">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id'); ?></th>
            <th><?= $this->Paginator->sort('name'); ?></th>
            <th><?= $this->Paginator->sort('country'); ?></th>
            <th class="actions"><?= __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($regions as $region): ?>
        <tr>
            <td><?= $this->Number->format($region->id) ?></td>
            <td><?= h($region->name) ?></td>
            <td><?= h($region->country->name) ?></td>
            <td class="actions">
                <?= $this->Html->link('', ['action' => 'view', $region->id], ['title' => __('View'), 'class' => 'btn btn-default fa fa-eye']) ?>
                <?= $this->Html->link('', ['action' => 'edit', $region->id], ['title' => __('Edit'), 'class' => 'btn btn-default fa fa-pencil']) ?>
                <?= $this->Form->postLink('', ['action' => 'delete', $region->id], ['confirm' => __('Are you sure you want to delete # {0}?', $region->id), 'title' => __('Delete'), 'class' => 'btn btn-default fa fa-trash']) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
    </ul>
    <p><?= $this->Paginator->counter() ?></p>
</div>
