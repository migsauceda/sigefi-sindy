<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pgsql
 *
 * @author miguel
 */
class pgsql {
   private $linkid;      // PostgreSQL link identifier
   private $host;        // PostgreSQL server host
   private $user;        // PostgreSQL user
   private $passwd;      // PostgreSQL password
   private $db;          // PostgreSQL database
   private $result;      // Query result
   private $querycount;  // Total queries executed
   /* Class constructor. Initializes the $host, $user, $passwd
      and $db fields. */
   function __construct($host, $db, $user, $passwd) {
      $this->host = $host;
      $this->user = $user;
      $this->passwd = $passwd;
      $this->db = $db;
   }
   /* Connects to the PostgreSQL Database */
   function connect(){
      try{
         $this->linkid = @pg_connect("host=$this->host dbname=$this->db
            user=$this->user password=$this->passwd");
         if (! $this->linkid)
            throw new Exception("Could not connect to PostgreSQL server.");
      }
      catch (Exception $e) {
        die($e->getMessage());
      }
    }
    /* Execute database query. */
    function query($query){
       try{
          $this->result = @pg_query($this->linkid,$query);
          if(! $this->result)
             throw new Exception("The database query failed.");
       }
       catch (Exception $e){
          echo $e->getMessage();
       }
       $this->querycount++;
       return $this->result;
    }
    /* Determine total rows affected by query. */
    function affectedRows(){
       $count = @pg_affected_rows($this->linkid);
       return $count;
    }
    /* Determine total rows returned by query */
    function numRows(){
       $count = @pg_num_rows($this->result);
       return $count;
    }
    /* Return query result row as an object. */
    function fetchObject(){
       $row = @pg_fetch_object($this->result);
       return $row;
    }
    /* Return query result row as an indexed array. */
    function fetchRow(){
       $row = @pg_fetch_row($this->result);
       return $row;
    }
    /* Return query result row as an associated array. */
    function fetchArray(){
       $row = @pg_fetch_array($this->result);
       return $row;
    }

   /* Return total number of queries executed during
   lifetime of this object. Not required, but
   interesting nonetheless. */
    function numQueries(){
       return $this->querycount;
    }

    function begintransaction() {
        $this->query('START TRANSACTION');
    }
    function commit() {
       $this->query('COMMIT');
    }
    function rollback() {
       $this->query('ROLLBACK');
    }
    function setsavepoint($savepointname){
       $this->query("SAVEPOINT $savepointname");
    }
    function rollbacktosavepoint($savepointname){
       $this->query("ROLLBACK TO SAVEPOINT $savepointname");
    }

}
?>
