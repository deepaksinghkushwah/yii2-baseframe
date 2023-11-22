$(document).ready(function () {
    $('#department-state_id, #department-district_id').select2({
        theme: "bootstrap",
        width: '100%'
    });
    $('#department-state_id').on('select2:select', function (e) {
        var state_id = e.params.data.id;        
        if (state_id !== "") {
            $.ajax({
                url: $('#getDistrictByStateID').val(),
                data: {state_id: state_id},
                dataType: 'json',
                type: 'post',
                success: function (data) {
                    $('#department-district_id').empty();
                    $.each(data.arr, function (index, item) {
                        //console.log(value);
                        var newOption = new Option(item.name, item.id, false, false);
                        $('#department-district_id').append(newOption).trigger('change');
                        //$('#department-district_id').append($("</option>")).text(value).val('value', index)
                    });

                }
            });
        }
    });
    
});
