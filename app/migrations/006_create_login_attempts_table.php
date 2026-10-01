<?php

class Create_login_attempts_table {

    private $_lava;
    protected $dbforge;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->dbforge();
    }

    public function up()
    {
        $this->_lava->db->raw(
            'CREATE TABLE IF NOT EXISTS login_attempts (
                identifier VARCHAR(191) NOT NULL,
                failed_attempts INT UNSIGNED NOT NULL DEFAULT 0,
                locked_until DATETIME NULL,
                PRIMARY KEY (identifier)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
        );
    }

    public function down()
    {
        $this->_lava->db->raw('DROP TABLE IF EXISTS login_attempts');
    }
}