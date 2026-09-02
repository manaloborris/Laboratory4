<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersModel extends Model
{
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
        if (!isset($this->db) || $this->db === null) {
            $this->db = lava_instance()->call->database();
        }
    }

    public function all()
    {
        return $this->db->table($this->table)->order_by('id', 'ASC')->get_all();
    }
}
