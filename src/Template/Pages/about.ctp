<?php ?>

<div class="users view large-12 medium-8 columns content">
    <h3><?= __('About this web site') ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= __('Justin') ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Course') ?></th>
            <td><?= __('420-5b7 MO Applications internet.<br>Automn of 2018, Collège Montmorency.') ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Steps') ?></th>
            <td><?= __('Ragarde la page d\'acceuil pour voir les documents intéreessant. Allez voir tous les document. Création d\'un compte pour pouvoir ajouter des document à sa liste de favoris. Activer son compte pour pouvoir ajouter des document') ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Database diagram') ?></th>
            <td>
            <?php 
                echo $this->Html->image("db_diagram.PNG", [
                    "alt" => "db_diagram",
                    "width" => "800px",
                    "height" => "800px"
                ]);
            ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?= __('link to database diagram') ?></th>
            <td><?= $this->Html->link(__('DB'), '/img/db_diagram.PNG') ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Github repository') ?></th>
            <td><a href="https://github.com/qwertybea/cake36">https://github.com/qwertybea/cake36</a></td>
        </tr>
    </table>
</div>