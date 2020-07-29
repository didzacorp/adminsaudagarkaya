<?php

class popupDinasLuarObj  extends configClass{
	var $Prefix = 'popupDinasLuar';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'absensi'; //daftar
	var $TblName_Hapus = 'absensi';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Data';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'JURNAL';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'popupDinasLuarForm';
	var $nomorCheckBox = 0;

	function setTitle(){
		return '';
	}
	function setMenuEdit(){
		return
			"";
	}
	function setTopBar(){
		return "";
	}
	function setMenuView(){
		return "";
	}
	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;
		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\">".$this->setCetakTitle()."</td>
			</tr>
			</table>";

	}

	function set_selector_other2($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;

	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}

	function set_selector_other($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 foreach ($_REQUEST as $key => $value) {
		 $$key = $value;
	 }
	  switch($tipe){

	case 'formBaru':{
			$fm = $this->setFormBaru();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'checkboxChanged':{
			$explodeId = explode(";",$id);
			if( $this->sqlNumRow($this->sqlQuery("select * from temp_hak_akses where id_kas_bank ='".$explodeId[1]."' and jenis = '".$explodeId[0]."' and username='$this->userName'")) !=0 ){
				 if($status !="checked"){
					 	$this->sqlQuery("update temp_hak_akses set status='' where id_kas_bank ='".$explodeId[1]."' and jenis = '".$explodeId[0]."' and username='$this->userName'");
				 }else{
					 $this->sqlQuery("update temp_hak_akses set status='checked' where id_kas_bank ='".$explodeId[1]."' and jenis = '".$explodeId[0]."' and username='$this->userName'");
				 }
		  }else{
			 	$data = array(
								'id_kas_bank' => $explodeId[1],
								'jenis' => $explodeId[0],
								'status' => "checked",
								'username' => $this->userName
							  );
				$this->sqlQuery(sqlInsert("temp_hak_akses",$data));
			 }
		break;
		}

		case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

   	case 'windowSave':{
			$getDataAbsensi = $this->sqlArray($this->sqlQuery("select * from absensi where id ='$idLogAbsensi' "));
			$content = array(
				'tanggalDinas' => $this->generateDate($getDataAbsensi['tanggal']),
			);

		break;
	   }


		case 'simpan':{
			$get= $this->simpan();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	   }

	   default:{
			$other = $this->set_selector_other2($tipe);
			$cek = $other['cek'];
			$err = $other['err'];
			$content=$other['content'];
			$json=$other['json'];
	 break;
	 }
	 }//end switch

		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
   }

	function setPage_OtherScript(){
		$scriptload =

					"<script>
						$(document).ready(function(){

							".$this->Prefix.".loading();
						});

					</script>";

		return
			 "<script type='text/javascript' src='js/popup/popupDinasLuar.js' language='JavaScript' ></script>".
			$scriptload;
	}

	function windowShow(){
		$cek = ''; $err=''; $content='';
		$json = TRUE;	//$ErrMsg = 'tes';
		$form_name = $this->FormName;
		$FormContent = $this->genDaftarInitial($fmSKPD, $fmUNIT, $fmSUBUNIT,$tahun_anggaran);
		$form = centerPage(
				"<form name='$form_name' id='$form_name' method='post' action=''>".
				createDialog(
					$form_name.'_div',
					$FormContent,
					1000,
					500,
					'PILIH TANGGAL',
					'',
					// $this->button(array(
					// 	'value' => 'Simpan',
					// 	'class' => 'btn btn-success',
					// 	'params' => "onclick=$this->Prefix.saveHakAkses();"
					// ))
					// ."&nbsp ".
					$this->button(array(
						'value' => 'Batal',
						'class' => 'btn btn-success',
						'params' => "onclick=$this->Prefix.windowClose();"
					))
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height
				).
				"</form>"
			);
			$content = $form;//$content = 'content';
		//}

		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function genDaftarInitial($nm_account='', $height=''){
		$filterAkun = $_REQUEST['filterAkun'];
		$vOpsi = $this->genDaftarOpsi();
		return
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>".
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>".

				//"<input type='hidden' id='".$this->Prefix."tahun_anggaran' name='".$this->Prefix."tahun_anggaran' value='$tahun_anggaran'>".
				"<input type='hidden' id='postIdPegawai' name='postIdPegawai' value='".$_REQUEST['postIdPegawai']."'>".
			"</div>".
			"<div id=garis style='height:1;border-bottom:1px solid #E5E5E5;'></div>".
			"<div id=contain style='overflow:auto;height:$height;'>".
			//"<div id=contain style='overflow:auto;height:256;'>".
			"<div id='{$this->Prefix}_cont_daftar' style='position:relative' >".
			"</div>
			</div>".
			"<div id='{$this->Prefix}_cont_hal' style='position:relative'>".
				"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
			"</div>";
	}
	function selectAllCheckBox(){
		$hsl = '';
		$jumlahData = $_REQUEST['jumlahData'];
		if(empty($jumlahData))$jumlahData = "25";
		/*if($KeyValueStr!=''){*/
			$hsl ="<input type='checkbox' name='popupDinasLuar_toggle' id='popupDinasLuar_toggle' value='' onclick=popupDinasLuar.checkSemua($jumlahData,'popupDinasLuar_cb','popupDinasLuar_toggle','popupDinasLuar_jmlcek')>";
		/*}*/
		return $hsl;
	}
	function setCekBox($cb, $KeyValueStr, $isi){
	$hsl = '';
	/*if($KeyValueStr!=''){*/
		$hsl = "<input type='checkbox' $isi id='".$this->Prefix."_cb$cb' name='".$this->Prefix."_cb[]'
				value='".$KeyValueStr."' onchange = $this->Prefix.thisChecked('$KeyValueStr','".$this->Prefix."_cb$cb'); >";
	/*}*/
	return $hsl;
}
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){

	 $headerTable =
	 "<thead>
	  <tr>
	   	<th class='th01' style='width:1%;'>No.</th>
	   	<th class='th01' align='center' style='width:8%;'>TANGGAL</th>
	   	<th class='th01' align='center' style='width:80%;'>KETERANGAN</th>
	   </tr>
	   </thead>";

		return $headerTable;
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 global $Main;
	 foreach ($_REQUEST as $key => $value) {
			$$key = $value;
	 }
	 foreach ($isi as $key => $value) {
			$$key = $value;
	 }
	 $kodeRekening = $kode_rekening_1.".".$kode_rekening_2.".".$kode_rekening_3.".".$kode_rekening_4;

		 $Koloms = array();
		 $Koloms[] = array('align="center" width=""', $no.'.' );
		 $Koloms[] = array('align="center" ',"<span style='cursor:pointer;color:red;' onclick =$this->Prefix.windowSave($id)>".$this->generateDate($tanggal)."</span>");
		 $Koloms[] = array('align="left" ',$keterangan);

	 return $Koloms;
	}

	function genDaftarOpsi(){
	 global $Ref, $Main;
	 foreach ($_REQUEST as $key => $value) {
			$$key = $value;
	 }

	 if(empty($jumlahData)){
		 $jumlahData = 50;
	 }
		$getDataPegawai = $this->sqlArray($this->sqlQuery("select * from ref_pegawai where id = '$postIdPegawai'"));
	$TampilOpt =
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<table style='width:100%'>
			<tr>
			<td style='width:120px'>NAMA PEGAWAI</td><td style='width:10px'>:</td>
			<td><input type='text' name ='filterNamaPegawaiDinas' id = 'filterNamaPegawaiDinas' value ='".$getDataPegawai['nama']."'  class='form-control' readonly> </td>
			</tr>
			<tr>
			<td style='width:120px'>JUMLAH DATA</td><td style='width:10px'>:</td>
			<td><input type='text' name ='jumlahData' id = 'jumlahData' value ='$jumlahData' style='width:30px;' class='form-control2'> <button type='button' onclick ='$this->Prefix.refreshList(true)' >Tampilkan</button></td>
			</tr>
			<input type='hidden' id='postIdPegawai' name='postIdPegawai' value='$postIdPegawai'>
			</table>".
			"</div>"
			;
		return array('TampilOpt'=>$TampilOpt);
	}

	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID'];
		foreach ($_REQUEST as $key => $value) {
			 $$key = $value;
		}
		$arrKondisi = array();
		$getDataPegawai = $this->sqlArray($this->sqlQuery("select * from ref_pegawai where id = '$postIdPegawai'"));
		$arrKondisi[] = "nik_pegawai = '".$getDataPegawai['nik']."'";
		$arrKondisi[] = "status = 'DINAS LUAR'";
		$arrKondisi[] = "year(tanggal) = $this->tahunAnggaran";
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();


			$Order= join(',',$arrOrders);
			$OrderDefault = ' ';// Order By no_terima desc ';
			$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;

		$this->pagePerHal = $_REQUEST['jumlahData'];
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal;
		$HalDefault=cekPOST($this->Prefix.'_hal',1);
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal;
		$Limit = $Mode == 3 ? '': $Limit;
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);

	}

}
$popupDinasLuar = new popupDinasLuarObj();

?>
