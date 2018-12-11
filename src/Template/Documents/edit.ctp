<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 */
$urlToLinkedListFilter = $this->Url->build([
    "controller" => "Countries",
    "action" => "getCountries",
    "_ext" => "json"
        ]);
$urlRedirectToIndex = $this->Url->build([
    "controller" => "Files",
    "action" => "index"
        ]);
echo $this->Html->scriptBlock('var urlToLinkedListFilter = "' . $urlToLinkedListFilter . '";', ['block' => true]);
echo $this->Html->script('Documents/edit', ['block' => 'scriptBottom']);
echo $this->Html->css('dropzone/dropzone');
echo $this->Html->script('dropzone/dropzone', ['block' => 'scriptLibraries']);
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $document->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $document->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List my documents'), ['action' => 'myWork']) ?></li>
    </ul>
</nav>
<div class="documents form large-9 medium-8 columns content" ng-app="linkedlists" ng-controller="countriesController">
    <?= $this->Form->create($document, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Edit Document') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('other_details');

            echo '<hr>';
            
            echo $this->Form->control('document_cover_tmp', ['label' => 'Document Cover', 'type' => 'file']);
            echo $this->Form->control('remove_cover', ['type' => 'checkbox']);
            echo '<hr>';


            echo $this->Form->control('country_id', [
                    'ng-model' => 'country', 
                    'ng-options' => 'country.name for country in countries track by country.id'
                ]);
            echo $this->Form->control('region_id', [
                    'ng-disabled' => '!country', 
                    'ng-model' => 'region',
                    'ng-options' => "region.name for region in country.regions track by region.id"
                ]);


            echo $this->Form->control('published');
            //echo $this->Form->control('deleted');

            echo $this->Form->control('content', ['type' => 'textarea', 'default' => $textDocument['text']]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
    <?php echo $this->Form->create('image',array('url'=>array('controller'=>'Controller_Name','action'=>'function_name'),'method'=>'post','id'=>'my-awesome-dropzone','class'=>'dropzone','type'=>'file','autocomplete'=>'off',));?>
                        
    <?php echo $this->Form->end();?>
    </div>
</div>
