$(document).ready(function(){

    $("#editMotivation").click(function(){
        var previousMotivation = $("#motivation").html();
        $("#new_motivation").html(previousMotivation);
    });

    $("#cancelEnrollment").click(function(){
        window.location.href="/activity";
    });

    $("#priority").val(1);



    $("#cancelBtn").click(function(){
        location.reload();
    });

    $("#saveChangesBtn").click(function(){
        var priorities = ["1","2","3"];

        var values = [];

        $(document).find("input").each(function(){
            var obj_aux = {};
            obj_aux.id = $(this).closest('tr').data('id');
            obj_aux.priority = $(this).val();
            values.push(obj_aux);
        });
        var priorities_aux = priorities;
        for(i = 0; i < values.length; i++){
            console.log(values);
            var index = priorities_aux.indexOf(values[i].priority);
            if( index == -1){
                alert("Error in priority assignment");
                return false;
            }
            else{
                priorities_aux.splice(index,1);
            }
        }

        $.post('/changePriorities' , { changes:values }, function(response){
            if(response["response"] == "ok"){
                alert("success");
                location.reload();
            }
        });
    });

    $("#editBtn").click(function(){
        $(this).hide();
        $("#saveChangesBtn").show();
        $("#cancelBtn").show();
        $("#table-body").find('tr').each(function(){
            var td = $(this).find('td')[0];
            var value = td.innerHTML;
            td.innerHTML = "";
            $('<input type=number value="'+ value +'" onKeyUp="verifyNumber(this)" >').appendTo(td);
        });
    });


    $(".deleteBtn").click(function(){
        var id = $(this).closest("tr").data('id');

        $.ajax({
            type: 'post',
            url: '/deleteEnrollment',
            data:{
                id: id
            },
            success: function(response){
                if(response['response'] == 'ok'){
                    location.reload();
                }
                else{
                    alert('Error occurred');
                }
            }
        });
    });
});

function verifyNumber(elem){
    if( elem.value >3 ){
        elem.value = 3;
    }
    else if(elem.value <= -1){
        elem.value=1;
    }
    else if(elem.value == 0){
        elem.value="";
    }
}