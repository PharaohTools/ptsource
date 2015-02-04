done = false ;
max = 0 ;

function changeModule(element) {
    module = $("#new_step_module_selector").find(":selected").text() ;
    console.log("one") ;
    selectoptions = window.steps[module] ;
    console.log("two") ;
    window.htmlzy  = '<select onchange="changeStepTypeSelector()" id="new_step_type_selector" name="new_step_type_selector">' ;
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

    if (field.type == "textarea") {
        html  = '<div class="col-sm-10">' ;
        html += '  <h4>'+field.name+'</h4>' ;
        html += '  <input type="hidden" id="steps['+hash+'][module]" name="steps['+hash+'][module]" value="'+module+'" />' ;
        html += '  <input type="hidden" id="steps['+hash+'][steptype]" name="steps['+hash+'][steptype]" value="'+steptype+'" />' ;
        html += '  <textarea id="steps['+hash+']['+field.slug+']"' ;
        html += ' name="steps['+hash+']['+field.slug+']" >' ;
        html += '  </textarea>' ;
        html += '  <a class="btn btn-warning" onclick="deleteStepField(hash)">Delete Step</a>' ;
        html += '</div>' ;
    }

    else if (field.type == "text") {
        html  = '<div class="col-sm-10">' ;
        html += '  <h4>'+field.name+'</h4>' ;
        html += '  <input type="hidden" id="steps['+hash+'][module]" name="steps['+hash+'][module]" value="'+module+'" />' ;
        html += '  <input type="hidden" id="steps['+hash+'][steptype]" name="steps['+hash+'][steptype]" value="'+steptype+'" />' ;
        html += "  <input type='text' id='steps[" +'"'+hash+'"'+ ']["'+field.slug+'"]'+"' name='steps[" +'"'+hash+'"'+ '"]["'+field.slug+'"]'+' />' ;
        html += '  <a class="btn btn-warning" onclick="deleteStepField(hash)">Delete Step</a>' ;
        html += '</div>' ; }

    $('#new_step_wrap').html(html);
}

function deleteStepField(hash) {
    html  = '<h4>'+field.name+'</h4>' ;
    html += '<a class="btn btn-alert" onclick="deleteStepField(hash)">Delete Step</a>' ;
    $('#new_step_wrap').html(html);
}