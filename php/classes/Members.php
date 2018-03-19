<?php

 class Members {

    private $_db;
    protected $_result;
    public $results;

    public function __construct() { 

        error_log("__Construct: vor new mysqli");
        $this->_db = new mysqli('localhost', 'root' ,'', 'clubmgmt');
        error_log("__Construct: after new mysqli");
        
        $_db = $this->_db;

        if ($_db->connect_error) {
            die('Connection Error: ' . $_db->connect_error);
        }

        return $_db;
    }

    public function getResults() {
        $_db = $this->_db;

        //error_log("getResults($params)");
        
        $_result = $_db->query("SELECT anrede,vorname,nachname,email,telefon1 FROM mitglied") or
                   die('Connection Error: ' . $_db->connect_error);

        $results = array();

        while ($row = $_result->fetch_assoc()) {
            array_push($results, $row);
        }

        $this->_db->close();

        return $results;
    }

    public function getGrid($params) {
        $_db = $this->_db;

        //error_log("getResults($params)");
        
        $total = 0;
        $sql = "SELECT COUNT(*) as countMembers from mitglied";
        $_totalresult = $_db->query($sql) or die('Connection Error: ' . $_db->connect_error);
        if( $totalrow = $_totalresult->fetch_assoc())
        {
            $total = $totalrow['countMembers'] + 0;
        }

        $start = isset($params->start) ? $params->start : 0;
        $limit = isset($params->limit) ? $params->limit : 25;
        $sql = "SELECT * FROM mitglied order by nachname LIMIT $start,$limit";

        $_result = $_db->query($sql) or
                   die('Connection Error: ' . $_db->connect_error);

        $data = array();
        while ($row = $_result->fetch_assoc()) {
            array_push($data, $row);
        }
        $this->_db->close();

        $return = (object)[
            'success' => true,
            'total' => $total,
            'data' => $data,
        ];
        return $return;
    }

    public function create($params) {
        $_db = $this->_db;

        error_log("Members:create($params)");
    }

    public function update($params) {
        $_db = $this->_db;

        error_log("Members:update()");
        error_log(print_r($params, true));

        $sql = "";
        if( is_array($params))
        {
            foreach($params as $record)
            {
                $sql .= $this->getUpdateSql($record);
            }
        }
        else
        {
            $sql = $this->getUpdateSql($params);
        }
        error_log("Members:update: SQL=$sql");
        
        $_result = $_db->query($sql);
        //  or die('Connection Error: ' . $_db->connect_error);
        
        return $_result;
    }

    private function getUpdateSql($record)
    {
        $sql = "UPDATE mitglied SET ";     
        $memberId = $record->Id;
        $fields = array();
        foreach ($record as $key => $value) {
            if( $key != "Id")
            {
                array_push($fields, "$key='$value'");
            }
        }
        $sql .= implode(",", $fields);
        $sql .= " WHERE Id=$memberId;";
        return $sql;
    }

    public function delete($params) {
        $_db = $this->_db;

        
        error_log("Members:delete($params)");
    }

 }

 ?>