<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductModel extends Model
{
    protected $table = 'products';

    public function __construct()
    {
        parent::__construct();
        if (!isset($this->db) || $this->db === null) {
            $this->db = lava_instance()->call->database();
        }
    }

    public function all()
    {
        return $this->db->table($this->table)
            ->order_by('id', 'ASC')
            ->get_all();
    }

    public function find($id)
    {
        return $this->db->table($this->table)
            ->where('id', $id)
            ->row_array();
    }

    public function create(array $data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function update($id, array $data)
    {
        return $this->db->table($this->table)
            ->where('id', $id)
            ->update($data);
    }

    public function delete($id)
    {
        return $this->db->table($this->table)
            ->where('id', $id)
            ->delete();
    }
}
