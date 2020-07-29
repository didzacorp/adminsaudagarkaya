<?php

class popupPekerjaanObj  extends configClass{
	var $Prefix = 'popupPekerjaan';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'piutang'; //daftar
	var $TblName_Hapus = 'piutang';
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
	var $FormName = 'popupPekerjaanForm';
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

		// case 'windowshow':{
		// 		$fm = $this->windowShow();
		// 		$cek = $fm['cek'];
		// 		$err = $fm['err'];
		// 		$content = $fm['content'];
		// 	break;
		// }
		case 'windowshow':{
				$fm = $this->windowShowBootstrap();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

		case 'windowSave':{
			$getDataPekerjaan = $this->sqlArray($this->sqlQuery("select * from piutang where id ='$idPekerjaan' "));
			$getDataPemda = $this->sqlArray($this->sqlQuery("select * from ref_pemda where id = '".$getDataPekerjaan['id_pemda']."'"));
			$content = array(
				'namaPekerjaan' => $getDataPekerjaan['pekerjaan'],
				'idPekerjaan' => $idPekerjaan,
				'namaPemda' => $getDataPemda['nama_pemda'],
				'idPemda' => $getDataPekerjaan['id_pemda'],
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
			 "<script type='text/javascript' src='js/popup/popupPekerjaan.js' language='JavaScript' ></script>".
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
					600,
					500,
					'Pilih REKENING',
					'',
					// $this->button(array(
					// 	'value' => 'Simpan',
					// 	'class' => 'btn btn-success',
					// 	'params' => "onclick=$this->Prefix.saveHakAkses();"
					// ))
					// ."&nbsp ".
					// $this->button(array(
					// 	'value' => 'Batal',
					// 	'class' => 'btn btn-success',
					// 	'params' => "onclick=$this->Prefix.windowClose();"
					// ))
					""
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height
				).
				"</form>"
			);
			$content = $form;//$content = 'content';
		//}

		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


	function selectAllCheckBox(){
		$hsl = '';
		$jumlahData = $_REQUEST['jumlahData'];
		if(empty($jumlahData))$jumlahData = "25";
		/*if($KeyValueStr!=''){*/
			$hsl ="<input type='checkbox' name='popupPekerjaan_toggle' id='popupPekerjaan_toggle' value='' onclick=popupPekerjaan.checkSemua($jumlahData,'popupPekerjaan_cb','popupPekerjaan_toggle','popupPekerjaan_jmlcek')>";
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
	   	<th class='th01' width='50' >No.</th>
			<th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>NOMOR SPK</th>
			<th class='th01' style='text-align:center;vertical-align:middle;width:7%;'>TANGGAL SPK</th>
			<th class='th01' style='text-align:center;vertical-align:middle;width:7%;'>KATEGORI</th>
			<th class='th01' style='text-align:center;vertical-align:middle;width:40%;'>PEKERJAAN</th>
			<th class='th01' style='text-align:center;vertical-align:middle;width:20%;'>NAMA PEMDA</th>
			<th class='th01' style='text-align:center;vertical-align:middle;width:15%;'>NILAI KONTRAK</th>
			<th class='th01' style='text-align:center;vertical-align:middle;width:15%;'>PPN</th>
			<th class='th01' style='text-align:center;vertical-align:middle;width:15%;'>PPH</th>
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
	 $Koloms = array();
	$Koloms[] = array('align="center"', $no.'.' );
	$Koloms[] = array('align="left" valign="middle"',"<span style='cursor:pointer;color:red;' onclick =$this->Prefix.windowSave($id)>$nomor_spk</span>");
	$Koloms[] = array('align="center" valign="middle"',$this->generateDate($tanggal_spk));
	if($kategori == 1){
		$kategori = "RUTIN";
	}elseif($kategori == 2){
		$kategori = "PROJEK";
	}elseif($kategori == 3){
		$kategori = "LAIN LAIN";
	}
	$Koloms[] = array('align="left" valign="middle"',$kategori);
	$Koloms[] = array('align="left" valign="middle"',$pekerjaan);
	$getNamaPemda = $this->sqlArray($this->sqlQuery("select * from ref_pemda where id = '$id_pemda'"));
	$namaPemda = $getNamaPemda['nama_pemda'];
	$Koloms[] = array('align="left" valign="middle"',$namaPemda);
	if($status == '1'){
		$status = "AKTIF";
	}else{
		$status = "TIDAK AKTIF";
	}
	$Koloms[] = array('align="right" valign="middle"',$this->numberFormat($nilai_kontrak));
	$Koloms[] = array('align="right" valign="middle"',$this->numberFormat($ppn));
	$Koloms[] = array('align="right" valign="middle"',$this->numberFormat($pph));
	return $Koloms;
	}

	function genDaftarOpsi(){
	 global $Ref, $Main;
	 foreach ($_REQUEST as $key => $value) {
			$$key = $value;
	 }
	 $arrayJenisHakAkes = array(
		 array("1","BANK"),
		 array("2","KAS"),
	 );
	 if(empty($jumlahData)){
		 $jumlahData = 50;
	 }
	 $arrayKategori = array(
		 array('1','RUTIN'),
		 array('2','PROJEK'),
		 array('3','LAIN LAIN'),
	 );


	 $comboKategori = cmbArray('filterKategori',$filterKategori,$arrayKategori,'-- KATEGORI --'," class='form-control form-control-sm' ");

			if(empty($tahunAnggaran))$tahunAnggaran = $this->tahunAnggaran;
			$TampilOpt = "
				<div class='form-group'>
					<div class='row' style='margin-top:5px !important;'>
						<label class='col-sm-2 control-label' style='margin-top:6px;color: black;font-size:15px;'>TAHUN</label>
						<div class='col-sm-1'>
							<input type='text' class='form-control form-control-sm' id='tahunAnggaran' name='tahunAnggaran' style='width:80px;' value='$tahunAnggaran' >
						</div>
						<label class='col-sm-1 control-label' style='margin-top:6px;color: black;font-size:15px;'>KATEGORI</label>
						<div class='col-sm-3'>
							$comboKategori
						</div>

					</div>
					<div class='row' style='margin-top:5px !important;'>

						<label class='col-sm-2 control-label' style='margin-top:6px;color: black;font-size:15px;'>NAMA PEKERJAAN</label>
						<div class='col-sm-5'>
							<input type='text' name ='filterNamaPekerjaan' id = 'filterNamaPekerjaan' class='form-control form-control-sm' value ='$filterNamaPekerjaan'>
						</div>

						<div class='col-sm-1'>
 								<input type='hidden' id='postKategori' name='postKategori' value='".$_REQUEST['postKategori']."'>
								<input class='btn btn-info btn-sm' style='background-color:#e8e8e8;color:black;' type='button' value='Tampilkan' onclick= $this->Prefix.refreshList(true);>
						</div>
					</div>


			</div>
				";
		return array('TampilOpt'=>$TampilOpt);
	}

	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID'];
		foreach ($_REQUEST as $key => $value) {
			 $$key = $value;
		}
		$arrKondisi = array();
		$arrKondisi[] = "status = '1'";
		if(!empty($tahunAnggaran)){
			$arrKondisi[] = "tahun = '$tahunAnggaran'";
		}else{
			$arrKondisi[] = "tahun = '$this->tahunAnggaran'";
		}


		if(!empty($filterKategori))$arrKondisi[] = $arrKondisi[] = "kategori ='$filterKategori'";
		if(!empty($filterNamaPekerjaan))$arrKondisi[] = "pekerjaan like '%$filterNamaPekerjaan%'";


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
	function windowShowBootstrap($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 1000;//800 default
	 $this->form_height = 550;//default 160
		$this->form_caption = 'Pilih Pekerjaan';



	 //items ----------------------
		$this->form_fields =
		"<div id='{$this->Prefix}_cont_title' style='position:relative' ></div>".
		"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>".

			//"<input type='hidden' id='".$this->Prefix."tahun_anggaran' name='".$this->Prefix."tahun_anggaran' value='$tahun_anggaran'>".
			"<input type='hidden' id='postKategori' name='postKategori' value='".$_REQUEST['postKategori']."'>".
		"</div>".
		"<div id=garis style='height:1;border-bottom:1px solid #E5E5E5;'></div>".
		"<div id=contain style='overflow:auto;height:$height;'>".
		//"<div id=contain style='overflow:auto;height:256;'>".
		"<div class='table-wrapper-scroll-y my-custom-scrollbar' id='{$this->Prefix}_cont_daftar' style='position:relative; height:350px;' >".
		"</div>
		</div>".
		"<div id='{$this->Prefix}_cont_hal' style='position:relative'>".
			"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
		"</div>";
		;
		//tombol
		$this->form_menubawah =
			"<input type='button' class='btn btn-success' style='width:200px' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan'>&nbsp&nbsp".
			"<input type='button' class='btn btn-success' style='width:200px' value='Batal' onclick ='".$this->Prefix.".windowClose(true)' >";

		$form = $this->genFormBootstrapFS();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function genFormBootstrap($withForm=TRUE, $params=NULL, $center=TRUE){
		$form_name = $this->Prefix.'_form';
		$content="
			<form name='popupPekerjaanForm' id='popupPekerjaanForm' method='post' action=''>
				<div class='modal-dialog modal-lg' style='max-width:1000px !important'>
						<div class='modal-content' style='width:$this->form_width;height:$this->form_height'>
								<div class='modal-header' style=' padding: 10px; border-bottom: 1px solid #dfe8f1;'>
										<h5 class='modal-title' style='margin-bottom:0;'  style='color:black;'>$this->form_caption</h5>
										<button type='button' class='close' type='button' data-dismiss='modal' aria-label='Close' onClick=$this->Prefix.windowClose();>
									          <span aria-hidden='true'>&times;</span>
									        </button>
								</div>
								<div class='modal-body' style='padding:12px 12px 12px;'>
									".$this->form_fields."
								</div>
								<!-- padding: 15px -->
							<!-- 		<div class='modal-footer' style=' ; text-align: right; border-top: 1px solid #dfe8f1;'>
										<input type='button' class='btn btn-success' value='hidden' title='hideen' style='  display: none;'>
										".
										$this->form_menubawah.
										"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
										<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
										."
								</div>
							-->
						</div>
				</div>
			</form>
		";
		return $content;
	}
	function genFormBootstrapFS($withForm=TRUE, $params=NULL, $center=TRUE){
		$form_name = "popupPekerjaanForm";
		$content="
		<form name='$form_name' id='$form_name' method='post' action=''>
			<div class='modal-dialog modal-lg' style='max-width:100% !important;width: 1024px;max-height: 100% !important;position: fixed;'>
					<div class='modal-content' style='width: 100%;height: 100%;position: fixed;overflow: auto; top:0'>
							<div class='modal-header' style='min-height: 56.428571px; padding: 15px; border-bottom: 1px solid #dfe8f1;'>
										<h5 class='modal-title' style='margin-bottom:0;'  style='color:black;'>$this->form_caption</h5>
										<button type='button' class='close' type='button' data-dismiss='modal' aria-label='Close' onClick=$this->Prefix.windowClose();>
									          <span aria-hidden='true'>&times;</span>
									        </button>
								</div>
								<div class='modal-body' style='padding:12px 12px 12px;'>
									".$this->form_fields."
								</div>
								<!-- padding: 15px -->
							<!-- 		<div class='modal-footer' style=' ; text-align: right; border-top: 1px solid #dfe8f1;'>
										<input type='button' class='btn btn-success' value='hidden' title='hideen' style='  display: none;'>
										".
										$this->form_menubawah.
										"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
										<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
										."
								</div>
							-->
						</div>
				</div>
			</form>
		";
		return $content;
	}

}
$popupPekerjaan = new popupPekerjaanObj();

?>
