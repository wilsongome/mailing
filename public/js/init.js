$(document).ready(function(){

    $('.btn-delete').click(function(event){
        if(!confirm("Do you want to remove it?")){
            event.preventDefault();
        }
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
});