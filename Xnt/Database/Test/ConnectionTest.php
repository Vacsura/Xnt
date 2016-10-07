<?php
namespace Xnt\Database\Test;

use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{
    public static function setUpBeforeClass()
    {
        require_once('../../Autoloader.php');
        \Xnt\Autoloader::register();
    }

    public function testNewConnection()
    {
        $conn = new \Xnt\Database\Connection('conf.ini');
        $this->assertInstanceOf('\Xnt\Database\Connection', $conn);

        $statement = $conn->prepare('SELECT 3;');
        $statement->execute();
        $result = (int) $statement->fetchColumn();
        $this->assertEquals(3, $result);
    }

    public function testNewConnectionWithCharset()
    {
        $file = 'conf_with_default_charset.ini';
        $settings = parse_ini_file($file, true);
        $conn = new \Xnt\Database\Connection($file);
        $this->assertInstanceOf('\Xnt\Database\Connection', $conn);

        $statement = $conn->prepare('SELECT CHARSET("");');
        $statement->execute();
        $result = $statement->fetchColumn();
        $this->assertEquals($settings['database']['charset'], $result);
    }

    public function testNewConnectionWithDatabase()
    {
        $file = 'conf_with_default_database.ini';
        $settings = parse_ini_file($file, true);
        $conn = new \Xnt\Database\Connection($file);
        $this->assertInstanceOf('\Xnt\Database\Connection', $conn);

        $statement = $conn->prepare('SELECT DATABASE();');
        $statement->execute();
        $result = $statement->fetchColumn();
        $this->assertEquals($settings['database']['dbname'], $result);
    }
}

