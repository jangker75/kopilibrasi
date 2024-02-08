<script>
    $(document).ready(function(){
        var oTable = $('#tableIndex').DataTable({
            dom: 'lBfrtip',
            processing: true,
            buttons : 
            [
                'excel', 'csv',
            ],
            language: {
                buttons: {
                    excel: "Export to Excel",
                    
                }
            }
        });
    })
</script>