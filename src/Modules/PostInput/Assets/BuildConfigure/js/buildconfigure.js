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
    html  = '<a class="btn btn-info" onclick="displayStepField()">Add Step</a>' ;
    $('#new_step_button_wrap').html(html);
}

function displayStepField() {
    steptype = $("#new_step_type_selector").find(":selected").text() ;
    module = $("#new_step_module_selector").find(":selected").text() ;
    field = window.steps[module][steptype] ;
    console.log("field is");
    console.log(field);
    hash = "1234567890" ;

    if (field.type == "textarea") {
        html  = '<h4>'+field.name+'</h4>' ;
        html += '<textarea id="'+field.slug+"_"+hash+'" name="'+field.slug+"_"+hash+'">' ;
        html += '</textarea>' ; }

    else if (field.type == "text") {
        html  = '<h4>'+field.name+'</h4>' ;
        html += '<input type="text" id="'+field.slug+"_"+hash+'" name="'+field.slug+"_"+hash+'" />' ; }

    $('#new_step_wrap').html(html);
}