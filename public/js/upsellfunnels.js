$(document).ready(function () {
    $(function () {
        $(".table").DataTable({
            processing: false,
            serverSide: false,
            ajax: URL,
            columns: [
                {data: 'created_at', name: 'created_at'},
                {data: 'name', name: 'name'},
                {data: 'tag', name: 'tag'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    $(document).on('click','.dltfunnel',function(e){
        //e.preventDefault();
        if (confirm("Are you sure to delete the Funnel?") == true) {
            return true;
          } else {
            return false;
          }   
    });    
         
    });
});
