<?php

ob_start("ob_gzhandler");
/* ganti selector di index */
include("common/vars.php");
include("config.php");


$Pg = isset($HTTP_GET_VARS["Pg"]) ? $HTTP_GET_VARS["Pg"] : "";

if (CekLogin () == false){

	$tipe = $_GET['tipe'];
	if($tipe==''){//bukan ajax
		header("Location:index.php?");//header("Location: http://$Main->SITE/");
	}else{
		setcookie('coOff','1');
	}
}

//if (CekLogin ()) {
  //  setLastAktif();

    switch ($Pg) {


		case 'member':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include("pages/member/member.php"); //break;
				$member->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}


		case 'pembayaranKomisi':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include("pages/pembayaranKomisi/pembayaranKomisi.php"); //break;
				$pembayaranKomisi->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}


		case 'produk':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include("pages/produk/produk.php"); //break;
				$produk->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}

		case 'artikel':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include("pages/artikel/artikel.php"); //break;
				$artikel->selector();
			}else{
				
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}

		case 'slider':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include("pages/slider/slider.php"); //break;
				$slider->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}

	}

	ob_flush();
	flush();

//} else {  header("Location: http://atisisbada.net/");}
?>
