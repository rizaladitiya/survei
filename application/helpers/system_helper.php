<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if(!function_exists('baca_konfig'))
{
	function baca_konfig($nama)
	{
		$CI=& get_instance();
		$CI->load->library('m_db');
		$item=$CI->m_db->get_row('config',array(),$nama);
		return $item;
	}
}
if(!function_exists('referrer'))
{
	function referrer()
	{
		$CI=& get_instance();
		$CI->load->library('user_agent');
		if ($CI->agent->is_referral())
		{
    		return $CI->agent->referrer();
		}
	}
}
if(!function_exists('getsession'))
{
	function getsession() {
		// Get current CodeIgniter instance
		$CI =& get_instance();
		// We need to use $CI->session instead of $this->session
		$data=(object)array(
				'id'=>$CI->session->userdata('logged_in')['id'],
				'nama'=>$CI->session->userdata('logged_in')['nama'],
				'user'=>$CI->session->userdata('logged_in')['user']
					);
		return $data;
	}
}
if(!function_exists('getbobot'))
{
	function getbobot($bobot)
	{
		if(empty($bobot)){
			$hasil = "";
		} else {
			$hasil = $bobot->bobot;
		}
		return $hasil;
	}
}
if(!function_exists('getjawaban'))
{
	function getjawaban($jawaban)
	{
		if(empty($jawaban)){
			$hasil = "";
		} else {
			$hasil = $jawaban->jawaban;
		}
		return $hasil;
	}
}
if(!function_exists('kontroler'))
{
	function kontroler($nama)
	{
		$CI=& get_instance();
		$item = $CI->uri->segment(1);
		if (strtolower($item)==strtolower($nama)){
				return " active";
			}
	}
	
}
if(!function_exists('sekarang'))
{
	function sekarang()
	{
		return date('Y-m-d');
	}
}
if(!function_exists('now'))
{
	function now()
	{
		return date("Y-m-d H:i:s");
	}
}
if(!function_exists('tglshort'))
{
	function tglshort($tgl)
	{
		return date('d-M-y',strtotime($tgl));
	}
}
if(!function_exists('showmenu'))
{
	function showmenu($kelompok,$array)
	{
		if (in_array($kelompok, $array)) {
    		return "''";
		}else {
			return "style='display:none'";
			}
	}
}
if(!function_exists('tglsaja'))
{
	function tglsaja($tgl)
	{
		return date('Y-m-d',strtotime($tgl));
	}
}

if(!function_exists('httpPost'))
{
	function httpPost($url, $data)
	{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
	}
}

