<?php
class RuanganModel extends CI_Model
{
    public function getData()
    {
        return $this->db->where("status", 1)->get("master.ruangan")->result();
    }
}
