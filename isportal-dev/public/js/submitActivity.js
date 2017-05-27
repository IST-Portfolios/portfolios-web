/**
 * Created by andre on 24/05/17.
 */
$(function(){

    var context;


    $("select").on('change',function(){
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        if(valueSelected == "coaching") {
            $("#title").val("Coaching");
            $("#title").prop('readonly', true);
        } else {
            $("#title").val("");
            $("#title").prop('readonly', false);
        }
    })

})