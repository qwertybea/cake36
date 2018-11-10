
// i dont know how to do this server side
(function () {
    $.ajax({
        url: urlToGetCountries,
        dataType: "json",
        success:
            function (countries, b, c) {
                $select_add = $('#country-id-add');
                $select_edit = $('#country-id-edit');
                $select_add.find('option').remove();
                $select_edit.find('option').remove();
                $.each(countries, function (key, value)
                {
                    $.each(value, function (childKey, childValue) {
                        $select_add.append('<option value=' + childValue.id + '>' + childValue.name + '</option>');
                        $select_edit.append('<option value=' + childValue.id + '>' + childValue.name + '</option>');
                    });
                });
            }
    });
})();

function getRegions() {
    $.ajax({
        type: 'GET',
        url: urlToRestApi,
        dataType: "json",
        success:
                function (regions) {
                    console.log(regions);
                    var regionTable = $('#regionData');
                    regionTable.empty();
                    var count = 1;
                    $.each(regions.data, function (key, value)
                    {
                        var editDeleteButtons = '</td><td>' +
                                '<a href="javascript:void(0);" class="glyphicon glyphicon-edit" onclick="editRegion(' + value.id + ')"></a>' +
                                '<a href="javascript:void(0);" class="glyphicon glyphicon-trash" onclick="return confirm(\'Are you sure to delete data?\') ? regioonAction(\'delete\', ' + value.id + ') : false;"></a>' +
                                '</td></tr>';
                        regionTable.append('<tr><td>#' + count + '</td><td>' + value.name + '</td><td>' + value.country.name + editDeleteButtons);
                        count++;
                    });

                }
    });
}

/* Function takes a jquery form
 and converts it to a JSON dictionary */
function convertFormToJSON(form) {
    var array = $(form).serializeArray();
    var json = {};

    $.each(array, function () {
        json[this.name] = this.value || '';
    });

    return json;
}

/*
 $('#cocktailAddForm').submit(function (e) {
 e.preventDefault();
 var data = convertFormToJSON($(this));
 alert(data);
 console.log(data);
 });
 */

function regionAction(type, id) {
    id = (typeof id == "undefined") ? '' : id;
    var statusArr = {add: "added", edit: "updated", delete: "deleted"};
    var requestType = '';
    var regionData = '';
    var ajaxUrl = urlToRestApi;
    if (type == 'add') {
        requestType = 'POST';
        regionData = convertFormToJSON($("#addForm").find('.form'));
    } else if (type == 'edit') {
        requestType = 'PUT';
        regionData = convertFormToJSON($("#editForm").find('.form'));
        ajaxUrl = ajaxUrl + "/" + regionData.id;
    } else {
        requestType = 'DELETE';
        ajaxUrl = ajaxUrl + "/" + id;
    }

    if (regionData.name != '') {

        $.ajax({
            type: requestType,
            headers: {
                // 'X-CSRF-Token': $('[name="_csrfToken"]').val()
                'X-CSRF-Token': '5da692bc8b92ebb16c42655af955600ecd1ef16af67442dd4669080be9abe2a0c1ed778ca779413e923bad8f392132e3affe18f6b705db9f5e2b98276a9a03c9'
            },
            url: ajaxUrl,
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(regionData),
            success: function (msg) {
                if (msg) {
                    alert('Region data has been ' + statusArr[type] + ' successfully.');
                    getRegions();
                    $('.form')[0].reset();
                    $('.formData').slideUp();
                } else {
                    alert('Some problem occurred, please try again.');
                }
            }
        });

    } else {
        alert('You must input a name.');
    }
}

/*** à déboguer ... ***/
function editRegion(id) {
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: urlToRestApi+ "/" + id,
        success: function (data) {
            console.log(data);
            $('#idEdit').val(data.data.id);
            $('#nameEdit').val(data.data.name);
            $('#country-id-edit').val(data.data.country_id);
            $('#editForm').slideDown();
        }
    });
}