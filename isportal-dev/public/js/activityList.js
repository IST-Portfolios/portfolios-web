/**
 * Created by John PC on 26-02-2016.
 */

$(document).ready(function(){

    var id;

    $("tr").click(function(){
        id = $(this).data("id");
        $("#myModalLabel").html( $(this).data("title"));
        $("#objectives").html($(this).data("objectives"));
        $('#vacancies').html("Vacancies: " +$(this).data("vacancies"));
        $("#description").html($(this).data("description"));
        $('#creator').html($(this).data('creator') + ' - author.');

        if($(this).hasClass("already")){
            $("#submitBtn").html("Go To Enrollments");
            $("#submitBtn").attr('class','btn btn-warning');
        }
        else{
            $("#submitBtn").html("Enroll");
            $("#submitBtn").attr('class','btn btn-primary');
        }

    });

    $("#submitBtn").click(function(){
        var url;
        if($(this).hasClass("btn-warning")){
            window.location.href="/enrollments";
        }
        else{

            $.ajax({
                type: 'post',
                url: "/prepareEnrollment",
                data:{
                    id: id
                },
                success: function(response){
                    if(response['response'] == 'ok'){
                            window.location.href = response['url'];
                    }
                    else{
                        alert("Error: Could not register your enrollment");
                    }
                }
            });
        }

    });


});