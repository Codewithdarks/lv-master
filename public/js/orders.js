$(document).ready(function () {
    $(function () {
        $(".table").DataTable({
            processing: false,
            serverSide: false,
            ajax: URL,
            columns: [
                {data: 'shopify_order_name', name: 'shopify_order_name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'total_price', name: 'total_price', render: $.fn.dataTable.render.number(',', '.', 2,'$')},
                {data: 'orders_status', name: 'orders_status'},
                {data: 'items', name: 'items'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
});
