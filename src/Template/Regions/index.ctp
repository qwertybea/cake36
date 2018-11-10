<?php
$urlToRestApi = $this->Url->build('/api/regions', true);
$urlToGetCountries = $this->Url->build([
    "controller" => "Countries",
    "action" => "getCountries",
    "_ext" => "json"
        ]);
echo $this->Html->scriptBlock('var urlToRestApi = "' . $urlToRestApi . '";', ['block' => true]);
echo $this->Html->scriptBlock('var urlToGetCountries = "' . $urlToGetCountries . '";', ['block' => true]);
echo $this->Html->script(['regions/index', 'back_to_top'], ['block' => 'scriptBottom']);
?>

<button onclick="topFunction()" id="toTop" title="Go to top"><i class="fa fa-chevron-up"></i></button>

<div class="container">
    <div class="row">
        <div class="panel panel-default regions-content">
            <div class="panel-heading">Regions <a href="javascript:void(0);" class="glyphicon glyphicon-plus" id="addLink" onclick="javascript:$('#addForm').slideToggle();">Add</a></div>
            <div class="panel-body none formData" id="addForm">
                <h2 id="actionLabel">Add Region</h2>
                <form class="form" id="regionAddForm" enctype='application/json'>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" id="name"/>
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <select class="form-control" name="country_id" id="country-id-add">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-warning" onclick="$('#addForm').slideUp();">Cancel</a>
                    <a href="javascript:void(0);" class="btn btn-success" onclick="regionAction('add')">Add Region</a>
                    <!-- input type="submit" class="btn btn-success" id="addButton" value="Add region" -->
                </form>
            </div>
            <div class="panel-body none formData" id="editForm">
                <h2 id="actionLabel">Edit Region</h2>
                <form class="form" id="regionEditForm" enctype='application/json'>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" id="nameEdit"/>
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <select class="form-control" name="country_id" id="country-id-edit">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <input type="hidden" class="form-control" name="id" id="idEdit"/>
                    <a href="javascript:void(0);" class="btn btn-warning" onclick="$('#editForm').slideUp();">Cancel</a>
                    <a href="javascript:void(0);" class="btn btn-success" onclick="regionAction('edit')">Update Region</a>
                    <!-- input type="submit" class="btn btn-success" id="editButton" value="Update region" -->
                </form>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>country</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="regionData">
                    <?php
                    $count = 0;
                    foreach ($regions as $region): $count++;
                        ?>
                        <tr>
                            <td><?php echo '#' . $count; ?></td>
                            <td><?php echo $region['name']; ?></td>
                            <td><?php echo $region['country']['name']; ?></td>
                            <td>
                                <a href="javascript:void(0);" class="glyphicon glyphicon-edit" onclick="editRegion('<?php echo $region['id']; ?>')"></a>
                                <a href="javascript:void(0);" class="glyphicon glyphicon-trash" onclick="return confirm('Are you sure to delete data?') ? regionAction('delete', '<?php echo $region['id']; ?>') : false;"></a>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                    if ($count == 0) {
                        echo '<tr><td colspan="5">No region(s) found......</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

