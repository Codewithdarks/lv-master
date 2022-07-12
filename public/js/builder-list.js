$(document).ready(function () {
    $(function () {
        $(".table").DataTable({
            processing: false,
            serverSide: false,
            ajax: URL,
            columns: [
                {data: 'name', name: 'name'},
                {data: 'funnel_id', name: 'funnel_id'},
                {data: 'published', name: 'published'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        $(document).on('click','.delete-page-confirm',function(e){
            //e.preventDefault();
            if (confirm("Are you sure to delete the Funnel?") == true) {
                return true;
            } else {
                return false;
            }
        });

        $(document).ready(function() {
            $(document).DataTable( {
                select: {
                    style: 'multi'
                }
            } );
        } );

    });
});
