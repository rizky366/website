<?php session_start();

	$koneksi = mysqli_connect("localhost","root","","parkir");



	function query($sql){
		global $koneksi;

		return mysqli_query($koneksi, $sql);
	}


	function hitung($sql){
		return mysqli_num_rows($sql);
	}
	


	function ts($time){
		$jam = $time / (60 * 60);
		return ceil($jam);
	}
	

 ?>