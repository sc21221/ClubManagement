<?php
require_once "DbBase.php";
class MemberFee extends DbBase {

    // public function getGrid($_params, $metadata) {
    //     $_db = $this->_db;
 
    //     error_log("MemberFee:getGrid()");
       
    //     $d = parent::getGrid($_params, $metadata);
    //     error_log(print_r($d));
    //     $newdata = array();
    //     foreach($d->data as $record)
    //     {
    //         $row = array();
    //         $row->id = $record->mitglied_id . "-" . $record->beitrag_id;  
    //         $row->mitglied_id = $record->mitglied_id;
    //         $row->beitrag_id = $record->beitrag_id;
    //         array_push($newdata, $row);
    //     }
    //     $return = (object)[
    //         'success' => $d.success,
    //         'total' => $d.total,
    //         'data' => $newdata,
    //     ];
    //    return $return;
    // }

    public function create($params, $metadata) {

        error_log("MemberFee:create()");
        error_log(print_r($params, true));

        $table = $this->getTableFromMetadata($metadata);
        $idField = $this->getIdKeyFromMetadata($metadata);
        $sql = "INSERT INTO $table (mitglied_id,beitrag_id) VALUES ";
        $values = "";
        $records = $this->getRecordsFromParams($params);
        foreach($records as $record)
        {
            if( $values != "") $values .= ",";
            $values .= "('" . $record->mitglied_id . "','" . $record->beitrag_id . "')";     
        }
        $sql .= $values;
        error_log("MemberFee:insert: SQL=$sql");
        
        $_result = $this->_db->query($sql);
        //  or die('Connection Error: ' . $_db->connect_error);
        
        return $_result;
    }

    public function delete($params, $metadata) {
        $table = $this->getTableFromMetadata($metadata);
        $sql = "";
        foreach($params as $record)
        {
            $mitglied_id = explode("/",$record->id)[0];
            $beitrag_id = explode("/", $record->id)[1];
            error_log("DbBase:delete() from Table $table Field for Record");
            error_log(print_r($record, true));
            $sql .= "DELETE FROM $table WHERE mitglied_id='" . $mitglied_id . "' AND beitrag_id='" . $beitrag_id . "';";      
        }
        error_log("DbBase:delete(): SQL=$sql");

        $_result = $this->_db->query($sql);
        //   or die("Error Deleting Record(sql=$sql): " . $_db->error_get_last);
        
        return $_result;
    }

}
?>