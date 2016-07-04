/**
 * Created by John PC on 08-03-2016.
 */
$(function(){

    var context;

    $("tr").click(function (){
        var tr = $(this);
        var id = tr.data("id");
        var motivation = tr.data("motivation");
        var candidate = tr.data("candidate");
        var title = tr.data("title");

        $("#activityTitle").html("Activity: " + title);
        $("#candidateName").html("Candidate: " + candidate);
        $("#motivation").html(motivation);

        context = id;
    });

    $("#acceptBtn").click(function(){
        alert(context);
        $.post("/acceptEnrollment", {id:context}, function(response){
            if(response.response == "ok") {
                location.reload();
            }
            else if(response.response == 'err'){
                alert(response.err);
                location.reload();
            }
            else{
                alert("Occurred an error!");
                location.reload();
            }
        });
    });

    $("#rejectBtn").click(function(){
        $.post("/rejectEnrollment", {id:context}, function(response){
            if(response.response == "ok") {
                location.reload();
            }
            else if(response.response == 'err'){
                alert(response.err);
                location.reload();
            }
            else{
                alert("Occurred an error!");
                location.reload();
            }
        });
    });

});