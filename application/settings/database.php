<?php
// ** MySQL settings ** //
defined('_ENGINE') or die('Access Denied');
return array(
    'webhost'  => 'autotestdrive.vha.worldserver.su',
    'database' => array(
        'adapter' => 'mysqli',
        'params'  => array(
            'host'     => 'localhost', // Имя хоста
            'username' => 'total_new', // Имя пользователя MySQL
            'password' => 'Y6rBScf63hH', // ...и пароль
            'dbname'   => 'total_new', // Имя базы данных
            'charset' => 'UTF8' // Кодировка базы данных, в большинстве случаев не требует изменений // DB_COLLATE - 
                                // Проверка базы данных, чаще всего значение не требует изменений и остается пустым.
        ),
        'tablePrefix' => 'total_',
    )
);