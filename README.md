# Database-Library
Database Library for the program language PHP

**INFORMATION** <br />-----------------<br />
The library is currently in the **BETA-Phase!**<br /> Errors can happen, so if you found a bug, please let me know. You can contact me at the email address **database-library@serumdev.de**; or via Twitter at https://www.twitter.com/SerumDev via Direct Message. Thanks!

# How to work with the library?

#### Connect to database:
```php
<?php

use Library\Base\Database;

require_once('database/database.class.php');

$database = new Database("host e.g. localhost", port e.g. 3306, "user e.g. root", "password", "table");
?>
```
- You can create the database structure in the method "tableMatrix"; which is called automatically after a successful connection to the database.

# Introduction to the methods:
 #### writeNow($table, $columns = array(), $values = array()):
  - Declaration: <br />Write into a table.
    
  - Example:
    ```php
    Code:
      $database->writeNow("users", array("firstName", "lastName"), array("Max", "Mustermann"));
    
    Executed Query:
      INSERT INTO users("firstName", "lastName") VALUES(?, ?);
    ```
#### delete($table, $key, $value):
  - Declaration: <br />Delete a entry from the table
    
  - Example:
    ```php
    Code:
      $database->delete("users", "firstName", "Max");
      
    Executed Query:
      DELETE FROM users WHERE firstName=?;
    ```
#### queryAll($table):
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
#### query($table, $key, $value):
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
#### queryConditional($table, $key, $value, $key2, $value2):
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
  - Declaration: <br />Returns any values that start with the $value (pattern)
  
  - Example:
    ```php
    Code:
      $result = $database->queryLike("users", "firstName", "a%");
      print_r ($result);
      
    Executed Query:
      SELECT * FROM $table WHERE firstName LIKE ?;
      
    Output:
      Returns any values that start with "a" as array
    ```
#### invokeCommand($command): (Method is a private function, but you can changing that to public)
 - Declaration: <br />Execute a command in the current database
 
 - Example:
   ```php
    Code:
      $this->invokeCommand("CREATE TABLE IF NOT EXISTS test(firstName VARCHAR(256), lastName VARCHAR(256), email VARCHAR(256));");
      
    Executed Query:
      CREATE TABLE IF NOT EXISTS test(firstName VARCHAR(256), lastName VARCHAR(256), email VARCHAR(256));
    ```
