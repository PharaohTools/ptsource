<?php

Namespace Model;

class ConditionalStepRunnerAllOS extends BaseLinuxApp {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    public function __construct($params) {
        parent::__construct($params);
        $this->initialize();
    }

    public function getStepTypes() {
        return array_keys($this->getFormFields());
    }

    public function getFormFields() {
        $ff = array(
            "File Exist" => array(
            					array(
					                "type" => "dropdown",
					                "name" => "Base directory",
					                "slug" => "baseDirectory",
					                "data" => array( 'workspace' => 'Workspace',
					                				 'fullPath'  => 'Full Path' )),
					            array(
					                "type" => "text",
					                "name" => "File",
					                "slug" => "file" ),
					            array(
					                "type" => "textarea",
					                "name" => "Shell Data",
					                "slug" => "data-shelldata" )
					        ),
			"Days of week" => array(
            					array(
					                "type" => "dropdown",
					                "name" => "Days",
					                "slug" => "days",
					                "data" => array( 'weekdays' => 'Week Days',
					                				 'weekends'  => 'Week Ends' )),
					            array(
					                "type" => "textarea",
					                "name" => "Shell Data",
					                "slug" => "data-shelldata" )
					        )
        );
        return $ff ;
    }

    public function executeStep($step) {
        $loggingFactory = new \Model\Logging();
        $this->params["echo-log"] = true ;
        $logging = $loggingFactory->getModel($this->params) ;
		
		$stepDetails['module'] = 'Shell';
		$stepDetails['steptype'] = 'shelldata';
		$stepDetails['data'] = $step['data-shelldata'];
		
		$stepRunnerFactory = new \Model\StepRunner() ;
        $stepRunner = $stepRunnerFactory->getModel($this->params) ;
    	
    	
		if ( $step['steptype'] == "File Exist")
	    	if ($this->fileExist($step))    
	    		return $stepRunner->stepRunner($stepDetails, $this->params["item"]) ;
			else
				return true;
	    if ( $step['steptype'] == "Days of week")
	    	if ($this->daysOfWeek($step))
	    		return $stepRunner->stepRunner($stepDetails, $this->params["item"]) ;
			else
				return true;
	    
    }
	
	private function fileExist($step)
	{
		if ( $step['baseDirectory'] == 'workspace' )
        	$path=PIPEDIR.DS.$this->params['item'].DS.'workspace'.DS;
		else {
			$path = '';
		}
		$file=$step['file'];
		if(file_exists($path.$file)){
			return true;
		}
		else{
			$loggingFactory = new \Model\Logging();
        	$logging = $loggingFactory->getModel($this->params);
        	$logging->log(" File not found ", $this->getModuleName()) ;
			return false;
		}
	}
	
	private function daysOfWeek($step)
	{
		$today = getdate()['wday'];
		$day=$step['days'];
		$weekends = array(0,6);
		$weekdays = array(1,2,3,4,5);
		if ( $day == "weekdays" )
			if (in_array($today, $weekdays))
				return TRUE;
		if ( $day == "weekends" )
			if (in_array($today, $weekends))
				return TRUE;
		return FALSE;
		/*if     ($today == $day || $day == 'weekdays' ){ return TRUE; }
		elseif ($today == $day || $day == 'weekdays' ){ return TRUE; }
		elseif ($today == $day || $day == 'weekdays' ){ return TRUE; }
		elseif ($today == $day || $day == 'weekdays' ){ return TRUE; }
		elseif ($today == $day || $day == 'weekdays' ){ return TRUE; }
		elseif ($today == $day || $day == 'weekends' ){ return TRUE; }
		elseif ($today == $day || $day == 'weekends' ){ return TRUE; }
		else return false;
		*/
	}
}
