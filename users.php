<?php
    ini_set('display_startup_errors', 'On');
    ini_set('display_errors', 'On');
    error_reporting(-1);

    class UsersDB extends SQLite3 {
        function __construct() {
            $this->open('users.db');
        }
    }

    function get_all_entries($db) {
        $ret = $db->query("SELECT * FROM USERS;");
        while( $row = $ret->fetchArray(SQLITE3_ASSOC) ) {
            echo $row['ID'] . "," . $row['NAME'] . "," . $row['LAT'] . "," . $row['LON'] . "\n";
        }
    }

    function get_by_id($db, $id) {
        $ret = $db->query("SELECT * FROM USERS WHERE ID == $id");
        $row = $ret->fetchArray(SQLITE3_ASSOC);
        echo $row['ID'] . "," . $row['NAME'] . "," . $row['LAT'] . "," . $row['LON'] . "\n";
    }

    function get_by_name($db, $name) {
        $ret = $db->query("SELECT * FROM USERS WHERE NAME == $name");
        $row = $ret->fetchArray(SQLITE3_ASSOC);
        echo $row['ID'] . "," . $row['NAME'] . "," . $row['LAT'] . "," . $row['LON'] . "\n";
    }

    function parse_post($db) {
        foreach( $_POST as $key => $val ) {
            /*** get records ***/
            switch( $key ) {
            case "GETALL":      get_all_entries($db); break;
            case "GETBYID":     get_by_id($db, $val); break;
            case "GETBYNAME":   get_by_name($db, $val); break;
            default:
                echo "NOR PUT, GET $key\n";
            }
            /*** UPDATE records. ***/
        }
    }

    $db = new UsersDB();
    if( !$db ) {
        echo "0," . $db->lastErrorMsg();
    }else {
        //echo "Opened database sucessfully\n";
        parse_post($db);
        $db->close();
    }

?>

