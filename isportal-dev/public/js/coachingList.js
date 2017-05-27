$(document).ready(function(){

	$(".addCoacherButton").click(function(e){
		e.preventDefault();
   		e.stopPropagation();
        window.location.href = '/addCoacherToTeam/' + $(this).data("teamid");
    });

    $(".addCoacheeButton").click(function(e){
		e.preventDefault();
   		e.stopPropagation();
        window.location.href = '/addCoacheeToTeam/' + $(this).data("teamid");
    });

	//Register the click event on the new buttons added
	$(document).on('click',".removeCoacherButton",function(){
		$.get("/removeCoacher/" + $(this).data("coacherid"), function(coacherId) {
			$("#coacherid_" + coacherId).remove();
		});
	});

	//Register the click event on the new buttons added
	$(document).on('click',".removeCoacheeButton",function(){
		$.get("/removeCoachee/" + $(this).data("coacheeid"), function(coacheeId) {
			$("#coacheeid_" + coacheeId).remove();
		});
	});

	//Initialize the modal for the Coaching Team Selected in the table
	$("tr").click(function() {
        $("#coachingTeamModalTitle").html($(this).data("name"));
        $("#email").html($(this).data("email"));
        $.get("/getCoachers/" + $(this).data("teamid"), function( coachersArray ) {
	  		coachersArray.forEach(function(coacher) {
	  			$('#coacherTableModal > tbody:last-child').append(
		            '<tr id="coacherid_' + coacher.id + '">'
		            +'<td>' + coacher.name + '</td>'
		            +'<td>' + coacher.email + '</td>'
		            +'<td><button type="button" class="btn btn-default removeCoacherButton" data-coacherid="' + coacher.id + '" >Remove</button></td>'
		            +'</tr>');
	  		});
		});
		$.get("/getCoachees/" + $(this).data("teamid"), function( coacheesArray ) {
	  		coacheesArray.forEach(function(coachee) {
	  			$('#coacheesTableModal > tbody:last-child').append(
		            '<tr id="coacheeid_' + coachee.id + '">'
		            +'<td>' + coachee.name + '</td>'
		            +'<td>' + coachee.email + '</td>'
		            +'<td><button type="button" class="btn btn-default removeCoacheeButton" data-coacheeid="' + coachee.id + '" >Remove</button></td>'
		            +'</tr>');
	  		});
		});
    });

    $('#coachingTeamModal').on('hidden.bs.modal', function () {
    	$('#coacheesTableModal > tbody:last-child').html("");
    	$('#coacherTableModal > tbody:last-child').html("");
    	location.reload();
	})

});