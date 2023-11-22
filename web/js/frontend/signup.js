$(document).ready(function () {
    $('#userprofile-country_id').on('change', function () {
        var countryId = $(this).val();
        $.ajax({
            url: $('#getCountyUrl').val(),
            data: {country_id: countryId},
            dataType: 'json',
            
            success: function (data) {
                $('#userprofile-state_id').empty();
                $('#userprofile-city_id').empty();
                if (data.items.length > 0) {
                    $.each(data.items, function (index, item) {
                        $('#userprofile-state_id').append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                }
            }
        });
    });
    
    $('#userprofile-state_id').on('change', function () {
        var countyId = $(this).val();
        $.ajax({
            url: $('#getCityUrl').val(),
            data: {county_id: countyId},
            dataType: 'json',
            
            success: function (data) {
                $('#userprofile-city_id').empty();
                if (data.items.length > 0) {
                    $.each(data.items, function (index, item) {
                        $('#userprofile-city_id').append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                }
            }
        });
    });
});