<?php
namespace Xnt\Database\Test;

use PHPUnit\Framework\TestCase;

class StatementTest extends TestCase
{
    public static $statement;

    public static function setUpBeforeClass()
    {
        require_once('../../Autoloader.php');
        \Xnt\Autoloader::register();
        $conn = new \Xnt\Database\Connection('conf.ini');
        self::$statement = new \Xnt\Database\Statement($conn);
    }

    public function testExecute()
    {
        $sql = 'SELECT :num;';
        $statement = self::$statement->execute($sql, array('num' => 3), array('num' => \PDO::PARAM_INT));
        $this->assertEquals(3, (int) $statement->fetchColumn());

        $sql = 'SELECT UCASE(:str);';
        $statement = self::$statement->execute($sql, array('str' => 'szoveg'), array('str' => \PDO::PARAM_STR));
        $this->assertEquals('SZOVEG', $statement->fetchColumn());

        $sql = 'SELECT :bool1 and :bool2';
        $vars = array('bool1' => true, 'bool2' => false);
        $types = array('bool1' => \PDO::PARAM_BOOL,'bool2' => \PDO::PARAM_BOOL);
        $statement = self::$statement->execute($sql, $vars, $types);
        $this->assertEquals(false, (bool) $statement->fetchColumn());
    }
}

