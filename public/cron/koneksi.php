<?php
$koneksi = mysqli_connect("localhost","root","root","rms");

// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}
