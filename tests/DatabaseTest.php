
<?php

require_once('./classes/Database.php');

class DatabaseTest extends \PHPUnit\Framework\TestCase
{
    public function testConnection()
    {
        $connection = Database::connection();
        self::assertNotNull($connection);
    }
}
