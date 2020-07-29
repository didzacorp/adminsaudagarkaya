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

		//SUPER GOAT
		case 'refMember':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/refMember/refMember.php"); //break;
				$refMember->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'refUser':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/refUser/refUser.php"); //break;
				$refUser->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'modulTransaksi':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/modulTransaksi/modulTransaksi.php"); //break;
				$modulTransaksi->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'modulKomisi':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/modulKomisi/modulKomisi.php"); //break;
				$modulKomisi->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'refFunnel':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/refFunnel/refFunnel.php"); //break;
				$refFunnel->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'refTraining':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/refTraining/refTraining.php"); //break;
				$refTraining->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'refCopyWriting':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/refCopyWriting/refCopyWriting.php"); //break;
				$refCopyWriting->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'refNews':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/refNews/refNews.php"); //break;
				$refNews->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'refProduk':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/refProduk/refProduk.php"); //break;
				$refProduk->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}


		//SUPER GOAT
		case 'perhitunganGaji':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/perhitunganGaji/perhitunganGaji.php"); //break;
				$perhitunganGaji->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'settingSystem':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/settingSystem/settingSystem.php"); //break;
				$settingSystem->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'refGajiPokok':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/refGajiPokok/refGajiPokok.php"); //break;
				$refGajiPokok->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'dinasLuar':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/dinasLuar/dinasLuar.php"); //break;
				$dinasLuar->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'logAbsensi':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/logAbsensi/logAbsensi.php"); //break;
				$logAbsensi->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'refPemda':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/refPemda/refPemda.php"); //break;
				$refPemda->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'refTahunAnggaran':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/refTahunAnggaran/refTahunAnggaran.php"); //break;
				$refTahunAnggaran->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'refBank':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/refBank/refBank.php"); //break;
				$refBank->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'refKas':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/refKas/refKas.php"); //break;
				$refKas->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'refPegawai':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/refPegawai/refPegawai.php"); //break;
				$refPegawai->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'refProjek':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/refProjek/refProjek.php"); //break;
				$refProjek->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'refPiutang':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/refPiutang/refPiutang.php"); //break;
				$refPiutang->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'targetPendapatan':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/targetPendapatan/targetPendapatan.php"); //break;
				$targetPendapatan->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'refPihakLuar':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/refPihakLuar/refPihakLuar.php"); //break;
				$refPihakLuar->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}
		case 'refRekening':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/refRekening/refRekening.php"); //break;
				$refRekening->selector();
			}else{
				header("Location:index.php?");//header("Location: http://$Main->SITE/");
			}
			break;
		}

		case 'saldoAwal':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/saldoAwal/saldoAwal.php");
				$saldoAwal->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}
		case 'userManage':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/userManage/userManage.php");
				$userManage->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}
		case 'listHakAkses':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/userManage/listHakAkses.php");
				$listHakAkses->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}
		case 'popupRekening':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/popup/popupRekening.php");
				$popupRekening->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}
		case 'popupPekerjaan':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/popup/popupPekerjaan.php");
				$popupPekerjaan->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}
		case 'popupDinasLuar':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/popup/popupDinasLuar.php");
				$popupDinasLuar->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}
		case 'mutasiSaldo':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/mutasiSaldo/mutasiSaldo.php");
				$mutasiSaldo->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}
		case 'mutasiSaldoIns':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/mutasiSaldo/mutasiSaldoIns.php");
				$mutasiSaldoIns->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}
		case 'penerimaanSaldo':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/penerimaanSaldo/penerimaanSaldo.php");
				$penerimaanSaldo->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}
		case 'penerimaanSaldoIns':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/penerimaanSaldo/penerimaanSaldoIns.php");
				$penerimaanSaldoIns->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}
		case 'pengeluaranSaldo':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/pengeluaranSaldo/pengeluaranSaldo.php");
				$pengeluaranSaldo->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}
		case 'pengeluaranSaldoIns':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/pengeluaranSaldo/pengeluaranSaldoIns.php");
				$pengeluaranSaldoIns->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}
		case 'bukuUmum':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/bukuUmum/bukuUmum.php");
				$bukuUmum->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}
		case 'pinjamanSaldo':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/pinjamanSaldo/pinjamanSaldo.php");
				$pinjamanSaldo->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}
		case 'bayarPinjaman':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/bayarPinjaman/bayarPinjaman.php");
				$bayarPinjaman->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}
		case 'pengajuanSPJ':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/pengajuanSPJ/pengajuanSPJ.php");
				$pengajuanSPJ->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}
		case 'detailSPJ':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/detailSPJ/detailSPJ.php");
				$detailSPJ->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}
		case 'detailSPJIns':{
			if (CekLogin()) {  setLastAktif();
				include('common/daftarobj.php');
				include('common/configClass.php');
				include("pages/detailSPJ/detailSPJIns.php");
				$detailSPJIns->selector();
			}else{
				header("Location:index.php?");
			}
			break;
		}

	}

	ob_flush();
	flush();

//} else {  header("Location: http://atisisbada.net/");}
?>
