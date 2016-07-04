/**
 * Created by joao on 3/9/16.
 */

$(function(){

    var context;

    $("li").click(function(){
        li = $(this);
        context = li.data("id");
        $("#modalTitle").html("Editing: '" + li.data("title")  + "'");
        $("#title").val(li.data("title"));
        $("#objectives").val(li.data("objectives"));
        $("#description").val(li.data("description"));
        $("#vacancies").val(li.data("vacancies"));

        $("form").attr("action", '/changeActivity/' + li.data('id') );
    })

})