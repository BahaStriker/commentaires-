<?php
/*
*
* I know I know... Despacito
*/

Class DB { 

    private static $_instance   =   NULL; // Ha Ha Ha!
    private $_pdo, 
            $_query, 
            $_error =   false, 
            $_results,
            $_count =   0; // Shush it's private

    private function __construct(){
        try{ // We try building
            $this->_pdo =   new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/user'), Config::get('mysql/pass'));
        } catch(PDOException $e){
            die($e->getMessage()); // Catching exceptions is for communists
        }
    }

    public static function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance    =   new DB();
        }
        return self::$_instance;
    }

    public function query($sql, $params = array()){ //Database query 
        $this->_error   =   false;
        $x  =   1; // we start with 1 cuz 0

        if($this->_query = $this->_pdo->prepare($sql)){
            if(!empty($params)){
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            if($this->_query->execute()){
                $this->_results =   $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count   =   $this->_query->rowCount();
            } else {
                $this->_error   =   true; // Houston, we have a problem
            }
        }

        return $this;
    }

    private function action($action, $table, $where = array()){
        
        if(count($where) === 3){

            $operators  =   array('=', '<', '>', '>=', '<=', '<>', 'LIKE', '<=>', 'IS', 'IS NOT', 'IS NOT NULL', 'IS NULL', '!=', 'NOT LIKE');

            $field      =   $where[0];
            $operator   =   $where[1];
            $value      =   $where[2];

            if(in_array($operator, $operators)){

                $sql    =   "{$action} FROM `{$table}` WHERE `{$field}` {$operator} ?";

                if(!$this->query($sql, array($value))->error()){
                    return $this;
                }
            }
        }

        return false;
    }

    public function get($table, $where){
        return $this->action('SELECT *', $table, $where);
    }

    public function delete($table, $where){
        return $this->action('DELETE', $table, $where);
    }

    public function insert($table, $fields = array()){
        
        if(!empty($fields)){
            $keys   =   array_keys($fields);

            $sql    =   "INSERT INTO `{$table}` (`".implode('`, `', $keys)."`) VALUES (".implode(',', array_fill(0, count($keys), '?')).")";

            if(!$this->query($sql, $fields)->error()){
                return true;
            }
        }

        return false;
    }

    public function update($table, $where = array(), $fields = array()) {
        
        if(count($where) === 3) { 
            // If I from the future read this I'll back in time and kill myself. 
            $operators  =   array('=', '<', '>', '>=', '<=', '<>', 'LIKE', '<=>', 'IS', 'IS NOT', 'IS NOT NULL', 'IS NULL', '!=', 'NOT LIKE');

            $field      =   $where[0];
            $operator   =   $where[1];
            $value      =   $where[2];
            $set        =   '';
            $x          =   1;

            foreach ($fields as $name => $itsValue) {
                $set    .=  "`{$name}`=?";
                if($x < count($fields)) {
                    $set    .=  ', ';
                }
                $x++;
            }
            $set .= ", `updated_at`=?"; // This should fix something that should never happen

            if(in_array($operator, $operators)){
                $sql    =   "UPDATE `{$table}` SET {$set} WHERE `{$field}` {$operator} ?";
                array_push($fields, date('Y-m-d H:i:s'));
                array_push($fields, $value);

                if(!$this->query($sql, $fields)->error()) {
                    return true;
                }        
            }   
        }

        return false;
    }

    public function results(){
        return $this->_results;
    }

    public function first(){
        return $this->results()[0];
    }

    public function error(){
        return $this->_error;
    }

    public function count(){
        return $this->_count;
    }
}
