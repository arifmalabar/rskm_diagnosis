<?php
class DiagnosisModel extends CI_Model
{
    public function getStatusGizi($status)
    {
        return $this->db->select("*")
                ->from("medicalrecord.nutrisi AS nt")
                 ->where("nt.KATEGORI_BBTB", $status)
                 ->get()
                 ->num_rows();
    }
}
