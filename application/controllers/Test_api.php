<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_api extends CI_Controller {

	function index()
	{
		$this->load->model("user_model");
		if($this->user_model->isNotLogin()) redirect(site_url('/login'));
		$this->load->view('api_view');  
	}

	function action()
	{
		if($this->input->post('data_action'))
		{
			$data_action = $this->input->post('data_action');

			if($data_action == "Delete")
			{
				$api_url = "http://localhost:8080/RestApiCI2/api/delete";

				$form_data = array(
					'id_penjualan'		=>	$this->input->post('id_penjualan')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;




			}

			if($data_action == "Edit")
			{
				$api_url = "http://localhost:8080/RestApiCI2/api/update";

				$form_data = array(
					'jenis_emas'		    =>	$this->input->post('jenis_emas'),
					'tanggal_penjualan'		=>	$this->input->post('tanggal_penjualan'),
					'harga_gram'			=>	$this->input->post('harga_gram'),
					'id_penjualan'			=>	$this->input->post('id_penjualan')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;







			}

			if($data_action == "fetch_single")
			{
				$api_url = "http://localhost:8080/RestApiCI2/api/fetch_single";

				$form_data = array(
					'id_penjualan'		=>	$this->input->post('id_penjualan')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;






			}

			if($data_action == "Insert")
			{
				$api_url = "http://localhost:8080/RestApiCI2/api/insert";
			

				$form_data = array(
					'jenis_emas'		=>	$this->input->post('jenis_emas'),
					'tanggal_penjualan'			=>	$this->input->post('tanggal_penjualan'),
					'harga_gram'			=>	$this->input->post('harga_gram')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;


			}





			if($data_action == "fetch_all")
			{
				$api_url = "http://localhost:8080/RestApiCI2/api";

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				$result = json_decode($response);

				$output = '';

				if(count((array)$result) > 0)
				{
					foreach($result as $row)
					{
						$output .= '
						<tr>
							<td>'.$row->jenis_emas.'</td>
							<td>'.$row->harga_gram.'</td>
							<td>'.date('d F Y', strtotime($row->tanggal_penjualan)).'</td>
							<td><butto type="button" name="edit" class="btn btn-warning btn-xs edit" id="'.$row->id_penjualan.'">Edit</button></td>
							<td><button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row->id_penjualan.'">Delete</button></td>
						</tr>

						';
					}
				}
				else
				{
					$output .= '
					<tr>
						<td colspan="5" align="center">'.$result.'</td>
					</tr>
					';
				}

				echo $output;
			}
		}
	}
	
}

?>
