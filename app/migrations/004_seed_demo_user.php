<?php

class Seed_demo_user {

    private $_lava;
    protected $dbforge;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->dbforge();
    }

    public function up()
    {
        $stmt = $this->_lava->db->raw(
            'SELECT id FROM users WHERE username = ? LIMIT 1',
            ['admin']
        );

        if (!$stmt->fetch()) {
            $this->_lava->db->raw(
                'INSERT INTO users (username, email, password, role, is_active) VALUES (?, ?, ?, ?, ?)',
                ['admin', 'admin@example.com', password_hash('password', PASSWORD_DEFAULT), 'admin', 1]
            );
        }
    }

    public function down()
    {
        $this->_lava->db->raw('DELETE FROM users WHERE username = ?', ['admin']);
    }
}