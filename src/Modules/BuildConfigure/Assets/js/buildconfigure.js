done = false ;
max = 0 ;

function changeModule(element) {
    module = $("#new_step_module_selector").find(":selected").text() ;
    console.log("one") ;
    if (module == "nomoduleselected") {
        $('#new_step_type_selector_wrap').html("<p></p>"); }
    else {
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
        $('#new_step_type_selector_wrap').html(window.htmlzy); }
}

function changeStepTypeSelector(element) {
    html = '<a class="btn btn-info" onclick="displayStepField()">Add Step</a>' ;
    $('#new_step_button_wrap').html(html);
}

function toggleConfSetting(toggler, element) {
    sel = $("#"+element) ;
    sliderFields = sel.find(".sliderFields");
    if (sliderFields.css('display') == 'none') {
        $(toggler).removeClass("glyphicon glyphicon-triangle-bottom");
        $(toggler).addClass("glyphicon glyphicon-triangle-right");
        sliderFields.slideDown(); }
    else {
        $(toggler).removeClass("glyphicon glyphicon-triangle-right");
        $(toggler).addClass("glyphicon glyphicon-triangle-bottom");
        sliderFields.slideUp();}
}

function toggleViewConfSetting(element) {
    sel = $("#"+element) ;
    if (sel.css('display') == 'none') {
        sliderFields.slideDown(); }
    else {
        sliderFields.slideUp();}
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
    hash = hash.toString().replace(".", "") ;
    html = "" ;

   if (module == "ConditionalStepRunner" || module == "Plugin") {
        html  = '<li class="form-group ui-state-default ui-sortable-handle" id="step'+hash+'">' ;
        html += '  <div class="col-sm-2">' ;
        html += '    <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>' ;
        html += '  </div>';
        html += '  <div class="col-sm-10">' ;
        html += '   <div class="col-sm-12">' ;
        html += '    <h4>'+module+'</h4>' ;
        html += '    <input type="hidden" id="steps['+hash+'][module]" name="steps['+hash+'][module]" value="'+module+'" />' ;
        html += '    <input type="hidden" id="steps['+hash+'][steptype]" name="steps['+hash+'][steptype]" value="'+steptype+'" />' ;
        var i; console.log(field);
        for (i = 0; i < field.length; i++) {
        	html += '    <h5>'+field[i].name+'</h5>' ;
            if (field[i]["type"] == "text") { console.log(field[i]);
      			html += ' <input type="text" id="steps['+hash+']['+field[i].slug+']"' ;
       			html += ' name="steps['+hash+']['+field[i].slug+']" />' ;
            }
            if (field[i]["type"] == "password") { console.log(field[i]);
      			html += ' <input type="password" id="steps['+hash+']['+field[i].slug+']"' ;
       			html += ' name="steps['+hash+']['+field[i].slug+']" />' ;
            }
            if (field[i]["type"] == "textarea") { console.log(field[i]);
      			html += '<textarea id="steps['+hash+']['+field[i].slug+']"' ;
       			html += ' name="steps['+hash+']['+field[i].slug+']" >' ;
       			html += '</textarea>' ;
            }
            if (field[i]["type"] == "dropdown") { console.log(field[i]);
            	html += '<select id="steps['+hash+']['+field[i].slug+'] name="steps['+hash+']['+field[i].slug+']>';
            	$.each(field[i].data, function(index, value) { console.log(index);
					html += '<option value="'+index+'">'+value+'</option>';
				});
            	html += '</select>';
            }
        }
        html += '  </div>' ;
        html += '   <div class="col-sm-12">' ;
        html += '    <a class="btn btn-warning" onclick="deleteStepField('+hash+')">Delete Step</a>' ;
        html += '  </div>' ;
        html += '  </div>' ;
        html += ' </li>';
        }

   if (field.type == "textarea") {
        html  = '<li class="form-group ui-state-default ui-sortable-handle" id="step'+hash+'">' ;
        html += '  <div class="col-sm-2">' ;
        html += '    <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>' ;
        html += '  </div>';
        html += '  <div class="col-sm-10">' ;
        html += '   <div class="col-sm-12">' ;
        html += '    <h4>'+field.name+'</h4>' ;
        html += '    <input type="hidden" id="steps['+hash+'][module]" name="steps['+hash+'][module]" value="'+module+'" />' ;
        html += '    <input type="hidden" id="steps['+hash+'][steptype]" name="steps['+hash+'][steptype]" value="'+steptype+'" />' ;
        html += '    <textarea id="steps['+hash+']['+field.slug+']"' ;
        html += ' name="steps['+hash+']['+field.slug+']" >' ;
        html += '    </textarea>' ;
        html += '  </div>' ;
        html += '   <div class="col-sm-12">' ;
        html += '    <a class="btn btn-warning" onclick="deleteStepField('+hash+')">Delete Step</a>' ;
        html += '  </div>' ;
        html += '  </div>' ;
        html += ' </li>'; }

    else if (field.type == "text") {
        html  = '<li class="form-group ui-state-default ui-sortable-handle" id="step'+hash+'">' ;
        html += '  <div class="col-sm-2">' ;
        html += '    <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>' ;
        html += '  </div>';
        html += '<div class="col-sm-10">' ;
        html += '   <div class="col-sm-12">' ;
        html += '  <h4>'+field.name+'</h4>' ;
        html += '  <input type="hidden" id="steps['+hash+'][module]" name="steps['+hash+'][module]" value="'+module+'" />' ;
        html += '  <input type="hidden" id="steps['+hash+'][steptype]" name="steps['+hash+'][steptype]" value="'+steptype+'" />' ;
        html += "  <input type='text' id='steps[" +'"'+hash+'"'+ ']["'+field.slug+'"]'+"' name='steps[" +'"'+hash+'"'+ '"]["'+field.slug+'"]'+' />' ;
        html += '  <a class="btn btn-warning" onclick="deleteStepField('+hash+')">Delete Step</a>' ;
        html += '  </div>' ;
        html += '   <div class="col-sm-12">' ;
        html += '    <a class="btn btn-warning" onclick="deleteStepField('+hash+')">Delete Step</a>' ;
        html += '  </div>' ;
        html += '  </div>' ;
        html += ' </li>'; }

    else if (field.type == "boolean") {
        html  = '<li class="form-group ui-state-default ui-sortable-handle" id="step'+hash+'">' ;
        html += '  <div class="col-sm-2">' ;
        html += '    <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>' ;
        html += '  </div>';
        html += '<div class="col-sm-10">' ;
        html += '   <div class="col-sm-12">' ;
        html += '  <h4>'+field.name+'</h4>' ;
        html += '  <input type="hidden" id="steps['+hash+'][module]" name="steps['+hash+'][module]" value="'+module+'" />' ;
        html += '  <input type="hidden" id="steps['+hash+'][steptype]" name="steps['+hash+'][steptype]" value="'+steptype+'" />' ;
        html += '  <input type="checkbox" id="steps['+hash+'][data]" name="steps['+hash+'][data]" />' ;
        html += '  </div>' ;
        html += '   <div class="col-sm-12">' ;
        html += '    <a class="btn btn-warning" onclick="deleteStepField('+hash+')">Delete Step</a>' ;
        html += '  </div>' ;
        html += '  </div>' ;
        html += ' </li>'; }

    $("#sortableSteps").append(html);
    // $('#new_step_wrap').html(html);
}

function deleteStepField(hash) {
    $('#step'+hash).remove();
}