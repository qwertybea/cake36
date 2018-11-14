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
            <td>
                <h4><?= __('Visiteur') ?></h4>
                <ul>
                    <li><?= __('Regarder les documents') ?></li>
                    <li><?= __('Regarder les profiles des créateurs') ?></li>
                    <li><?= __('Créer un compte créateur') ?></li>
                </ul>
                
                <h4><?= __('créateur non vérifier') ?></h4>
                <ul>
                    <li><?= __('Comme visiteur moins la création d\'un compte') ?></li>
                    <li><?= __('Ajouter un document à ses favoris.') ?></li>
                    <li><?= __('Vérifier son compte.') ?></li>
                </ul>
                <h4><?= __('créateur') ?></h4>
                <ul>
                    <li><?= __('Comme créateur non vérifier') ?></li>
                    <li><?= __('Ajouter/modifier/delete un document (juste ceux qui lui appartiennent).') ?></li>
                </ul>
                <h4><?= __('admin') ?></h4>
                <ul>
                    <li><?= __('Comme créateur') ?></li>
                    <li><?= __('Peut modifier/delete les document de tous le monde') ?></li>
                    <li><?= __('Peut voir les document non puplier de tous le monde') ?></li>
                </ul>
            </td>
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
        <tr>
            <th scope="row"><?= __('Test Coverage') ?></th>
            <td><?= $this->Html->link(__('Covergae'), '/coverage/index.html') ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Problèmes') ?></th>
            <td>
                <p>La traduction des bases de données marchait avec MySql mais pas avec Sqlite.</p>
                <p>Les mots de passes des utilisateur déja présent devrait être '123'.</p>
            </td>
        </tr>
    </table>
</div>