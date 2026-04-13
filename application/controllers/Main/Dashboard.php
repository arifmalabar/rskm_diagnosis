<?php
class Dashboard extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model("PasienModel");
        $this->load->model("DiagnosisModel");
    }
    public function index()
    {
		$this->template = "template/index";
        $this->setView("main/dashboard/index", [
            "pasien" => $this->PasienModel->getDataPasien(DATE('m'))->num_rows(),
            "pasienhrini" => $this->PasienModel->getJmlPasienHariIni(),
            "blnini" => $this->PasienModel->getJumlahPasien(DATE('m')),
            "gizi_baik" => $this->DiagnosisModel->getStatusGizi("Gizi Baik (Normal)"),
            "gizi_obesitas" => $this->DiagnosisModel->getStatusGizi("Obesitas"),
            "gizi_buruk" => $this->DiagnosisModel->getStatusGizi("Obesitas"),
            "pasien_result" => $this->PasienModel->getDataPasien(DATE('m'))->result()
        ]);
    }
}
