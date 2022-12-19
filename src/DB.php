<?php 

namespace SoulDoit\PhpDBWow;

use SoulDoit\PhpDBWow\DBConfig;
use SoulDoit\PhpDBWow\Query;
use SoulDoit\PhpDBWow\Traits\ErrorHandler;

class DB {
    use ErrorHandler;

    private $connection;
    private $seldb;

    function __construct(string $host = '', string $db = '', string $user = '', string $pwd = '')
    {
        $db_conf = false;
        
        if(!empty($host) && !empty($db) && !empty($user)){
            $db_conf = [
                "hostname"  => $host,
                "database"  => $db,
                "username"  => $user,
                "password"  => $pwd,
            ];
        }else{
            $db_conf = DBConfig::getConfig();
        }
        
        if(empty($db_conf)) $this->die('ERROR: DB Config is empty');
        
        $this->connection = mysqli_connect($db_conf["hostname"], $db_conf["username"], $db_conf["password"]);
        $this->seldb = mysqli_select_db($this->connection, $db_conf["database"]);
    }

    public function execute(string $raw_sql_query)
    {
        return (new Query($this->connection, $raw_sql_query))->execute();
    }

    public function select(string $table, array $cond = null, array $cols = null)
    {
        $select_cols_raw = "*";

        if(!empty($cols)){
            if(is_array($cols)){
                $select_cols_raw = "";
                foreach($cols as $col) $select_cols_raw .= "`$col`,";
                $select_cols_raw = rtrim($select_cols_raw, ",");
            }
        }

        $raw_sql_query = "SELECT $select_cols_raw FROM `$table` ";

        if (is_array($cond)){
            $i=0;
            foreach($cond as $ccol=>$cdata){
                $raw_sql_query .= (($i)==0?"WHERE ":"")."`$ccol`='$cdata'".(($i+1)<count($cond)?" AND ":" ");
                $i++;
            }
        }

        return new Query($this->connection, $raw_sql_query);
    }

    public function insert(string $table, array $params, string $id_column = 'id')
    {
        $raw_sql_query = "INSERT INTO `$table` ";
        $col = "(";
        $data = "VALUES (";

        $i=0;
        foreach($params as $ccol=>$cdata){
            $col .= "`$ccol`".(($i+1)<count($params)?",":") ");
            $data .= "'$cdata'".(($i+1)<count($params)?",":") ");
            $i++;
        }
        $raw_sql_query .= $col.$data;

        $result = (new Query($this->connection, $raw_sql_query))->execute();

        if($result !== false){
            $get_id_query = new Query($this->connection, "SELECT `$id_column` FROM `$table` ORDER BY `$id_column` DESC");
            return $get_id_query->first()[$id_column]; // NOTE: return inserted ID
        }

        return false;
    }

    public function update(string $table, array $cond, array $params)
    {
        $raw_sql_query = "UPDATE `$table` ";

        $i=0;
        foreach($params as $ccol=>$cdata){
            $raw_sql_query .= (($i)==0?"SET ":" ")."`$ccol`='$cdata'".(($i+1)<count($cond)?", ":" ");
            $i++;
        }

        $i=0;
        foreach($cond as $ccol=>$cdata){
            $raw_sql_query .= (($i)==0?"WHERE ":" ")."`$ccol`='$cdata'".(($i+1)<count($cond)?" AND ":" ");
            $i++;
        }

        $result = (new Query($this->connection, $raw_sql_query))->execute();

        return $result !== false;
    }

    public function delete(string $table, array $cond = null)
    {
        $raw_sql_query = "DELETE FROM `$table` ";

        if($cond !== null && is_array($cond)){
            $raw_sql_query .= "WHERE ";

            $i=0;
            foreach($cond as $ccol=>$cdata){
                $raw_sql_query .= "`$ccol`='$cdata'".(($i+1)<count($cond)?" AND ":" ");
                $i++;
            }
        }

        $result = (new Query($this->connection, $raw_sql_query))->execute();

        return $result !== false;
    }
}