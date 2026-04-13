<?php
class Dashboard extends CI_Controller
{
    private $tgl_awal, $tgl_akhir;
    public function __construct() {
        parent::__construct();
        $this->template = "template/index";
        $this->load->model("PasienModel");
        $this->load->model("DiagnosisModel");
        $this->load->model("RuanganModel");
    }
    public function index()
    {
        $this->tgl_awal= DATE('Y-m-d');
        $this->tgl_akhir = DATE('Y-m-d');
        $ruangan = '101020101';
        $data = [
            "tgl_awal" => $this->tgl_awal,
            "tgl_akhir" => $this->tgl_akhir,
            "ruangan" => $ruangan
        ];
        $this->setView("main/dashboard/index", [
            "pasien" => $this->PasienModel->getDataPasien(DATE('m'))->num_rows(),
            "pasienhrini" => $this->PasienModel->getJmlPasienHariIni(),
            "blnini" => $this->PasienModel->getJumlahPasien(DATE('m')),
            "gizi_baik" => $this->DiagnosisModel->getStatusGizi("Gizi Baik (Normal)"),
            "gizi_obesitas" => $this->DiagnosisModel->getStatusGizi("Obesitas"),
            "gizi_buruk" => $this->DiagnosisModel->getStatusGizi("Gizi Kurang"),
            "pasien_result" => $this->PasienModel->getDataPasien(DATE('m'))->result(),
            "ruangan" => $this->RuanganModel->getData(),
            "daftar_pasien" => $this->PasienModel->getDaftarPasien($data),
            "tgl_akhir" => $this->tgl_akhir,
            "tgl_awal" => $this->tgl_awal
        ]);
    }
    public function search()
    {
        /*$tgl_awal= '2025-12-25';
        $tgl_akhir = '2026-03-25';
        $ruangan = '101020101';*/
        
        $this->tgl_awal= $this->input->post("tgl_awal");
        $this->tgl_akhir = $this->input->post("tgl_akhir");
        $ruangan = $this->input->post("ruangan");

        $data = [
            "tgl_awal" => $this->tgl_awal,
            "tgl_akhir" => $this->tgl_akhir,
            "ruangan" => $ruangan
        ];
        $this->setView("main/dashboard/index", [
            "pasien" => $this->PasienModel->getDataPasien(DATE('m'))->num_rows(),
            "pasienhrini" => $this->PasienModel->getJmlPasienHariIni(),
            "blnini" => $this->PasienModel->getJumlahPasien(DATE('m')),
            "gizi_baik" => $this->DiagnosisModel->getStatusGizi("Gizi Baik (Normal)", $this->tgl_awal, $this->tgl_akhir),
            "gizi_obesitas" => $this->DiagnosisModel->getStatusGizi("Obesitas", $this->tgl_awal, $this->tgl_akhir),
            "gizi_buruk" => $this->DiagnosisModel->getStatusGizi("Gizi Kurang", $this->tgl_awal, $this->tgl_akhir),
            "pasien_result" => $this->PasienModel->getDataPasien(DATE('m'))->result(),
            "ruangan" => $this->RuanganModel->getData(),
            "daftar_pasien" => $this->PasienModel->getDaftarPasien($data),
            "tgl_akhir" => $this->tgl_akhir,
            "tgl_awal" => $this->tgl_awal
        ]);
    }
}
