<?php
namespace Xnt\Database;

class Connection extends \PDO
{
    /**
     * @param string $file Name of an ini file, whitch contains the following keys in database section:
     *                     driver, host, port, username, password, dbname, charset
     */
    public function __construct($file)
    {
        if (!$settings = parse_ini_file($file, true)) {
            throw new \Exception('Unable to parse the given ini file: ' . $file . '.');
        }

        $dns = $settings['database']['driver'] . ':' .
            'host=' . $settings['database']['host'] .
            ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
            ((!empty($settings['database']['dbname'])) ? (';dbname=' . $settings['database']['dbname']) : '') .
            ((!empty($settings['database']['charset'])) ? (';charset=' . $settings['database']['charset']) : '');
       
        parent::__construct(
            $dns,
            $settings['database']['username'],
            $settings['database']['password']
        );
    }
}

