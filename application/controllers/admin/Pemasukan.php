<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemasukan extends CI_Controller
{
    //load Model & Library
    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi_model');
        $this->load->model('car_model');
        $this->load->model('paket_model');
        $this->load->model('driver_model');
        $this->load->model('user_model');
        $this->load->library('pagination');

        $id = $this->session->userdata('id');
        $user = $this->user_model->user_detail($id);
        if ($user->role_id == 2) {
            redirect('admin/dashboard');
        }
    }
    //listing data Pemasukan
    public function index()
    {

        $config['base_url']       = base_url('admin/pemasukan/index/');
        $config['total_rows']     = count($this->transaksi_model->total_row_pemasukan());
        $config['per_page']       = 10;
        $config['uri_segment']    = 4;

        //Membuat Style pagination untuk BootStrap v4
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';

        //Limit dan Start
        $limit                    = $config['per_page'];
        $start                    = ($this->uri->segment(4)) ? ($this->uri->segment(4)) : 0;
        //End Limit Start
        $this->pagination->initialize($config);

        $pemasukan              = $this->transaksi_model->get_pemasukan($limit, $start);
        $total_pemasukan        = $this->transaksi_model->total_pemasukan();
        $data = [
            'title'             => 'Data Pemasukan',
            'pemasukan'         => $pemasukan,
            'total_pemasukan'   => $total_pemasukan,
            'pagination'        => $this->pagination->create_links(),
            'content'           => 'admin/pemasukan/index_pemasukan'
        ];
        $this->load->view('admin/layout/wrapp', $data, FALSE);
    }

    // Filter Semua Pemasukan
    public function filter_alpemasukan()
    {
        $startdate = "";
        $enddate = "";

        if (isset($_POST['start_date'])) {
            $startdate = $_POST['start_date'];
        }

        if (isset($_POST['end_date'])) {
            $enddate = $_POST['end_date'];
        }



        $filter_alpemasukan            = $this->transaksi_model->filter_alpemasukan($startdate, $enddate);
        $total_pemasukan_aldate        = $this->transaksi_model->total_pemasukan_aldate($startdate, $enddate);



        // $total_pemasukan        = $this->kas_model->total_pemasukan();
        // $total_pengeluaran      = $this->kas_model->total_pengeluaran();

        $data = [
            'title'                       => 'Data Pemasukan tanggal',
            'filter_alpemasukan'          => $filter_alpemasukan,
            'total_pemasukan_aldate'      => $total_pemasukan_aldate,
            'content'                     => 'admin/pemasukan/filter_alpemasukan'
        ];

        $this->session->set_flashdata('messagefilter',  'Menampilkan Data dari Tanggal ' . $startdate . ' Sampai Tanggal ' . $enddate);
        $this->load->view('admin/layout/wrapp', $data, FALSE);
    }
    // Filter Pemasukan Per User
    public function filter_pemasukan()
    {
        // $startdate = '2020-04-26';
        // $enddate = '2020-04-25';

        // $startdate = $this->input->post('start_date');
        // $enddate = $this->input->post('end_date');

        $asrama = "";
        $startdate = "";
        $enddate = "";

        if (isset($_POST['asrama'])) {
            $asrama = $_POST['asrama'];
        }
        if (isset($_POST['start_date'])) {
            $startdate = $_POST['start_date'];
        }

        if (isset($_POST['end_date'])) {
            $enddate = $_POST['end_date'];
        }

        $listasrama                  = $this->asrama_model->get_asrama();

        $filter_pemasukan            = $this->kas_model->filter_pemasukan($startdate, $enddate, $asrama);
        $total_pemasukan_date        = $this->kas_model->total_pemasukan_date($startdate, $enddate, $asrama);



        // $total_pemasukan        = $this->kas_model->total_pemasukan();
        // $total_pengeluaran      = $this->kas_model->total_pengeluaran();

        $data = [
            'title'                     => 'Data Pemasukan tanggal',
            'filter_pemasukan'          => $filter_pemasukan,
            'listasrama'                => $listasrama,
            'total_pemasukan_date'      => $total_pemasukan_date,
            'content'                   => 'admin/pemasukan/filter_pemasukan'
        ];

        $this->session->set_flashdata('messagefilter',  'Menampilkan Data dari Tanggal ' . date("d/m/Y", strtotime($startdate)) . ' Sampai Tanggal ' . date("d/m/Y", strtotime($enddate)));
        $this->load->view('admin/layout/wrapp', $data, FALSE);
    }

    // Update Data Pemasukan
    public function update($id)
    {
        $pemasukan = $this->transaksi_model->detail_pemasukan($id);
        if (!$pemasukan) {
            redirect('admin/pemasukan');
        }

        $car = $this->car_model->get_car();
        $paket = $this->paket_model->get_allpaket();
        $driver = $this->driver_model->get_driver();
        // Validasi
        $this->form_validation->set_rules(
            'spj',
            'Spj',
            'required',
            [
                'required'      => 'Spj harus di isi',
            ]
        );

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'title'                 => 'Update Pemasukan',
                'car'                   => $car,
                'paket'                 => $paket,
                'driver'                => $driver,
                'pemasukan'             => $pemasukan,
                'content'               => 'admin/pemasukan/update_pemasukan'
            ];
            $this->load->view('admin/layout/wrapp', $data, FALSE);
        }else{

            $kas_masukfinal = $pemasukan->harga-$this->input->post('spj')-$this->input->post('bbm')-$this->input->post('toll')-$this->input->post('parkir')-$this->input->post('uang_makan')-$this->input->post('uang_inap')-$this->input->post('ppn')-$this->input->post('pph')-$this->input->post('fee');
            $data  = [
                'id'                        => $id,
                'user_id'                   => $this->session->userdata('id'),
                'payment_status'            => $this->input->post('payment_status'),
                'bbm'                       => $this->input->post('bbm'),
                'toll'                      => $this->input->post('toll'),
                'parkir'                    => $this->input->post('parkir'),
                'spj'                       => $this->input->post('spj'),
                'uang_makan'                => $this->input->post('uang_makan'),
                'uang_inap'                 => $this->input->post('uang_inap'),
                'ppn'                       => $this->input->post('ppn'),
                'pph'                       => $this->input->post('pph'),
                'fee'                       => $this->input->post('fee'),
                'kas_masuk'                 => $kas_masukfinal,
                'status_update'             => 1,
                'date_updated'              => time()
            ];
            $this->transaksi_model->update($data);
            $this->session->set_flashdata('message', 'Data Transaksi telah di Update');
            redirect(base_url('admin/pemasukan'), 'refresh');
        }
    }

    // View Detail Pemasukan
    public function view($id)
    {
        $pemasukan = $this->transaksi_model->detail_pemasukan($id);

        //End Validasi
        $data = [
            'title'                 => 'Detail Data',
            'pemasukan'             => $pemasukan,
            'content'               => 'admin/pemasukan/view_pemasukan'
        ];
        $this->load->view('admin/layout/wrapp', $data, FALSE);
    }

    // HAPUS DATA PEMASUKAN
    public function delete($id)
    {
        //Proteksi delete
        is_login();

        $pemasukan = $this->kas_model->kas_detail($id);
        //Hapus gambar

        if ($pemasukan->foto != "") {
            unlink('./assets/img/donasi/' . $pemasukan->foto);
            // unlink('./assets/img/artikel/thumbs/' . $berita->berita_gambar);
        }
        //End Hapus Gambar
        $data = ['id'   => $pemasukan->id];
        $this->kas_model->delete($data);
        $this->session->set_flashdata('message', 'Data telah di Hapus');
        redirect($_SERVER['HTTP_REFERER']);
    }

    // AUTOCOMPLETE
    function get_autocomplete()
    {
        if (isset($_GET['term'])) {
            $result = $this->kas_model->search_blog($_GET['term']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label'            => $row->donatur_name,
                        'donatur_phone'    => $row->donatur_phone,
                    );
                echo json_encode($arr_result);
            }
        }
    }
}
