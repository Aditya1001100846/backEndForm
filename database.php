<?php
/**
 * Database.php
 */
include("constants.php");
      
class MySQLDB
{
   var $connection;         //The MySQL database connection
   var $num_active_users;   //Number of active users viewing site
   var $num_active_guests;  //Number of active guests viewing site
   var $num_members;        //Number of signed-up users
   /* Note: call getNumMembers() to access $num_members! */

   /* Class constructor */
   function MySQLDB(){
      /* Make connection to database */
      $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
      mysql_select_db(DB_NAME, $this->connection) or die(mysql_error());      
   }

   /**
    * confirmNewApplicant - Checks whether or not the given
    * applicant is already present in the database,
    * it returns an error code 1 and on success it returns 0.
    */
   function confirmNewEmailAndContact($username, $password){     
      /* Verify that user is in database */
      $q = sprintf("SELECT email FROM ".applicant_table." where contact = '%s'",
            mysql_real_escape_string($email));
      $result = mysql_query($q, $this->connection);
      if(!$result || (mysql_numrows($result) < 1)){
         return 1; //Indicates emailAndContact not verified
      }

      /* Retrieve password from result, strip slashes */
      $dbarray = mysql_fetch_array($result);
      $dbarray['password'] = stripslashes($dbarray['password']);
      $password = stripslashes($password);

      /* Validate that password is correct */
      if($password == $dbarray['password']){
         return 0; //Success! Username and password confirmed
      }
      else{
         return 2; //Indicates password failure
      }
   }   
   
   /**
    * emailTaken - Returns true if the email has
    * been taken by another user, false otherwise.
    */
    function emailTaken($email){
       if(!get_magic_quotes_gpc()){
          $email = addslashes($email);
       }
       $q = sprintf("SELECT email FROM ".APPLICANT_DETAILS." WHERE email = '%s'",
            mysql_real_escape_string($email));
       $result = mysql_query($q, $this->connection);
       return (mysql_num_rows($result) > 0);
    }    
   
   /**
    * addNewUser - Inserts the given (username, password, email)
    * info into the database. Appropriate user level is set.
    * Returns true on success, false otherwise.
    */
   function addNewApplicant($username, $password, $email, $userid, $name){
      $time = time();      
       $q = sprintf("INSERT INTO ".APPLICANT_DETAILS." VALUES ('%s', '%s', '%s', '%s', '%s', $time, '0', '%s', '0', '0')",
            mysql_real_escape_string($username),
            mysql_real_escape_string($password),
            mysql_real_escape_string($userid),
            mysql_real_escape_string($ulevel),
            mysql_real_escape_string($email),
            mysql_real_escape_string($name));
      return mysql_query($q, $this->connection);
   }
   
   /**
    * updateUserField - Updates a field, specified by the field
    * parameter, in the user's row of the database.
    */
   function updateApplicant($username, $field, $value){
      $q = sprintf("UPDATE ".APPLICANT_DETAILS." SET %s = '%s' WHERE username = '%s'",
            mysql_real_escape_string($field),
            mysql_real_escape_string($value),
            mysql_real_escape_string($username));
      return mysql_query($q, $this->connection);
   }
   
   /**
    * getUserInfo - Returns the result array from a mysql
    * query asking for all information stored regarding
    * the given username. If query fails, NULL is returned.
    */
   function getApplicantInfo($username){
      $q = sprintf("SELECT * FROM ".APPLICANT_DETAILS." WHERE username = '%s'",
            mysql_real_escape_string($username));
      $result = mysql_query($q, $this->connection);
      /* Error occurred, return given name by default */
      if(!$result || (mysql_numrows($result) < 1)){
         return NULL;
      }
      /* Return result array */
      $dbarray = mysql_fetch_array($result);
      return $dbarray;
   }   

   /**
    * query - Performs the given query on the database and
    * returns the result, which may be false, true or a
    * resource identifier.
    */
   function query($query){
      return mysql_query($query, $this->connection);
   }
};

/* Create database connection */
$database = new MySQLDB;

?>
