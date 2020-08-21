<?php
class Api_model extends CI_Model
{
	function fetch_all()
	{
		$this->db->order_by('id_penjualan', 'DESC');
		return $this->db->get('penjualan');
	}

	function insert_api($data)
	{
		$this->db->insert('penjualan', $data);
	}

	function fetch_single_data($penjualan_id)
	{
		$this->db->where('id_penjualan', $penjualan_id);
		$query = $this->db->get('penjualan');
		return $query->result_array();
	}

	function update_api($penjualan_id, $data)
	{
		$this->db->where('id_penjualan', $penjualan_id);
		$this->db->update('penjualan', $data);
	}

	function delete_single_data($penjualan_id)
	{
		$this->db->where('id_penjualan', $penjualan_id);
		$this->db->delete('penjualan');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

?>