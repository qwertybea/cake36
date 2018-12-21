<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 */

echo $this->Html->css('dropzone/dropzone');
echo $this->Html->script('dropzone/dropzone', ['block' => 'scriptLibraries']);
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List my documents'), ['action' => 'myWork']) ?></li>
    </ul>
</nav>
<div class="documents form large-9 medium-8 columns content" ng-app="linkedlists" ng-controller="countriesController">
    <?php echo $this->Form->create('image',array('url'=>array('controller'=>'Documents','action'=>'change-cover', $id),'method'=>'post','class'=>'dropzone','type'=>'file','autocomplete'=>'off',));?>
                        
    <?php echo $this->Form->end();?>
    </div>
</div>
