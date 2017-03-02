var id ="";
var data = "";

function getId(elem) {
    id = $(elem).attr("id");
}

$(function(){
    $(".toggle").click(function(){
        $( "#extra-info-" + id ).toggle("normal").one('click', function(event) {
            $.ajax({
                url: AJAX_GET_MORE,
                type: 'POST',
                data: {forum_id: id},
                success: function(data){
                    // alert(data);
                }
            })
            .done(function(data){
                console.log("success");
                console.log(data.toSource());
            })
            .fail(function(data,jqxhr,textStatus,errorThrown) {
                console.log("error");
            })
            .always(function(data) {
                console.log("complete");
            });

        });;
    });
});
