
  
  

# PHP DB Wow

  
  
  

[![Latest Version on Packagist](https://img.shields.io/packagist/v/syamsoul/php-db-wow.svg?style=flat-square)](https://packagist.org/packages/syamsoul/php-db-wow)

  
  
  
## Documentation, Installation and Usage Instructions

See the [documentation](https://info.souldoit.com/projects/php-db-wow) for detailed installation and usage instructions.


&nbsp;
&nbsp;
## Introduction
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

  

First, you must add this line to your PHP file:

```php

use SoulDoit\PhpDBWow\DB;

```

&nbsp;

And then create a new DB instance:

```php

$db = new DB($hostname, $db_name, $db_username, $db_password);

```
  

Which is:

*  `$hostname` is a string of your server hostname, for example:

```php
$hostname = 'localhost';

// or

$hostname = 'mysql.hostinger.my';
```
&nbsp;

*  `$db_name` is a string of your database name, for example:

```php
$db_name = 'new_project_db';
```
&nbsp;

*  `$db_username` is a string of your MySQL's username, for example:

```php
$db_username = 'root';
```
&nbsp;

*  `$db_password` is a string of your MySQL's password, for example:

```php
$db_password = 'mypassword';
```
&nbsp;

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
require_once  __DIR__  .  '/vendor/autoload.php';

use SoulDoit\PhpDBWow\DB;

$db = new DB('localhost', 'test_blank', 'root', '');
  

// *******
// INSERT
// *******

$table="shoes";

$parameters = [
    "brand" => "Lee",
    "price" => 543.23
];

$result = $db->insert($table, $parameters);

if($result === false) echo "Failed";
else echo "Success! The inserted ID is ".$result;
  
  

// *******
// DELETE
// *******

$table="shoes";

$conditions = [
    "id" => 2,
];

if($db->delete($table, $conditions) === false) echo "Failed";
else echo "Success! The item is deleted";

  

// *******
// UPDATE
// *******

$table="shoes";

$conditions = [
    "id" => 3,
];

$parameters = [
    "brand" => "Puma",
];

if($db->update($table, $conditions, $parameters) === false) echo "Failed";
else echo "Success! The item is updated";

  

// *******
// SELECT SINGLE DATA
// *******

$table = "shoes";

$conditions = [
    "id" => 3,
];

$data = $db->select($table, $conditions)->first();

if($data === false) echo "Failed";
else {
    echo "Success! \n";
    echo "Return Data: " . $data['brand'];
}


// *******
// SELECT MULTIPLE DATA
// *******

$table = "shoes";

$conditions = [
    "is_for_sale" => 1,
];

$data = $db->select($table, $conditions)->get();

if($data === false) echo "Failed";
else {
    echo "Success! \n\n";

    echo "Return Data: \n";
    foreach($data as $key => $each_data){
        echo $key . "=" . $each_data["brand"] . "\n";
    }
}
  
  

// *******
// SELECT USING RAW QUERY
// *******

$raw_sql_query = "SELECT * FROM `shoes` ORDER BY `id` DESC";

$query = $db->execute($raw_sql_query);

if($query === false) echo "Failed";
else {
    echo "Success! \n\n";

    echo "Return Data: \n";
    foreach($query->get() as $key => $each_data){
        echo $key . "=" . $each_data["brand"] . "\n";
    }
}

  

// *******
// OTHERS RAW QUERY
// *******

$raw_sql_query = "INSERT INTO `shoes` (`brand`, `price`) VALUES ('Adidas', 432.43)";

if($db->execute($raw_sql_query) === false) echo "Failed";
else echo "Success!";

```

  
  

&nbsp;

&nbsp;

## Support me

If you find this package helps you, kindly support me by donating some BNB (BSC) to the address below.

&nbsp;
```
0x364d8eA5E7a4ce97e89f7b2cb7198d6d5DFe0aCe
```
&nbsp;
<img src="https://info.souldoit.com/img/wallet-address-bnb-bsc.png" width="150">

  

&nbsp;

&nbsp;

## License

  

The MIT License (MIT). Please see [License File](LICENSE) for more information.
