<?php

class Users_Model extends CI_Model
{
    protected $table = 'users';

    public function get_users()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function add_user($arr)
    {
        return $this->db->insert($this->table, $arr);
    }

}

?>
