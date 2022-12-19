<?php

namespace SoulDoit\PhpDBWow;

use SoulDoit\PhpDBWow\Traits\ErrorHandler;

class Query {
    use ErrorHandler;

    private $connection;
    private $raw_sql_query;
    private $raw_sql_query_arr;
    private $is_select_statement;
    private $query;
    private $is_already_executed = false;
    private $select_statement_result_data = null;
    private $is_select_statement_all_data = false;

    public function __construct(\mysqli $connection, string $raw_sql_query)
    {
        $this->connection = $connection;
        $this->raw_sql_query = trim($raw_sql_query);
        $this->raw_sql_query_arr = explode(" ", $this->raw_sql_query);
        $this->is_select_statement = strtolower($this->raw_sql_query_arr[0]) === 'select';
    }

    public function execute()
    {
        if(!$this->is_already_executed){
            $this->query = mysqli_query($this->connection, $this->raw_sql_query);
            $this->is_already_executed = true;
        }

        if($this->query) return $this;

        return false;
    }

    public function count()
    {
        if(!$this->is_select_statement) $this->die("ERROR: count() method is only for SELECT statement only.");

        if($this->execute() === false) return false;
        
        return mysqli_num_rows($this->query);
    }

    public function first()
    {
        if(!$this->is_select_statement) $this->die("ERROR: first() method is only for SELECT statement only.");

        $ori_raw_sql_query_arr = $this->raw_sql_query_arr;
        $raw_sql_query = $this->raw_sql_query;

        $raw_sql_query_arr_lowercase = array_map('mb_strtolower', $this->raw_sql_query_arr);
        $index_for_limit = array_search('limit', $raw_sql_query_arr_lowercase);
        
        if(is_integer($index_for_limit)) $this->raw_sql_query_arr[$index_for_limit + 1] = '1';
        else $this->raw_sql_query_arr = array_merge($this->raw_sql_query_arr, ['LIMIT', '1']);
        
        $this->raw_sql_query = implode(" ", $this->raw_sql_query_arr);

        $result = $this->execute();

        $this->raw_sql_query_arr = $ori_raw_sql_query_arr;
        $this->raw_sql_query = $raw_sql_query;

        if($result === false) return false;

        if(is_array($this->select_statement_result_data)) return $this->select_statement_result_data[0];
        
        $this->is_already_executed = false;

        $returned_data = mysqli_fetch_assoc($this->query);

        $this->select_statement_result_data = [$returned_data];
        
        return $returned_data;
    }

    public function get()
    {
        if(!$this->is_select_statement) $this->die("ERROR: get() method is only for SELECT statement only.");

        if($this->execute() === false) return false;

        if($this->is_select_statement_all_data){
            if(is_array($this->select_statement_result_data)) return $this->select_statement_result_data;
        }

        $returned_data = [];

        while($data = mysqli_fetch_assoc($this->query)){
            array_push($returned_data, $data);
        }

        $this->select_statement_result_data = $returned_data;
        $this->is_select_statement_all_data = true;

        return $returned_data;
    }
}