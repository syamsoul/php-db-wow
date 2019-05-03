

# PHP DB Wow



[![Latest Version on Packagist](https://img.shields.io/packagist/v/syamsoul/php-db-wow.svg?style=flat-square)](https://packagist.org/packages/syamsoul/php-db-wow)



This package will make your life easier in handling MySQL database.



&nbsp;
* [Requirement](#requirement)
* [Installation](#installation)
* [Usage & Reference](#usage--reference)
  * [How to use it?](#how-to-use-it)
* [Example](#example)


&nbsp;
&nbsp;
## Requirement

* PHP version: 5.5.0 and above


&nbsp;
&nbsp;
## Installation


This package can be used in PHP 5.5 or higher. If you are using an older version of PHP, there's might be some problem. If there's any problem, you can [create new issue](https://github.com/syamsoul/php-db-wow/issues) and I will fix it as soon as possible.

You can install the package via composer:

``` bash
composer require syamsoul/php-db-wow
```

&nbsp;
&nbsp;
## Usage & Reference

\* Before you read this section, you can take a look [the example below](#example) to make it more clear to understand.

&nbsp;
### How to use it?

First, you must add this line to your Controller:
```php
use SoulDoit\PhpDBWow\WowDB;
```
&nbsp;

And then create a new WowDB instance:
```php
$db = new WowDB($hostname, $db_name, $db_username, $db_password);
```

Which is:
* `$hostname` is a string of your server hostname, for example:
    ```php
    $hostname = 'localhost';

    // or

    $hostname = 'mysql.hostinger.my';
    ```
* `$db_name` is a string of your database name, for example:
    ```php
    $db_name = 'new_project_db';
    ```
* `$db_username` is a string of your MySQL's username, for example:
    ```php
    $db_username = 'root';
    ```
* `$db_password` is a string of your MySQL's password, for example:
    ```php
    $db_password = 'mypassword';
    ```  
  
&nbsp;

And that's it. Now you have a connection with database. Congrats!

Next step is how to run the sql queries. 
Just head off to the example section and I'm sure you'll understand.

Enjoy!
:D


&nbsp;
&nbsp;
## Example


```php
// Autoload files using the Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';

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

$result = $db->insert($table, $parameters);

if(empty($result)) echo "Failed";
else echo "Success! The inserted ID is ".$result;




// *******
// DELETE
// *******
$table="shoes";

$conditions=Array(
    "id"    => 2,
);

if(!$db->delete($table, $conditions)) echo "Failed";
else echo "Success! The item is deleted";




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

if(!$db->update($table, $conditions, $parameters)) echo "Failed"; 
else echo "Success! The item is updated";





// *******
// SELECT
// *******
$table  = "shoes";

$conditions = Array(
    "id"    => 3,
);

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





// *******
// SELECT USING RAW QUERY
// *******
$sql_query = "SELECT * FROM `shoes` ORDER BY `id` DESC";

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




// *******
// OTHERS RAW QUERY
// *******
$sql_query = "INSERT INTO `shoes` (`brand`, `price`) VALUES ('Adidas', 432.43)";

if(!$db->query($sql_query)) echo "Failed";
else echo "Success!";
```


&nbsp;
&nbsp;
## Support me

I am a passionate programmer. Please support me and I will continue to contribute my code to the world to make the  world better. :')

Please [make a donation](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=syamsoulazrien.miat@gmail.com&lc=US&item_name=Support%20me%20and%20I%20will%20contribute%20more&no_note=0&cn=&curency_code=USD&bn=PP-DonationsBF:btn_donateCC_LG.gif:NonHosted). :')

&#35;MalaysiaBoleh

&nbsp;
&nbsp;
## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.