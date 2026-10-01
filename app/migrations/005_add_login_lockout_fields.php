<?php

class Add_login_lockout_fields {

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
            'ALTER TABLE users
             ADD COLUMN failed_attempts INT UNSIGNED NOT NULL DEFAULT 0,
             ADD COLUMN locked_until DATETIME NULL'
        );
    }

    public function down()
    {
        $this->_lava->db->raw(
            'ALTER TABLE users
             DROP COLUMN failed_attempts,
             DROP COLUMN locked_until'
        );
    }
}