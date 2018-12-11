<?php
echo $this->Html->script(['regions/index', 'back_to_top'], ['block' => 'scriptBottom']);
echo $this->Html->scriptBlock('var csrfToken = '.json_encode($this->request->getParam('_csrfToken')).';', ['block' => true]);
?>

<button onclick="topFunction()" id="toTop" title="Go to top"><i class="fa fa-chevron-up"></i></button>

<!-- <?= $this->form->control('csrfToken', ['type' => 'hidden', 'value' => $this->request->getParam('_csrfToken')]) ?> -->

<div class="container">
    <div class="row">
        <div class="panel panel-default regions-content" ng-app="app" ng-controller="RegionCRUDCtrl">
            <table>
                <tr>
                    <td width="100">ID:</td>
                    <td><input type="text" id="id" ng-model="region.id" /></td>
                </tr>
                <tr>
                    <td width="100">Name:</td>
                    <td><input type="text" id="name" ng-model="region.name" /></td>
                </tr>
                <tr>
                    <td width="100">country id:</td>
                    <td>
                        <?php 
                        echo $this->Form->control('country_id', [
                                'ng-model' => 'region.country_id', 
                                'options' => $countries
                            ]);
                        ?>
                    </td>
                </tr>
            </table>

                <br />
                <p style="color: green; font-size: 1.2em">{{message}}</p>
                <p style="color: red; font-size: 1.2em">{{errorMessage}}</p>
                <br />

            <span class="fa fa-eye"></span>
            <a ng-click="getRegion(region.id)">Get Region</a>
            <br />
            <span class="fa fa-plus-circle"></span>
            <a ng-click="addRegion(region.name,region.country_id)">Add Region</a>
            <br />
            <span class="fa fa-pencil"></span>
            <a ng-click="updateRegion(region.id,region.name,region.country_id)">Update Region</a>
            <br />
            <span class="fa fa-trash"></span>
            <a ng-click="deleteRegion(region.id)">Delete Region</a>
            <br />
            <span class="fa fa-bars"></span>
            <a id="get_all_regs" ng-click="getAllRegions()">Get all Regions</a>
            <br/><br/>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Country</th>
                </tr>
                <tr ng-repeat="reg in regions">
                    <td>{{reg.id}}</td>
                    <td>{{reg.name}}</td>
                    <td>{{reg.country.name}}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

