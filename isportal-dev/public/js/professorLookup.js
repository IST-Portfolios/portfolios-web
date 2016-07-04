/**
 * Created by joao on 3/13/16.
 */

var activities;
var users;
var enrollments;
var setup = false;


$(function(){

    fetchAll();

    $("#searchBtn").click(function(){
        var val = $("#model").val();
        callFunction(val);

    });

    $("#model").on("change", function(){
        var val = $(this).val();
        prepareView(val);
    });

});

function fetchAll(){
    $.get('/getAll',function(result){
        activities = result.activities;
        users = result.users;
        enrollments = result.enrollments;
        setup = true;
        setActivityFilter();
        showActivityResults(activities);
    });
}

function prepareView( val ){
    switch(val){
        case "activity":
            setActivityFilter();
            updateActivityQuery();
            break;
        case "user":
            setUserFilter();
            updateUserQuery();
            break;
        case "enrollment":
            setEnrollmentFilter();
            break;
    }
}


function callFunction(val){
    switch(val){
        case "activity":
            updateActivityQuery();
            break;
        case "user":
            updateUserQuery();
            break;
        case "enrollment":
            setEnrollmentFilter();
            break;
    }
}

/**
 * Setting filters
 */

function setActivityFilter(){
    $("#filter option").remove();
    var filter = $("#filter");
    $(
        "<option value='id'>ID</option>" +
        "<option value='title'>Title</option>" +
        "<option value='creator'>Creator</option>"
    ).appendTo(filter);

}

function setUserFilter(){
    $("#filter option").remove();
    var filter = $("#filter");
    $(
        "<option value='id'>ID</option>" +
        "<option value='name'>Name</option>" +
        "<option value='email'>Email</option>"
    ).appendTo(filter);
}

function setEnrollmentFilter(){
    $("#filter option").remove();
}


/**
 * Update Queries
 */

function updateQuery(){
    callFunction($("#model").val());
}

function updateUserQuery(){

    var filter = $('#filter').val();
    var query = $('#search').val();



    if(query.length == 0){
        showUserResults(users);
        return;
    }

    switch(filter){
        case 'name':
            queryUserName(query);
            break;
        case 'email':
            queryUserEmail(query);
            break;
        case 'id':
            queryUserID(query);
            break;
    }

}

function updateActivityQuery(){

    var filter = $('#filter').val();
    var query = $('#search').val();



    if(query.length == 0){
        showActivityResults(activities);
        return;
    }

    switch(filter){
        case 'id':
            queryActivityId(query);
            break;
        case 'title':
            queryActivityTitle(query);
            break;
        case 'creator':
            queryActivityCreator(query);
            break;
    }

}

/**
 * Presentation of results
 * @param results
 */

function showUserResults(results){
    $("#tableBody tr").remove();
    var tbody = $("#tableBody");

    $("#tableHeading tr").remove();
    var thead  = $("#tableHeading");
    $(
        "<tr>"
        + "<th>Name</th>"
        + "<th>Email</th>"
        + "<th>Type</th>"
        + "</tr>"
    ).appendTo(thead);

    for(var i = 0; i < results.length; i++){
        var u  = results[i];
        //  var creator = users.filter(function(o){ return o.id == a.creator_id}) ;

        $("<tr>" +
            "<td>" + u.name + "</td>" +
            "<td>" + u.email + "</td>" +
            "<td>" + u.type + "</td>" +

            "</tr>").appendTo(tbody);
    }
}

/**
 * Shows activities present in results
 * @param results
 */
function showActivityResults(results){

    $("#tableBody tr").remove();
    var tbody = $("#tableBody");

    $("#tableHeading tr").remove();
    var thead  = $("#tableHeading");
    $(
        "<tr>"
        + "<th>ID</th>"
        + "<th>Title</th>"
        + "<th>Creator</th>"
        + "</tr>"
    ).appendTo(thead);

    for(var i = 0; i < results.length; i++){
        var a  = results[i];
        var creator = users.filter(function(o){ return o.id == a.creator_id}) ;

        $("<tr>" +
            "<td>" + a.id + "</td>" +
            "<td>" + a.title + "</td>" +
            "<td>" + creator[0].name + "</td>" +

            "</tr>").appendTo(tbody);
    }
}

/**
 * Given a name shows results that have that name present
 * @param name
 */
function queryUserName(name){
    var results = users.filter(function(o){
        if(o.name.toLowerCase().indexOf(name.toLowerCase()) > - 1){
            return o;
        }
    });
    showUserResults(results);
}

function queryUserEmail(email){
    var results = users.filter(function(o){
        if(o.email.toLowerCase().indexOf(email.toLowerCase()) > - 1){
            return o;
        }
    });
    showUserResults(results);
}

function queryUserID(id){
    var results = users.filter(function(o){
        return o.id == id;
    });
    showUserResults(results);
}

function queryActivityTitle(title){
    var results = activities.filter(function(o){
        if(o.title.toLowerCase().indexOf(title.toLowerCase()) > - 1){
            return o;
        }
    });
    showActivityResults(results);
}

function queryActivityId(id){
    var results = activities.filter(function(o){
        return o.id == id;
    });
    showActivityResults(results);
}

function queryActivityCreator(creator){
    var usersWithName = users.filter(function(o){
        if(o.name.toLowerCase().indexOf(creator.toLowerCase()) > - 1){
            return o;
        }
    });

    var results = [];
    for(var i = 0; i < usersWithName.length; i++ ){
        var matched_activities = activities.filter(function(o){
            return o.creator_id == usersWithName[i].id;
        });
        for(var j = 0; j < matched_activities.length; j++){
            results.push(matched_activities[j]);
        }
    }
    showActivityResults(results);


}