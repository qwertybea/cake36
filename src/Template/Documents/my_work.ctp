<?php 

?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        
        <?php foreach ($documentTypes as $type): ?>
            <li>
                <?= $this->Html->link(__('New '.$type['type'].' document'), ['controller' => 'Documents', 'action' => 'add', $type->id]) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<div class="documents index large-9 medium-8 columns content">
    <h3><?= __('Documents') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">type</th>
                <th scope="col">Author</th>
                <th scope="col">name</th>
                <th scope="col">description</th>
                <th scope="col">other details</th>
                <th scope="col">document cover</th>
                <th scope="col">published</th>
                <th scope="col">deleted</th>
                <th scope="col">created</th>
                <th scope="col">modified</th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($documents as $document): ?>
            <tr>
                <td><?= $document->has('DocumentTypes') ? $document['DocumentTypes']['type'] : '' ?></td>
                <td><?= $document->has('Users') ? $this->Html->link($document['Users']['username'], ['controller' => 'Users', 'action' => 'view', $document['Users']['id']]) : '' ?></td>
                <td><?= h($document->name) ?></td>
                <td><?= h($document->description) ?></td>
                <td><?= h($document->other_details) ?></td>
                <td><?= h($document->document_cover) ?></td>
                <td><?= h($document->published) ?></td>
                <td><?= h($document->deleted) ?></td>
                <td><?= h($document->created) ?></td>
                <td><?= h($document->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $document->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $document->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete # {0}?', $document->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
</div>