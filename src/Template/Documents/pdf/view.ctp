
<div class="documents view large-9 medium-8 columns content">
    <h3><?= h($document->name) ?></h3>
    <?php
    if ($document->file->status) {
        echo $this->Html->image($document->file->path . $document->file->name, [
            "alt" => $document->file->name,
            "width" => "700px",
            'fullBase'   => true,
            'pathPrefix' => Cake\Core\Configure::read('App.imageBaseUrl')
        ]);
    }
    ?>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Document Type') ?></th>
            <td><?= $document->has('document_type') ? $document->document_type->type : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Author') ?></th>
            <td><?= $document->has('user') ? h($document->user->username) : '' ?></td>
        </tr>
        <!-- <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($document->name) ?></td>
        </tr> -->
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($document->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Other Details') ?></th>
            <td><?= h($document->other_details) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Country') ?></th>
            <td><?= h($document->country->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Region') ?></th>
            <td><?= h($document->region->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($document->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($document->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Published') ?></th>
            <td><?= $document->published ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h2>Content</h2>
        <?php 
        $text = $document['text_document']['text'];
        echo '<p>';
        foreach(preg_split("/((\r?\n)|(\r\n?))/", $text) as $line){
            echo $line.'<br>';
        } 
        echo '</p>';
        ?>
        
    </div>
</div>
