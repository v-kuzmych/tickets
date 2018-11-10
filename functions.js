$(document).ready(function () {
    PNotify.prototype.options.styling = "bootstrap3";
    PNotify.prototype.options.styling = "fontawesome";


    var action_buttons = 
        //'<button type="button" title="Приховати" class="btn btn-sm btn-primary" value="0" id="hideTicketButton"><span class="glyphicon glyphicon-eye-open"></span></button>'+
       // '<button type="button" title="Редагувати" class="btn btn-sm btn-success" id="editTicketButton"><span class="glyphicon glyphicon-pencil"></span></button>'+
        '<button type="button" title="Видалити" class="btn btn-sm btn-danger" id="deleteTicketButton"><span class="glyphicon glyphicon-remove"></span></button>';


    /* Викорисовуючи datatables створюємо табличку і присвоюємо індекси полям*/
    var table = $('#tickets-table').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Ukrainian.json"
        },
        ajax: {
            method: "POST",
            url: ajaxurl,
            data: {action: 'get_tickets_data'},
            dataSrc: ""
        },
        columns: [
            {title: 'Автор', data: 'author_url'},
            {title: 'К-сть опублікованих оголошень', data: 'count_posts'},
             {title: 'Код товару', data: 'post_id'},
            {title: 'Назва товару', data: 'post_url'},
            {title: 'Дата', data: 'date'},
            {title: 'Операції', defaultContent: action_buttons, orderable: false, width: "200px" }
        ]
    });


 $('#tickets-table tbody').on('click', '#deleteTicketButton',  function () {
        var data = table.row($(this).parents('tr')).data();
         $.ajax({
            method: "POST",
            url: ajaxurl,
            data: {
                action: "delete_ticket",
                post_id: data.post_id
            }
        })
            .done(function () {
                   console.log("delete done");
                   table.ajax.reload();

                new PNotify({
                    title: 'Виконано!',
                    text: 'Запис успішно видалено',
                    type: 'success'
                });
            })
            .fail(function () {
                new PNotify({
                    title: 'Помилка!',
                    text: 'Виникла помилка в процесі обробки запиту',
                    type: 'error'
                });
            })
    });


$('#tickets-table tbody').on('click', '#ticketStatusSelectorOptions a', function () {
        console.log(this);
        var new_status_hide = $(this).attr("value");
        var data = table.row($(this).parents('tr')).data();

       $.ajax({
            method: "POST",
            url: ajaxurl,
            data: {
                action: "update_status_post_hide",
                post_id: data.post_id,
                new_status_hide: new_status_hide
            }
        })
            .done(function () {
                console.log("update done");
                table.ajax.reload();
                new PNotify({
                    title: 'Виконано!',
                    text: 'Оголошення приховано',
                    type: 'success'
                });
            })
            .fail(function () {
                new PNotify({
                    title: 'Помилка!',
                    text: 'Виникла помилка в процесі обробки запиту',
                    type: 'error'
                });
            })
    });


});