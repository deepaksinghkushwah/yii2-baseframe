$(document).ready(function () {
    $('#department').select2({
        minimumInputLength: 1,
        width: '100%',
        ajax: {
            url: $('#searchDepartmentURL').val(),
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        },
    });

    $('#department').on('select2:select', function (e) {
        var departmentID = e.params.data.id;
        $.ajax({
            url: $('#searchPositionURL').val(),
            dataType: 'json',
            beforeSend: function(){
                $('.loading-gif').show();
            },
            data: {department_id: departmentID},
            success: function (data) {
                $('#position').empty();
                $('.loading-gif').hide();
                if (data.items.length > 0) {

                    $.each(data.items, function (index, item) {
                        var newOption = new Option(item.text, item.id, false, false);
                        $('#position').append(newOption);
                    })
                }
            }
        });

    });

    $('#position').on('change', function () {
        $.ajax({
            url: $('#searchEmployeeURL').val(),
            dataType: 'json',
            beforeSend: function(){
                $('.loading-gif').show();
            },
            data: {department_id: $('#department').val(), position_id: $('#position').val()},
            success: function (data) {
                $('.loading-gif').hide();
                if (data.items.length > 0) {
                    employees = data.items;
                }
            }
        });
    })
});

var app = new Vue({
    el: '#app',
    data() {
        return {
            message: 'Hello Vue!',
            employees: []
        }
    },
    methods: {
        callme() {
            this.employees.push({id: "1", text: "hello"});
        },
        searchEmployee() {
            var url = $('#searchEmployeeURL').val() + "?department_id=" + $('#department').val() + "&position_id=" + $('#position').val();
            fetch(url).then(response => response.json())
                    .then((data) => {
                        this.employees = data.items;
                    });
        }
    },
})