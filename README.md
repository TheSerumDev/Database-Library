# Database-Library
Database Library for the program language PHP

# How to work with the library?

#### Connect to database:
```php
<?php

use Library\Base\Database;

require_once('database/database.class.php');

$database = new Database("localhost", 3306, "root", "", "table");
?>
```
- You can create the database structure in the method "tableMatrix"; which is called automatically after a successful connection to the database.

# Introduction to the methods:
 #### writeNow($table = string, $columns = array(), $values = array()):
  - Declaration: <br />Write into table.
    
  - Example:
    ```php
    Code:
      $database->writeNow("users", array("firstName", "lastName"), array("Max", "Mustermann"));
    
    Executed Query:
      INSERT INTO users("firstName", "lastName") VALUES(?, ?);
    ```
#### delete($table = string, $key, $value):
  - Declaration: <br />Delete a entry from the table
    
  - Example:
    ```php
    Code:
      $database->delete("users", "firstName", "Max");
      
    Executed Query:
      DELETE FROM users WHERE firstName=?;
    ```
#### queryAll($table = string):
  - Declaration: <br />Returns all entries from the table
    
  - Example:
    ```php
    Code:
      $result = $database->queryAll("users");
      print_r ($result);
    
    Executed Query:
      SELECT * FROM users;
    
    Output: 
      Array 
      ( 
        [0] => Array 
            ( 
              [firstName] => Max [0] => Max
              [lastName] => Mustermann [1] => Mustermann
              [email] => max@mustermann.eu [2] => max@mustermann.eu
            ) 
      )
    ```
#### query($table = string, $key, $value):
  - Declaration: <br />Returns an object
    
  - Example:
    ```php
    Code:
      $result = $database->query("users", "firstName", "Max");
      print_r ($result);
    
    Executed Query:
      SELECT * FROM users WHERE firstName=?;
    
    Output:
      Array 
      ( 
        [firstName] => Max [0] => Max
        [lastName] => Mustermann [1] => Mustermann
        [email] => max@mustermann.eu [2] => max@mustermann.eu
      )
    ```
#### queryConditional($table = string, $key, $value, $key2, $value2):
  - Declaration: <br />Returns an object where you can define 2 key and values
  
  - Example:
    ```php
    Code:
      $result = $database->queryConditional("users", "firstName", "Max", "lastName", "Mustermann");
      print_r ($result);
    
    Executed Query:
      SELECT * FROM users WHERE firstName=? AND lastName=?;
    
    Output:
      Array 
      ( 
        [firstName] => Max [0] => Max 
        [lastName] => Mustermann [1] => Mustermann 
        [email] => max@mustermann.eu [2] => max@mustermann.eu
      )
    ```
#### querySpecial($qry):
  - Declaration: <br />Execute a special query of whatever you want
  
  - Example:
    ```php
    Code:
      $result = $database->querySpecial("SELECT table.uuid, round(table.kills/table.deaths) as kd FROM table ORDER BY kd LIMIT 10");
      print_r ($result);
      
    Executed Query:
      SELECT table.uuid, round(table.kills/table.deaths) as kd FROM table ORDER BY kd LIMIT 10;
      
    Output:
      Get the top ten players based on the KD 
    ```
#### queryLength($table):
  - Declaration: <br />Returns the count of all entries of the table
  
  - Example:
    ```php
    Code:
      $result = $database->queryLength("users");
      print_r ($result);
      
    Executed Query:
      SELECT COUNT(*) FROM users;
      
    Output:
      #n
    ```
#### queryLengthWhere($table, $key, $value):
  - Declaration: <br />Returns a number from the entered data
  
  - Example:
    ```php
    Code:
      $result = $database->queryLengthWhere("users", "firstName", "Max");
      print_r ($result);
      
      if ($result == 0) {
        // User not exist
      } else {
        // User exist
      }
      
    Executed Query:
      SELECT COUNT(*) FROM users WHERE firstName=?;
      
    Output:
      0 || 1
    ```
#### queryLike($table, $key, $value):
  - Declaration: <br />TODO
