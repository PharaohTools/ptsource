done = false ;
max = 0 ;

function changeModule(element) {
    module = $("#new_step_module_selector").find(":selected").text() ;
    console.log("one") ;
    selectoptions = window.steps[module] ;
    console.log("two") ;
    window.htmlzy  = '<select onchange="changeStepTypeSelector(this.value)" id="new_step_type_selector" name="new_step_type_selector">' ;
    window.htmlzy += '  <option value="">-- Select Step Type --</option>' ;
    console.log("three") ;
    console.log(selectoptions) ;
    for (var key in selectoptions) {
        window.htmlzy += '  <option value="'+key+'">'+key+'</option>';    }
    console.log("four") ;
    window.htmlzy += '</select>' ;
    console.log("five") ;
    console.log(window.htmlzy) ;
    $('#new_step_type_selector_wrap').html(window.htmlzy);
}

function changeStepTypeSelector(element) {
    module = $("#new_step_module_selector").find(":selected").text() ;
    if (module == "Plugin") {
        displayStepField();
        return;
    }
    html = '<a class="btn btn-info" onclick="displayStepField()">Add Step</a>' ;
    $('#new_step_button_wrap').html(html);
}

function displayStepField() {
    steptype = $("#new_step_type_selector").find(":selected").text() ;
    module = $("#new_step_module_selector").find(":selected").text() ;
    field = window.steps[module][steptype] ;
    console.log("field is");
    console.log(field);
    hash = "1234567890" ;
    hash = Math.random() ;
    hash = hash * 10000000000 ;
    if (typeof(field.name) == "undefined") { field.name = module; }

    html  = '<div class="col-sm-10" id="step-'+hash+'">' ;
    html += '  <h4>'+field.name+'</h4>' ;
    html += '  <input type="hidden" id="steps['+hash+'][module]" name="steps['+hash+'][module]" value="'+module+'" />' ;
    html += '  <input type="hidden" id="steps['+hash+'][steptype]" name="steps['+hash+'][steptype]" value="'+steptype+'" />' ;
    if (module == "Plugin") {
        field = field["buildconf"];
        var i;
        for (i = 0; i < field.length; i++) { 
            if (field[i]["type"] = "text")
                html += '  <label>'+field[i]["name"]+'</label>';
                html += '  <input type="text" id="steps['+hash+']['+field[i]["name"]+']" name="steps[' +hash+']['+field[i]["name"]+']" value="'+field[i]["value"]+'" class="form-control" />';
        }
    }
    else if (field.type == "textarea") {
        html += '  <textarea id="steps['+hash+']['+field.slug+']"' ;
        html += ' name="steps['+hash+']['+field.slug+']" class="form-control">' ;
        html += '  </textarea>' ;
    }
    else if (field.type == "text") {
        html += '  <input type="text" id="steps['+hash+']['+field.slug+']" name="steps[' +hash+']['+field.slug+']" class="form-control" />' ;
    }
    html += '  <a class="btn btn-warning" id="deletestep" data-target="step-'+hash+'" onclick="deleteStepField('+hash+')" >Delete Step</a>' ;//
    html += '</div>' ;

    $('#new_step_wrap').append(html);
}

function deleteStepField(hash) { alert('step-'+hash);
    
    $(document).ajaxComplete(function() {
    
    });
   
   $('#new_step_wrap ').remove( '#step-'+hash );

    
    
    //$('#step-'+hash).append(" fgfdgfd");
    //$('#step-'+hash).html(" fgfdgfd");
    
    /*$(document).ready(function(){
        $('#step-'+hash).html("");
    });*/
    /*html  = '<h4>'+field.name+'</h4>' ;
    $('#new_step_wrap').html(html);
    /*html += '<a class="btn btn-alert" onclick="deleteStepField(hash)">Delete Step</a>' ;*/
    
}


$(document).ready(function(){ //'+$(this).data("target")
    $('#deletestep').live("click", function(event) { alert("new link clicked!");});
    //$().css("display")
});
/*
$(document).ajaxComplete(function() {
  $('#'+$(this).data("target")).html(" "); //simply rebind missing links
});*/



$(document).ajaxComplete(function() {
    
    });
    