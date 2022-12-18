<?php 
namespace SoulDoit\PhpDBWow;

use SoulDoit\PhpDBWow\DBConfig;

class WowDB {
    private $conn;
    private $seldb;

    public $numRows;
    public $singleData;
    public $multiData=Array();

    function __construct($host='', $db='', $user='', $pwd='') {
        
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
        
        if(empty($db_conf)){
            die('ERROR: DB Config is empty');
        }
        
        $this->conn=mysqli_connect($db_conf["hostname"],$db_conf["username"],$db_conf["password"]);
        $this->seldb=mysqli_select_db($this->conn,$db_conf["database"]);
    }

    public function query($da){
        $query=$da;//["query"];

        $result=mysqli_query($this->conn,$query);
        if($result){
            if(is_bool($result) && $result){
                //echo "inserted";
            }else{
                $this->numRows=mysqli_num_rows($result);
                if($this->numRows>0){
                    $this->singleData=mysqli_fetch_array($result);
                }
                if($this->numRows>1){
                    array_push($this->multiData,$this->singleData);
                    while($data=mysqli_fetch_assoc($result)){
                        array_push($this->multiData,$data);
                    }
                }
            }
            return true;
        }
        return false;
    }

    public function select($table, $cond, $cols=null){
        $select_cols_raw = "";

        if(!empty($cols)){
            if(is_array($cols)){
                foreach($cols as $col) $select_cols_raw .= "`$col`,";
                $select_cols_raw = rtrim($select_cols_raw, ",");
            }
        }else $select_cols_raw = "*";

        $query="SELECT $select_cols_raw FROM $table ";

        if (is_array($cond)){
            $i=0;
            foreach($cond as $ccol=>$cdata){
                $query.=(($i)==0?"WHERE ":" ")."$ccol='$cdata'".(($i+1)<count($cond)?" AND ":" ");
                $i++;
            }
        }
        
        $result=mysqli_query($this->conn,$query);
        if($result){
            $this->numRows=mysqli_num_rows($result);
            if($this->numRows>0){
                $this->singleData=mysqli_fetch_assoc($result);
                array_push($this->multiData,$this->singleData);
            }
            if($this->numRows>1){
                while($data=mysqli_fetch_assoc($result)){
                    array_push($this->multiData,$data);
                }
            }
            return true;
        }
        return false;
    }

    public function insert($table, $params, $id_column='id'){
        $query="INSERT INTO $table ";
        $col="(";
        $data="VALUES (";

        $i=0;
        foreach($params as $ccol=>$cdata){
            $col.="$ccol".(($i+1)<count($params)?",":") ");
            $data.="'$cdata'".(($i+1)<count($params)?",":") ");
            $i++;
        }
        $query.=$col.$data;

        $result=mysqli_query($this->conn,$query);
        if($result){
            if(is_bool($result) && $result){
                $current_id = 'error: id_col_is_not_valid';
                $indexColName=$id_column;
                $indexResult=mysqli_query($this->conn,"SELECT $indexColName FROM $table ORDER BY $indexColName ASC");
                if(!$indexResult) return true;
                else while($cID=mysqli_fetch_array($indexResult)) $current_id=$cID[$indexColName];

                return $current_id;
            }
        }
        return false;
    }

    public function delete($table,$cond){
        $query="DELETE FROM $table ";
        $query.="WHERE ";

        $i=0;
        foreach($cond as $ccol=>$cdata){
            $query.="$ccol='$cdata'".(($i+1)<count($cond)?" AND ":" ");
            $i++;
        }

        $result=mysqli_query($this->conn,$query);
        if($result){
            if(is_bool($result) && $result){
                return true;
            }
        }
        return false;
    }

    public function update($table,$cond,$params){
        //UPDATE `tablesatu` SET `Id`=[value-1],`uname`=[value-2],`upass`=[value-3] WHERE 1
        $query="UPDATE $table ";

        $i=0;
        foreach($params as $ccol=>$cdata){
            $query.=(($i)==0?"SET ":" ")."$ccol='$cdata'".(($i+1)<count($cond)?", ":" ");
            $i++;
        }
        $i=0;
        foreach($cond as $ccol=>$cdata){
            $query.=(($i)==0?"WHERE ":" ")."$ccol='$cdata'".(($i+1)<count($cond)?" AND ":" ");
            $i++;
        }

        $result=mysqli_query($this->conn,$query);
        if($result){
            if(is_bool($result) && $result){
                return true;
            }
        }
        return false;

    }

    public function set($var,$val){
        $this->$var=$val;
    }
}

?>