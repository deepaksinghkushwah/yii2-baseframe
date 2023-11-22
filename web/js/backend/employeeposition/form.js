$(document).ready(function () {
    $('#employeeposition-department_id').select2({
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
    
});
