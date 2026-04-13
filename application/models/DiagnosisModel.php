<?php
class DiagnosisModel extends CI_Model
{
    public function getStatusGizi($status, $tgl_awal = null, $tgl_akhir = null)
    {
       if($tgl_awal != null && $tgl_akhir != null)
        {
             return $this->db->select("*")
                ->from("medicalrecord.nutrisi AS nt")
                 ->where("nt.KATEGORI_BBTB", $status)
                 ->where("nt.TANGGAL >=", $tgl_awal)
                    ->where("nt.TANGGAL <=", $tgl_akhir)
                 ->get()
                 ->num_rows();
        } else {
             return $this->db->select("*")
                ->from("medicalrecord.nutrisi AS nt")
                 ->where("nt.KATEGORI_BBTB", $status)
                 ->where("MONTH(nt.TANGGAL) >=", date("m"))
                 ->get()
                 ->num_rows();
        }
    }
}
