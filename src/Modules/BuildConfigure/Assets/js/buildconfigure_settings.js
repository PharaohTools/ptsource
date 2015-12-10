function displayBuildConfigureSettingsFieldset(targetmod, fieldset) {

    console.log("i am the daver raver");
    console.log(build_settings_fieldsets) ;

    fields = build_settings_fieldsets[targetmod][fieldset]  ;

    console.log("the fields are");
    console.log(fields);

    field_hash = getNewHash() ;
    console.log("the current count is being mocked, we need to calculate a real int for this ");
    console.log(fields);

    html = "" ;

    fieldset_fields = fields[fieldset] ;

    html += '<div class="col-sm-12" id="fieldset_'+targetmod+'_'+fieldset+'_'+field_hash+'">' ;

    for (field in fieldset_fields) {

        console.log("the field is");
        console.log(field);

        if (fieldset_fields[field]["type"] == "textarea") {
            html += '  <div class="col-sm-12">' ;
            html += '    <h4>'+field+'</h4>' ;
            html += '  </div>' ;
            html += '  <div class="col-sm-12">';
            html += '    <textarea id="settings['+targetmod+']['+fieldset+']['+field_hash+']['+field+']" name="settings['+targetmod+']['+fieldset+']['+field_hash+']['+field+']" class="form-control" ></textarea>' ;
            html += '  </div>' ; }

        else if (fieldset_fields[field]["type"] == "text") {
            html += '<div class="col-sm-12">' ;
            html += '    <h4>'+field+'</h4>' ;
            html += '</div>' ;
            html += '<div class="col-sm-12">';
            html += '    <input type="text" id="settings['+targetmod+']['+fieldset+']['+field_hash+']['+field+']" name="settings['+targetmod+']['+fieldset+']['+field_hash+']['+field+']" class="form-control" />' ;
            html += '</div>' ; }

        else if (fieldset_fields[field]["type"] == "boolean") {
            html += '<div class="col-sm-12">' ;
            html += '  <h4>'+field+'</h4>' ;
            html += '</div>' ;
            html += '<div class="col-sm-12">';
            html += '  <input type="checkbox" id="settings['+targetmod+']['+fieldset+']['+field_hash+']['+field+']" name="settings['+targetmod+']['+fieldset+']['+field_hash+']['+field+']" class="form-control" />' ;
            html += '</div>' ; }
    }

    html += '    <div class="col-sm-12">' ;
    html += '        <a class="btn btn-warning" onclick="deleteFieldsetField(\''+targetmod+'\', \''+fieldset+'\', \''+field_hash+'\')">Delete Fieldset</a>' ;
    html += '    </div>' ;

    html += '  </div>' ;

    console.log("looking for "+"#fieldsets_"+targetmod+"_"+fieldset) ;
    current = jQuery("#fieldsets_"+targetmod+"_"+fieldset);
    console.log(current) ;
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
        'div#fieldsets_PipeRunParameters_parameters.form-group '+
        'div#fieldset_PipeRunParameters_parameters_'+hash ;

    chosenElementCss = typeSelectCss + ' input.param_type' ;
    chosenElement = jQuery(chosenElementCss).val(newParamType) ;

    console.log("type select css set") ;
//    newParamType = jQuery(typeSelectCss+' select option:selected').val() ;
    console.log("new param type value is: "+newParamType+" , css is : " +typeSelectCss) ;
    if (newParamType=="text") {
        console.log("changing to text") ;
//        jQuery(typeSelectCss+' input.field_boolean').hide() ;
        console.log("dump textarea") ;
        jQuery(typeSelectCss+' div.field_textarea_param_options').hide() ;
        jQuery(typeSelectCss+' div.field_text_param_name').show() ;
        jQuery(typeSelectCss+' div.field_text_param_type').show() ;
        jQuery(typeSelectCss+' div.field_text_param_text').show() ; }
    else if (newParamType=="boolean") {
        console.log("changing to boolean") ;
        jQuery(typeSelectCss+' div.field_textarea_param_options').hide() ;
        jQuery(typeSelectCss+' div.field_text_param_name').show() ;
        jQuery(typeSelectCss+' div.field_text_param_type').show() ;
        jQuery(typeSelectCss+' div.field_text_param_default').show() ;
        console.log("hides done") ; }
    else if (newParamType=="textarea") {
        console.log("changing to textarea") ;
        jQuery(typeSelectCss+' div.field_textarea_param_options').show() ;
        jQuery(typeSelectCss+' div.field_text_param_name').show() ;
        jQuery(typeSelectCss+' div.field_text_param_type').show() ;
        jQuery(typeSelectCss+' div.field_text_param_default').hide() ;
        console.log("hides done") ; }
    else if (newParamType=="options") {
        console.log("changing to options") ;
        jQuery(typeSelectCss+' div.field_textarea_param_options').show() ;
        jQuery(typeSelectCss+' div.field_text_param_name').show() ;
        jQuery(typeSelectCss+' div.field_text_param_type').show() ;
        jQuery(typeSelectCss+' div.field_text_param_default').show() ;
        console.log("hides done") ; }
    console.log("end method") ;
}