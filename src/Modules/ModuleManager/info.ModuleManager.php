<?php

Namespace Info;

class ModuleManagerInfo extends PTConfigureBase {

    public $hidden = false;

    public $name = "Manage the modules used in PTConfigure";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "ModuleManager" =>  array_merge(parent::routesAvailable(), array(
          "install", "ensure", "uninstall", "enable", "disable", "show"
      )) );
    }

    public function routeAliases() {
      return array("module-manager"=>"ModuleManager", "modulemanager"=>"ModuleManager");
    }

    public function helpDefinition() {
      $help = '
  The Module Manager allows you to manage modules. Install, Ensure, Uninstall, Enable, Disable.

  ModuleManager, module-manager, modulemanager

        - install
        Installs the latest version of a module. If a module of the same name already exists in your Extensions directory,
        an error will be thrown.
        example: '.PHARAOH_APP.' module-manager install --module-name="MyModule" --module-source="http://git.cleo-modules.com/MyModule.git"

        - ensure
        Ensures the existence of a module. The module will only be installed if it currently doesn\'t exist.
        example: '.PHARAOH_APP.' module-manager ensure --module-name="MyModule" --module-source="http://git.cleo-modules.com/MyModule.git"

        - uninstall
        Uninstalls a Module. This will delete all of the files for this Module
        example: '.PHARAOH_APP.' module-manager enable --module-name="MyModule"

        - enable
        Enables a Module. All installed Modules are enabled by default.
        example: '.PHARAOH_APP.' module-manager enable --module-name="MyModule"

        - disable
        Disables a Module. The files for this module will still exist, but none will be automatically loaded during execution.
        example: '.PHARAOH_APP.' module-manager disable --module-name="MyModule"
    ';
      return $help ;
    }

}