$(document).ready(function () {
    // The path to action from CakePHP is in urlToLinkedListFilter 
    $('#country-id').on('change', function () {
        var country_id = $(this).val();
        if (country_id) {
            $.ajax({
                url: urlToLinkedListFilter,
                data: 'country_id=' + country_id,
                success: function (regions, b, c) {
                    console.log(regions);
                    console.log(b);
                    console.log(c);
                    $select = $('#region-id');
                    $select.find('option').remove();
                    $.each(regions, function (key, value)
                    {
                        console.log(value);
                        $.each(value, function (childKey, childValue) {
                            console.log(childValue);
                            $select.append('<option value=' + childValue.id + '>' + childValue.name + '</option>');
                        });
                    });
                }
            });
        } else {
            $('#region-id').html('<option value="">Select Category first</option>');
        }
    });
});


