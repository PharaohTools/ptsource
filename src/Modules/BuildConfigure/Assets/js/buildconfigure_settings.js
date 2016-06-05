function displayBuildConfigureSettingsFieldset(targetmod, fieldset) {

    fields = build_settings_fieldsets[targetmod][fieldset]  ;
    field_hash = getNewHash() ;
    html = "" ;
    fieldset_fields = fields[fieldset] ;

    html += '<div class="col-sm-12" class="fieldset" id="fieldset_'+targetmod+'_'+fieldset+'_'+field_hash+'">' ;

    for (field in fieldset_fields) {

        if (fieldset_fields[field]["type"] == "textarea") {
            html += '<div class="col-sm-12 wrap_'+field+'_'+field_hash+'">' ;
            html += '  <div class="col-sm-3">' ;
            html += '    <h4>'+field+'</h4>' ;
            html += '  </div>' ;
            html += '  <div class="col-sm-9">';
            html += '    <textarea class="form-control" id="settings['+targetmod+']['+fieldset+']['+field_hash+']['+field+']" name="settings['+targetmod+']['+fieldset+']['+field_hash+']['+field+']" class="form-control" ></textarea>' ;
            html += '  </div>' ;
            html += '</div>' ; }

        else if (fieldset_fields[field]["type"] == "text") {
            html += '<div class="col-sm-12 wrap_'+field+'_'+field_hash+'">' ;
            html += '  <div class="col-sm-3">' ;
            html += '    <h4>'+field+'</h4>' ;
            html += '  </div>' ;
            html += '  <div class="col-sm-9">';
            html += '    <input class="form-control" type="text" id="settings['+targetmod+']['+fieldset+']['+field_hash+']['+field+']" name="settings['+targetmod+']['+fieldset+']['+field_hash+']['+field+']"  />' ;
            html += '  </div>' ;
            html += '</div>' ; }

        else if (fieldset_fields[field]["type"] == "options") {
//            console.log("fields is");
//            console.log(fieldset_fields[field]) ;
            html += '<div class="col-sm-12 wrap_'+field+'_'+field_hash+'">'+"\n" ;
            html += '  <div class="col-sm-3">'+"\n" ;
            html += '    <h4>'+field+'</h4>'+"\n" ;
            html += '  </div>'+"\n" ;
            html += '  <div class="col-sm-3">'+"\n" ;
            html += '  <button aria-expanded="true" data-toggle="dropdown" id="dropdownMenu_'+field+'_'+field_hash+'" type="button" class="btn btn-info dropdown-toggle '+field+'"> '+"\n" ;
            html += '    Select Option '+"\n" ;
            html += '  </button>' +"\n" ;
//            html += '    <select class="'+field+'" onchange="'+field+'" id="settings['+targetmod+']['+fieldset+']['+field_hash+']['+field+']" name="settings['+targetmod+']['+fieldset+']['+field_hash+']['+field+']">';
            html += '     <ul aria-labelledby="dropdownMenu_'+field+'_'+field_hash+'" role="menu" class="dropdown-menu" >'+"\n" ;
//            html += '  <option value="">None</option>';
            for (option in fieldset_fields[field]["options"]) {
                changestring = "" ;
                if (typeof fieldset_fields[field]["js_change_function"] != 'undefined') {
                    changestring = ' onclick="'+fieldset_fields[field]["js_change_function"]+"('"+field_hash+"', '"+fieldset_fields[field]["options"][option]+"');\"" }
//                html += '    <option value="'+fieldset_fields[field]["options"][option]+'">'+fieldset_fields[field]["options"][option]+'</option>' ;
                html += '    <li role="presentation"> '+"\n" ;
//                html += '      <option value="'.$option.'" '.$selected_string.'>'.$option.'</option>'."\n" ;
                html += '      <a '+changestring+' tabindex="-1" role="menuitem">'+fieldset_fields[field]["options"][option]+'</a>'+"\n" ;
                html += '    </li> '+"\n" ;
                // onclick="changePipeRunParameterType(\''+field_hash+'\', \''+option+'\');"
            }
            html += '    </ul>'+"\n" ;
//            html += '    </select>';
            html += '  </div>'+"\n" ;
            html += '<div class="col-sm-6">'+"\n" ;
            html += '  <input type="text" class="text-left btn btn-success options_display" readonly="readonly" value=" - " />'+"\n" ;
            html += '</div>'+"\n" ;
            html += '  </div>'+"\n" ; }

        else if (fieldset_fields[field]["type"] == "boolean") {
            html += '<div class="col-sm-12 wrap_'+field+'_'+field_hash+'">' ;
            html += ' <div class="col-sm-3">' ;
            html += '  <h4>'+field+'</h4>' ;
            html += ' </div>' ;
            html += ' <div class="col-sm-9">';
            html += '  <input class="form-control" type="checkbox" id="settings['+targetmod+']['+fieldset+']['+field_hash+']['+field+']" name="settings['+targetmod+']['+fieldset+']['+field_hash+']['+field+']" />' ;
            html += ' </div>' ;
            html += '</div>' ; } }

    html += '    <div class="col-sm-12">' ;
    html += '        <a class="btn btn-warning" onclick="deleteFieldsetField(\''+targetmod+'\', \''+fieldset+'\', \''+field_hash+'\')">Delete Fieldset</a>' ;
    html += '    </div>' ;

    html += '  </div>' ;
    html += '  <script type="text/javascript">' ;
    html += '      $( document ).ready(function() {' ;
    html += '          changePipeRunParameterType("'+field_hash+'", "") ;' ;
    html += '      });' ;
    html += '  </script>' ;


//    console.log("looking for "+"#fieldsets_"+targetmod+"_"+fieldset) ;
    current = jQuery("#fieldsets_"+targetmod+"_"+fieldset);
//    console.log(current) ;
    current.append(html) ;

}



function deleteFieldsetField(targetmod, fieldset, hash) {
    delete_field = '#fieldset_'+targetmod+'_'+fieldset+'_'+hash ;
    console.log("deleting field "+delete_field)
    $(delete_field).remove();
}


function changePipeRunParameterType(hash, newParamType) {
    console.log("starting method") ;
    css = "#fieldset_PipeRunParameters_parameters_"+hash ;
    current = jQuery(css);
    console.log(current) ;
//    typeSelectCss = 'settings[PipeRunParameters][parameters]['+hash+'][param_type]' ;

    typeSelectCss =
        'div#slideyPipeRunParameters.form-group.confSettingsSlideySection ' +
        'div#fieldsets_PipeRunParameters_parameters.form-group ' ; //+
//        'div#fieldset_PipeRunParameters_parameters_'+hash ;

    chosenElementCss = typeSelectCss + ' input.param_type' ;
    chosenElement = jQuery(chosenElementCss).val(newParamType) ;

    console.log("type select css set") ;
//    newParamType = jQuery(typeSelectCss+' select option:selected').val() ;
    console.log("new param type value is: "+newParamType+" , css is : " +typeSelectCss) ;
    console.log("changing to text") ;
    if (newParamType=="text") {
        console.log("dump textarea") ;
        jQuery(typeSelectCss+' div.wrap_param_boolean_default_'+hash).hide() ;
        jQuery(typeSelectCss+' div.wrap_param_textarea_default_'+hash).hide() ;
        jQuery(typeSelectCss+' div.wrap_param_options_'+hash).hide() ;
        jQuery(typeSelectCss+' div.wrap_param_default_'+hash).show() ;
        jQuery(typeSelectCss+' div.wrap_param_name_'+hash).show() ;
        jQuery(typeSelectCss+' div.wrap_param_type_'+hash).show() ;
        jQuery(typeSelectCss+' div.wrap_param_text_'+hash).show() ;
        jQuery(typeSelectCss+' div.wrap_param_description_'+hash).show() ; }
    else if (newParamType=="boolean") {
        console.log("changing to boolean") ;
        jQuery(typeSelectCss+' div.wrap_param_default_'+hash).hide() ;
        jQuery(typeSelectCss+' div.wrap_param_textarea_default_'+hash).hide() ;
        jQuery(typeSelectCss+' div.wrap_param_options_'+hash).hide() ;
        jQuery(typeSelectCss+' div.wrap_param_name_'+hash).show() ;
        jQuery(typeSelectCss+' div.wrap_param_type_'+hash).show() ;
        jQuery(typeSelectCss+' div.wrap_param_boolean_default_'+hash).show() ;
        jQuery(typeSelectCss+' div.wrap_param_description_'+hash).show() ;
        console.log("hides done") ; }
    else if (newParamType=="textarea") {
        console.log("changing to textarea") ;
        jQuery(typeSelectCss+' div.wrap_param_default_'+hash).hide() ;
        jQuery(typeSelectCss+' div.wrap_param_options_'+hash).hide() ;
        jQuery(typeSelectCss+' div.wrap_param_boolean_default_'+hash).hide() ;
        jQuery(typeSelectCss+' div.wrap_param_textarea_default_'+hash).show() ;
        jQuery(typeSelectCss+' div.wrap_param_name_'+hash).show() ;
        jQuery(typeSelectCss+' div.wrap_param_type_'+hash).show() ;
        jQuery(typeSelectCss+' div.wrap_param_description_'+hash).show() ;
        console.log("hides done") ; }
    else if (newParamType=="options") {
        console.log("changing to options") ;
        jQuery(typeSelectCss+' div.wrap_param_boolean_default_'+hash).hide() ;
        jQuery(typeSelectCss+' div.wrap_param_textarea_default_'+hash).hide() ;
        jQuery(typeSelectCss+' div.wrap_param_options_'+hash).show() ;
        jQuery(typeSelectCss+' div.wrap_param_name_'+hash).show() ;
        jQuery(typeSelectCss+' div.wrap_param_type_'+hash).show() ;
        jQuery(typeSelectCss+' div.wrap_param_default_'+hash).show() ;
        jQuery(typeSelectCss+' div.wrap_param_description_'+hash).show() ;
        console.log("hides done") ; }
    else {
        console.log("no option set, hiding all but type") ;
        jQuery(typeSelectCss+' div.wrap_param_boolean_default_'+hash).hide() ;
        jQuery(typeSelectCss+' div.wrap_param_textarea_default_'+hash).hide() ;
        jQuery(typeSelectCss+' div.wrap_param_options_'+hash).hide() ;
        jQuery(typeSelectCss+' div.wrap_param_name_'+hash).hide() ;
        jQuery(typeSelectCss+' div.wrap_param_default_'+hash).hide() ;
        jQuery(typeSelectCss+' div.wrap_param_description_'+hash).hide() ;
        jQuery(typeSelectCss+' div.wrap_param_type_'+hash).show() ;
        console.log("hides done") ;

    }

    jQuery(typeSelectCss+' .options_display').val(newParamType) ;
    jQuery(typeSelectCss+' .options_display').show() ;
    console.log("end method") ;
}