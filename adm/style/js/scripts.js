var id ="";

function getId(elem) {
    id = $(elem).attr("id");
}


// $(function(){
// 	$(".toggle").click(function(){
// 		alert(id);
// 	});
// });

$(function(){
    $(".toggle").click(function(){
        $( "#extra-info-" + id ).toggle("normal").one('click', function(event) {
            $.ajax({
                // url: '/path/to/file',
                url: window.location.href,
                type: 'POST',
                // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
                data: {forum_id: id}
            })
            .done(function() {
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });

        });;
    });
});
