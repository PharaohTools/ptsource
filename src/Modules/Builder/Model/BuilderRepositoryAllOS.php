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
        foreach ($names as $name => $types) {
            $builders[$name] = $builder->getBuilder($name); }
        return $builders ;
    }

    public function getBuilderNames() {
        $buildSteps = array() ;
        $infos = \Core\AutoLoader::getInfoObjects() ;
        foreach ($infos as $info) {
            if (method_exists($info, "buildSteps")) {
                $name = get_class($info);
                $name = substr($name, strlen($name)-4, 4) ;
                $buildSteps[$name] = $info->buildSteps(); } }
        return $buildSteps ;
    }

}