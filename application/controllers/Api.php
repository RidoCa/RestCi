<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
		$this->load->library('form_validation');
		$this->load->model("user_model");
		// if($this->user_model->isNotLogin()) redirect(site_url('/login'));
	}

	function index()
	{
		$data = $this->api_model->fetch_all();
		echo json_encode($data->result_array());
	}

	function insert()
	{
		$this->form_validation->set_rules('jenis_emas', 'Jenis Emas', 'required');
		$this->form_validation->set_rules('tanggal_penjualan', 'Tanggal Penjualan Emas', 'required');
		$this->form_validation->set_rules('harga_gram', 'Harga Emas', 'required');
		if($this->form_validation->run())
		{
			$data = array(
					'jenis_emas'		          =>	$this->input->post('jenis_emas'),
					'tanggal_penjualan'			  =>	$this->input->post('tanggal_penjualan'),
					'harga_gram'		          =>	$this->input->post('harga_gram')
			);

			$this->api_model->insert_api($data);

			$array = array(
				'success'		=>	true
			);
		}
		else
		{
			$array = array(
				'error'					=>	true,
				'jenis_emas'		          =>	form_error('jenis_emas'),
				'tanggal_penjualan'			  =>	form_error('tanggal_penjualan'),
				'harga_gram'		          =>	form_error('harga_gram')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_single()
	{
		if($this->input->post('id_penjualan'))
		{
			$data = $this->api_model->fetch_single_data($this->input->post('id_penjualan'));

			foreach($data as $row)
			{
				$output['jenis_emas'] = $row['jenis_emas'];
				$output['tanggal_penjualan'] = $row['tanggal_penjualan'];
				$output['harga_gram'] = $row['harga_gram'];
			}
			echo json_encode($output);
		}
	}

	function update()
	{
		$this->form_validation->set_rules('jenis_emas', 'Jenis Emas', 'required');
		$this->form_validation->set_rules('tanggal_penjualan', 'Tanggal Penjualan Emas', 'required');
		$this->form_validation->set_rules('harga_gram', 'Harga Emas', 'required');
		if($this->form_validation->run())
		{	
			$data = array(
				'jenis_emas'		          =>	$this->input->post('jenis_emas'),
				'tanggal_penjualan'			  =>	$this->input->post('tanggal_penjualan'),
				'harga_gram'		          =>	$this->input->post('harga_gram')
			);

			$this->api_model->update_api($this->input->post('id_penjualan'), $data);

			$array = array(
				'success'		=>	true
			);
		}
		else
		{
			$array = array(
				'error'				=>	ture,
				'jenis_emas'		          =>	form_error('jenis_emas'),
				'tanggal_penjualan'			  =>	form_error('tanggal_penjualan'),
				'harga_gram'		          =>	form_error('harga_gram')
			);
		}
		echo json_encode($array);
	}

	function delete()
	{
		if($this->input->post('id_penjualan'))
		{
			if($this->api_model->delete_single_data($this->input->post('id_penjualan')))
			{
				$array = array(

					'success'	=>	true
				);
			}
			else
			{
				$array = array(
					'error'		=>	true
				);
			}
			echo json_encode($array);
		}
	}

}


?>