<?php

 class DbBase {

    protected $_db;
    protected $_result;
    public $results;

    const FIELD_TABLE = "_table";
    const FIELD_SORT = "_sort";
    const FIELD_ID = "_key";
    const FIELD_FIELDS = "_fields";

    public function __construct() { 

        error_log("DbBase::__Construct: vor new mysqli");
        $this->_db = new mysqli('localhost', 'root' ,'', 'clubmgmt');
        $this->_db->query("SET NAMES 'utf8'");
        error_log("DbBase: __Construct: after new mysqli");
        
        $_db = $this->_db;

        if ($_db->connect_error) {
            die('DbBase: Connection Error: ' . $_db->connect_error);
        }

        return $_db;
    }

    public function query($sql)
    {
        return $this->_db->query($sql);
    }

    public function getTableFromMetadata($params)
    {
        return $this->getKeyFromMetadata($params, self::FIELD_TABLE);
    }
    
    public function getFieldsFromMetadata($params)
    {
        $f = $this->getKeyFromMetadata($params, self::FIELD_FIELDS);
        if($f == "")
            $f = "*";
        return $f;
    }
    
    public function getSortFromParameters($params)
    {
        return $this->getKeyFromMetadata($params, self::FIELD_SORT);
    }

    public function getIdKeyFromMetadata($params)
    {
        return $this->getKeyFromMetadata($params, self::FIELD_ID);
    }

    public function getKeyFromMetadata($params, $metadataKey)
    {
        $table = "";
        if( is_array($params))
        {
            foreach($params as $record)
            {
                foreach ($record as $key => $value) {
                    if( $key == $metadataKey)
                    {
                        $table = $value;
                    }
                }
            }
        } else {
            foreach ($params as $key => $value) {
                if( $key == $metadataKey)
                {
                    $table = $value;
                }
            }
        }
        return $table;
    }

    public function getFieldsFromParameters($params)
    {
        $fields = array();
        if( is_array($params))
        {
            foreach($params as $record)
            {
                $this->addToFieldsArray($fields, $record);
            }
        }
        else 
        {
            $this->addToFieldsArray($fields, $params);
        }
        return $fields;
    }

    private function addToFieldsArray(&$fields, $records)
    {
        foreach ($records as $key => $value) {
            if( $key != "table")
            {
                if( !array_key_exists($key, $fields))
                {
                    $fields[$key] = $value; 
                }
            }
        }
        return $fields;
    }

    public function IsNullOrEmptyString($question){
        return (!isset($question) || trim($question)==='');
    }

    public function getRecordsFromParams($params)
    {
        $records = array();
        if( is_array($params))
        {
            foreach($params as $record)
            {
                if( is_array($record))
                {
                    foreach($record as $r)
                    {
                        if( !array_key_exists(self::FIELD_TABLE, $record))
                            array_push($records, $r);
                    }
                }
                else 
                {
                    if( !array_key_exists(self::FIELD_TABLE, $record))
                        array_push($records, $record);
                }
            }
        }
        else 
        {
            array_push($records, $record);
        }
        return $records;
    }

    public function getGrid($_params, $metadata) {
        $_db = $this->_db;
        $params = is_array($_params) ? $_params[0] : $_params;

        error_log("dbBase:getGrid()");
        // error_log(print_r($params, true));
        // error_log(print_r($metadata, true));

        $table = $this->getTableFromMetadata($metadata);
        $fields = $this->getFieldsFromMetadata($metadata);
        error_log("Fields: $fields");
        $filters = isset($params->filter) ? $params->filter : array();
        
        $total = 0;
        $sql = "SELECT COUNT(*) as countUsers from $table";
        $where = "";
        foreach($filters as $filter)
        {
            $where .= ($where == "") ? " WHERE " : " AND ";
            if( $filter->property == "Id")
                $where .= $filter->property . "=" . $filter->value;
            else
                $where .= $filter->property . "='" . $filter->value . "'";
        }
        if( $where !="") $sql .= $where;

        error_log("dbBase:getGrid(): sql=$sql");
        $_totalresult = $_db->query($sql) or die('Connection Error: ' . $_db->connect_error);
        if( $totalrow = $_totalresult->fetch_assoc())
        {
            $total = $totalrow['countUsers'] + 0;
        }

        $start = isset($params->start) ? $params->start : 0;
        $limit = isset($params->limit) ? $params->limit : 25;
        $isort = $this->getSortFromParameters($metadata);
        $sql = "SELECT $fields FROM $table";
        if( $where !="") $sql .= $where;
        if( !$this->IsNullOrEmptyString($isort)) 
        {
            $sql .= " ORDER BY $isort ";
        }
        $sql .= " LIMIT $start,$limit";

        error_log("dbBase:getGrid(): sql=$sql");

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

    public function create($params, $metadata) {
        $_db = $this->_db;

        error_log("DbBase:create()");
        error_log(print_r($params, true));

        $table = $this->getTableFromMetadata($metadata);
        $idField = $this->getIdKeyFromMetadata($metadata);
        $sql = "";

        $records = $this->getRecordsFromParams($params);
        foreach($records as $record)
        {
            $sql .= $this->getInsertSql($table, $idField, $record);
        }
        error_log("DbBase:insert: SQL=$sql");
        
        $_result = $_db->query($sql);
        //  or die('Connection Error: ' . $_db->connect_error);
        
        return $_result;
 
    }

    private function getInsertSql($table, $idField, $record)
    {
        $sql = "INSERT INTO $table (";     
        $fields = array();
        $values = array();
        foreach ($record as $key => $value) {
            if( $key != $idField)
            {
                array_push($fields, $key);
                array_push($values, "'" . $value . "'");
            }
        }
        $sql .= implode(",", $fields);
        $sql .= ") VALUES (" . implode(",", $values) . "); ";
        return $sql;
    }

    public function update($params, $metadata) {
        $_db = $this->_db;

        $table = $this->getTableFromMetadata($metadata);
        $idField = $this->getIdKeyFromMetadata($metadata);
        error_log("DbBase:update() id=$idField");
        error_log(print_r($metadata, true));

        $sql = "";
        if( is_array($params))
        {
            foreach($params as $record)
            {
                $sql .= $this->getUpdateSql($record, $table, $idField);
            }
        }
        else
        {
            $sql = $this->getUpdateSql($params);
        }
        error_log("DbBase:update: SQL=$sql");
        
        $_result = $_db->query($sql);
        //  or die('Connection Error: ' . $_db->connect_error);
        
        return $_result;
    }

    private function getUpdateSql($record, $table, $idField)
    {
        error_log("DbBase:getUpdateSql() for Record");
        error_log(print_r($record, true));
        $sql = "UPDATE $table SET ";         
        $uId = $record->$idField;
        error_log("DbBase:getUpdateSql() Id=$uId");
        $fields = array();
        foreach ($record as $key => $value) {
            if( $key != $idField)
            {
                array_push($fields, "$key='$value'");
            }
        }
        $sql .= implode(",", $fields);
        if( $idField != "Id")
            $sql .= " WHERE $idField='$uId';";
        else 
            $sql .= " WHERE Id=$uId;";
        return $sql;
    }

    public function delete($params, $metadata) {
        $table = $this->getTableFromMetadata($metadata);
        $idField = $this->getIdKeyFromMetadata($metadata);
        $records = $this->getRecordsFromParams($params);
        $sql = "";
        foreach($params as $record)
        {
            $uId = $record->$idField;
            error_log("DbBase:delete() from Table $table Field $idField=$uId  for Record");
            error_log(print_r($record, true));
            $sql .= "DELETE FROM $table WHERE $idField='$uId'; ";      
        }
        // $sql = "DELETE FROM $table WHERE $idField=$uId;";         
        error_log("DbBase:delete(Id=$uId): SQL=$sql");

        $_result = $this->_db->query($sql);
        //   or die("Error Deleting Record(sql=$sql): " . $_db->error_get_last);
        
        return $_result;
    }

 }

 ?>