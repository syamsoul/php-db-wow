<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../vendor/autoload.php';

use SoulDoit\PhpDBWow\WowDB;

$db = new WowDB('localhost', 'test_blank', 'root', '');

// *******
// INSERT
// *******
$table="shoes";

$parameters=Array(
    "brand" => "Lee",
    "price" => 543.23
);

if(false){ // change this boolean to `true` to see the result
    $result = $db->insert($table, $parameters);

    if(empty($result)) echo "Failed";
    else echo "Success! The inserted ID is ".$result;
}



// *******
// DELETE
// *******
$table="shoes";

$conditions=Array(
    "id"    => 2,
);

if(false){ // change this boolean to `true` to see the result
    if(!$db->delete($table, $conditions)) echo "Failed";
    else echo "Success! The item is deleted";
}



// *******
// UPDATE
// *******
$table="shoes";

$conditions = Array(
    "id"    => 3,
);

$parameters = Array(
    "brand" => "Puma",
);

if(false){ // change this boolean to `true` to see the result
    if(!$db->update($table, $conditions, $parameters)) echo "Failed"; 
    else echo "Success! The item is updated";
}




// *******
// SELECT
// *******
$table  = "shoes";

$conditions = Array(
    "id"    => 3,
);

if(false){ // change this boolean to `true` to see the result
    if(!$db->select($table, $conditions)) echo "Failed";
    else {
        echo "Success!";

        echo "<div>Return Data: </div>";
        echo "<ol>";
        foreach($db->multiData as $key=>$data){
            echo "<li>".$data["brand"]."</li>";
        }
        echo "</ol>";
    }
}




// *******
// SELECT USING RAW QUERY
// *******
$sql_query = "SELECT * FROM `shoes` ORDER BY `id` DESC";

if(false){ // change this boolean to `true` to see the result
    if(!$db->query($sql_query)) echo "Failed";
    else {
        echo "Success!";

        echo "<div>Return Data: </div>";
        echo "<ol>";
        foreach($db->multiData as $key=>$data){
            echo "<li>".$data["brand"]."</li>";
        }
        echo "</ol>";
    }
}



// *******
// OTHERS RAW QUERY
// *******
$sql_query = "INSERT INTO `shoes` (`brand`, `price`) VALUES ('Adidas', 432.43)";

if(false){ // change this boolean to `true` to see the result
    if(!$db->query($sql_query)) echo "Failed";
    else echo "Success!";
}
?>