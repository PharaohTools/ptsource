<?php

Namespace Model;

class BuilderRepositoryAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("BuilderRepository") ;

    public function getAllBuilders() {
        $builders = array();
        $names = $this->getBuilderNames() ;
        $builderFactory = new \Model\Builder() ;
        $builder = $builderFactory->getModel($this->params);
        foreach ($names as $name) { $builders[$name] = $builder->getBuilder($name); }
        return $builders ;
    }

    public function getBuilderNames() {
        $builders = scandir(PIPEDIR) ;
        for ($i=0; $i<count($builders); $i++) {
            if (!in_array($builders[$i], array(".", "..", "tmpfile"))){
                if(is_dir(PIPEDIR.DS.$builders[$i])) {
                    // @todo if this isnt definitely a build dir ignore maybe
                    $names[] = $builders[$i] ; } } }
        return (isset($names) && is_array($names)) ? $names : array() ;
    }

}