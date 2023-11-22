$(document).ready(function () {
    $('#userprofile-department_id').select2({
        theme: "bootstrap",
        width: '100%',
        minimumInputLength: 1,
        ajax: {
            url: $('#getAllDepartmentURL').val(),
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        },
    });    
    
    $('#userprofile-department_id').on('select2:select', function () {
        var itemID = $(this).val();
        $.ajax({
            url: $('#getDepartmentPositionURL').val(),
            data: {department_id: itemID},
            dataType: 'json',
            
            success: function (data) {
                $('#userprofile-position_id').empty();
                if (data.items.length > 0) {
                    $.each(data.items, function (index, item) {
                        $('#userprofile-position_id').append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                }
            }
        });
    });
    
    
});
