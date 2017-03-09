<?php

Namespace Model;

class DatastoreSQLLiteAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;
    protected $database ;
    protected $data_dir ;

    public function __construct($params) {
        parent::__construct($params) ;
        $this->data_dir = PFILESDIR.PHARAOH_APP.DS.'data'.DS ;
        try {
            require_once(dirname(__DIR__).DS."Libraries".DS."Medoo".DS."medoo.php" ) ;
            if (!is_dir($this->data_dir)) {
                mkdir ($this->data_dir, 0777, true); }
            if (!file_exists($this->data_dir.'database.db')) {
                touch ($this->data_dir.'database.db'); }
            $this->database = new \medoo([
                'database_type' => 'sqlite',
                'database_file' => $this->data_dir.'database.db',
                'charset' => 'utf8'
            ]);}
        catch (\Exception $e) {
            die("Unable to init datastore: {$e->getMessage()}") ; }
    }

    public function deleteTable($table) {
        $str = 'DROP TABLE IF EXISTS '.$table.' ;' ;
        $res = $this->database->query($str)->fetchAll();
        return $res ;
    }

    public function find($table, $filters) {
        if ($this->collectionExists($table)) {
            $raw_filters = array() ;
            $rf = array();
            $lm = array();

            foreach ($filters as $filterKeys => $filterVals) {
                $filterVals[2] = ($filterVals[2]===null) ? "" : $filterVals[2] ;
                if ($filterVals[0]=='where') {
                    $rf[$filterVals[1]] = $filterVals[3] ; } }
            if (count($rf)>0) {
                $raw_filters["AND"] = $rf ; }

            foreach ($filters as $filterKeys => $filterVals) {
                $filterVals[2] = ($filterVals[2]===null) ? 0 : (int) $filterVals[2] ;
                if ($filterVals[0]=='limit') {
                    $lm = array($filterVals[2], $filterVals[1]) ; } }
            if (count($lm)>0) {
                $raw_filters["LIMIT"] = $lm ; }

            $found = $this->database->select($table, "*", $raw_filters);

            return $found ; }
        return null ;
    }

    public function findCount($table, $filters) {
        if ($this->collectionExists($table)) {
            $raw_filters = array() ;
            $rf = array();
            $lm = array();

            foreach ($filters as $filterKeys => $filterVals) {
                $filterVals[2] = ($filterVals[2]===null) ? "" : $filterVals[2] ;
                if ($filterVals[0]=='where') {
                    $rf[$filterVals[1]] = $filterVals[3] ; } }
            if (count($rf)>0) {
                $raw_filters["AND"] = $rf ; }

            $found = $this->database->count($table, $raw_filters);
            return $found ; }
        return null ;
    }

    public function findAll($table, $filters=array()) {

        $found = $this->find($table, $filters) ;

//        $found = $this->database->select($table, "*", $filters);
        return $found ;
    }

    public function insert($table, $rowData) {
        $loggingFactory = new \Model\Logging() ;
        $logging = $loggingFactory->getModel($this->params) ;
        $logging->log("Attempting to insert into table {$table}", $this->getModuleName()) ;

        $this->database = new \medoo([
            'database_type' => 'sqlite',
            'database_file' => $this->data_dir.'database.db',
            'charset' => 'utf8',
            'option' => array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION),
        ]);

        try {
            $this->database->insert($table, $rowData) ;
        } catch (\Exception $e) {
            $logging->log("Unable to insert into table {$table}, Error: {$e->getMessage()}, {$this->database->last_query()}", $this->getModuleName()) ;
            return false ;
        }

        $this->database = new \medoo([
            'database_type' => 'sqlite',
            'database_file' => $this->data_dir.'database.db',
            'charset' => 'utf8',
        ]);
        return true ;
    }

    public function delete($table, $clause) {
        $loggingFactory = new \Model\Logging() ;
        $this->params["app-log"] ;
        $this->params["echo-log"] ;
        $logging = $loggingFactory->getModel($this->params) ;
        $k = array_keys($clause) ;
        if (count($clause)==1) {
            $clause = "WHERE {$k[0]} = '".$clause[$k[0]]."'" ;
            $logging->log("Attempting to delete from table {$table} $clause.", $this->getModuleName()) ; }
        else {
            $logging->log("Attempting to delete from table {$table} where {$table} field: {$k[0]} is value: {$clause[$k[0]]}.", $this->getModuleName()) ; }
        $res = $this->database->delete($table, $clause) ;
        if ($res == false) {
            $logging->log("Unable to delete from table {$table}, Error: {$this->database->error()[2]}, {$this->database->last_query()}", $this->getModuleName()) ; }
        return $res ;
    }

    public function update($table, $clause, $rowData) {
        $loggingFactory = new \Model\Logging() ;
        $this->params["app-log"] ;
        $this->params["echo-log"] ;
        $logging = $loggingFactory->getModel($this->params) ;
        $k = array_keys($clause) ;
        if (count($clause)===1) {
            $clause = "WHERE {$k[0]} = '".$clause[$k[0]]."'" ;
            $logging->log("Attempting to update table {$table} $clause.", $this->getModuleName()) ; }
        else {
            $clause_ray = array() ;
            foreach ($clause as $a_clause_key => $a_clause_value) {
                $clause_ray[] = "{$a_clause_key} = '".$a_clause_value."'" ;
            }
            $clause = 'WHERE '.implode(' AND ', $clause_ray) ;
            $logging->log("Attempting to update table {$table} {$clause}.", $this->getModuleName()) ; }
        $res = $this->database->update($table, $rowData, $clause) ;
        if ($res == false) {
            $logging->log("Unable to update table {$table}, Error: {$this->database->error()[2]}, {$this->database->last_query()}", $this->getModuleName()) ; }
        return $res ;
    }

    public function collectionExists($table) {
        $sql = "SELECT count(*) FROM sqlite_master WHERE type='table' AND name='".$table."';" ;
        $res = $this->database->query($sql)->fetchAll();
        $count = $res[0]["count(*)"] ;
        return ($count=="1") ? true : false ;
    }

    public function createTable($table, Array $columns) {
        $str = 'CREATE TABLE '.$table.'( ' ;
        $str_mid = array() ;
        foreach($columns as $columnKey => $columnDetails) {
            $str_mid[] = "'".$columnKey."' $columnDetails" ; }
        $str_mid_text = implode(",\n", $str_mid) ;
        $str .=  $str_mid_text ;
        $str .=  ' );'  ;
//        var_dump("table cre: ", $str) ;
        $res = $this->database->query($str);
        // @todo check if the table exists
        if ($res == false) {
            $loggingFactory = new \Model\Logging() ;
            $this->params["echo-log"] = true ;
            $this->params["app-log"] = true ;
            $logging = $loggingFactory->getModel($this->params) ;
            $logging->log("Unable to create table {$table}, Error: {$this->database->error()[2]}", $this->getModuleName()) ; }
        return $res ;
    }

}