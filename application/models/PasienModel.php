<?php
class PasienModel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    private function base()
    {
        return "SELECT 
            ps.NORM,
            ps.NAMA,
            ps.ALAMAT,
            pp.TANGGAL,
            r.DESKRIPSI,
            md.DIAGNOSA,
            md.SNOMED_CT_ID,
            nt.BERAT_BADAN,
            nt.TINGGI_BADAN,
            nt.INDEX_MASSA_TUBUH,
            nt.TBU,
            nt.BBU,
            nt.KATEGORI_TBU,
            nt.KATEGORI_BBU,
            nt.KATEGORI_IMTU,
            nt.KATEGORI_BBTB
        FROM pendaftaran.pendaftaran pp
        LEFT JOIN master.pasien ps ON pp.NORM = ps.NORM
        LEFT JOIN pendaftaran.kunjungan pk ON pk.NOPEN = pp.NOMOR
        LEFT JOIN master.ruangan r ON pk.RUANGAN = r.ID AND r.JENIS=5
        LEFT JOIN medicalrecord.diagnosa md ON md.NOPEN = pp.NOMOR
        LEFT JOIN pendaftaran.tujuan_pasien tp ON tp.NOPEN = pp.NOMOR AND tp.RUANGAN = pk.RUANGAN
        LEFT JOIN master.rl4_icd10 ic ON md.KODE = ic.KODE
        LEFT JOIN medicalrecord.nutrisi nt ON nt.KUNJUNGAN = pk.NOMOR";
    }
    public function getDataPasien($bln)
    {
        return $this->db->query("
        SELECT 
            ps.NORM,
            ps.NAMA,
            ps.ALAMAT,
            pp.TANGGAL,
            r.DESKRIPSI,
            md.DIAGNOSA,
            md.SNOMED_CT_ID,
            nt.BERAT_BADAN,
            nt.TINGGI_BADAN,
            nt.INDEX_MASSA_TUBUH,
            nt.TBU,
            nt.BBU,
            nt.KATEGORI_TBU,
            nt.KATEGORI_BBU,
            nt.KATEGORI_IMTU,
            nt.KATEGORI_BBTB
        FROM pendaftaran.pendaftaran pp
        LEFT JOIN master.pasien ps ON pp.NORM = ps.NORM
        LEFT JOIN pendaftaran.kunjungan pk ON pk.NOPEN = pp.NOMOR
        LEFT JOIN master.ruangan r ON pk.RUANGAN = r.ID AND r.JENIS=5
        LEFT JOIN medicalrecord.diagnosa md ON md.NOPEN = pp.NOMOR
        LEFT JOIN pendaftaran.tujuan_pasien tp ON tp.NOPEN = pp.NOMOR AND tp.RUANGAN = pk.RUANGAN
        LEFT JOIN master.rl4_icd10 ic ON md.KODE = ic.KODE
        LEFT JOIN medicalrecord.nutrisi nt ON nt.KUNJUNGAN = pk.NOMOR
        WHERE 
            r.ID = 101020101
            OR
                r.ID = 101010104
            AND MONTH(pp.TANGGAL) = MONTH(NOW())
            AND YEAR(pp.TANGGAL) = YEAR(NOW())
        GROUP BY md.DIAGNOSA
        LIMIT 10
        ");
    }
    public function getJumlahPasien($bln)
    {
        return $this->getDataPasien($bln)->num_rows();
    }
    public function getDaftarPasien($params)
    {
        return $this->db->query("CALL laporan.LaporanDaftarPasienDiagnosa('".$params['tgl_awal']."', '".$params['tgl_akhir']."', '".$params['ruangan']."', 0, 0)")->result();
    }
    public function getJmlPasienHariIni()
    {
        return $this->db->query("
        SELECT 
            ps.NORM,
            ps.NAMA,
            ps.ALAMAT,
            pp.TANGGAL,
            r.DESKRIPSI,
            md.DIAGNOSA,
            md.SNOMED_CT_ID,
            nt.BERAT_BADAN,
            nt.TINGGI_BADAN,
            nt.INDEX_MASSA_TUBUH,
            nt.TBU,
            nt.BBU,
            nt.KATEGORI_TBU,
            nt.KATEGORI_BBU,
            nt.KATEGORI_IMTU,
            nt.KATEGORI_BBTB
        FROM pendaftaran.pendaftaran pp
        LEFT JOIN master.pasien ps ON pp.NORM = ps.NORM
        LEFT JOIN pendaftaran.kunjungan pk ON pk.NOPEN = pp.NOMOR
        LEFT JOIN master.ruangan r ON pk.RUANGAN = r.ID AND r.JENIS=5
        LEFT JOIN medicalrecord.diagnosa md ON md.NOPEN = pp.NOMOR
        LEFT JOIN pendaftaran.tujuan_pasien tp ON tp.NOPEN = pp.NOMOR AND tp.RUANGAN = pk.RUANGAN
        LEFT JOIN master.rl4_icd10 ic ON md.KODE = ic.KODE
        LEFT JOIN medicalrecord.nutrisi nt ON nt.KUNJUNGAN = pk.NOMOR
        WHERE 
            r.ID = 101020101
            OR 
                r.ID = 101010104
            AND pp.TANGGAL = '".date("Y-m-d")."'
        GROUP BY md.DIAGNOSA
        LIMIT 20
        ")->num_rows();
    }
}