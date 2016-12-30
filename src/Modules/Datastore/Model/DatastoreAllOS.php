<?php

Namespace Model;

class DatastoreAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;
    private $targetDataStore ;
    
    public function __construct($params) {
        parent::__construct($params) ;
        try {
            $settings = $this->getSettings() ;
            if (isset($settings['DatastoreMySQL']['ds_mysql_enabled']) &&
                $settings['DatastoreMySQL']['ds_mysql_enabled'] === "on") {
                $tds = 'MySQL' ; }
            else if (isset($settings['DatastoreMongo']['ds_mongo_enabled']) &&
                $settings['DatastoreMongo']['ds_mongo_enabled'] === "on") {
                $tds = 'Mongo' ; }
            else if (isset($settings['DatastoreSQLLite']['ds_sqllite_enabled']) &&
                $settings['DatastoreSQLLite']['ds_sqllite_enabled'] === "on") {
                $tds = 'SQLLite' ; }
            if (!isset($tds)) {
                $tds = 'SQLLite' ; }
            $this->targetDataStore = '\Model\Datastore'.$tds ;
            if (!class_exists($this->targetDataStore)) { return false ; }
        }
        catch (\Exception $e) {
            die("Unable to initialize Target Datastore: {$e->getMessage()}") ; }
    }

    protected function getSettings() {
        $settings = \Model\AppConfig::getAppVariable("mod_config");
        return $settings ;
    }

    public function createCollection($table, Array $columns) {
        $datastoreFactory = new $this->targetDataStore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $res = $datastore->createTable($table, $columns) ;
        return $res ;
    }

    public function deleteCollection($table) {
        $datastoreFactory = new $this->targetDataStore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $res = $datastore->deleteTable($table) ;
        return $res ;
    }

    public function collectionExists($table) {
        $datastoreFactory = new $this->targetDataStore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $res = $datastore->collectionExists($table) ;
        return $res ;
    }

    public function find($table, $filters) {
        $datastoreFactory = new $this->targetDataStore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $found = $datastore->find($table, $filters) ;
        return $found ;
    }

    public function findOne($table, $filters) {
        $datastoreFactory = new $this->targetDataStore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $found = $datastore->find($table, $filters) ;
        $ret = isset($found[0]) ? $found[0] : false ;
        return $ret ;
    }

    public function findAll($table, $filters=array()) {
        $datastoreFactory = new $this->targetDataStore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $found = $datastore->findAll($table, $filters) ;
        return $found ;
    }

    public function findCount($table, $filters) {
        $datastoreFactory = new $this->targetDataStore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $found = $datastore->findCount($table, $filters) ;
        return $found ;
    }

    public function insert($table, $rowData) {
        $datastoreFactory = new $this->targetDataStore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $found = $datastore->insert($table, $rowData) ;
        return $found ;
    }

    public function update($table, $clause, $rowData) {
        $datastoreFactory = new $this->targetDataStore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $found = $datastore->update($table, $clause, $rowData) ;
        return $found ;
    }

    public function delete($table, $filters) {
        $datastoreFactory = new $this->targetDataStore() ;
        $datastore = $datastoreFactory->getModel($this->params) ;
        $dels[] = $datastore->delete($table, $filters) ;
        return (in_array(false, $dels)) ? false : true ;
    }

}