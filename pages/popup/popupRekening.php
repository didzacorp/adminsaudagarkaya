<?php

class popupRekeningObj  extends configClass{
	var $Prefix = 'popupRekening';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_rekening'; //daftar
	var $TblName_Hapus = 'ref_rekening';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('kode_rekening_1','kode_rekening_2','kode_rekening_3','kode_rekening_4');
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
	var $FormName = 'popupRekeningForm';
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
			$getNamaRekening = $this->sqlArray($this->sqlQuery("select * from ref_rekening where concat(kode_rekening_1,'.',kode_rekening_2,'.',kode_rekening_3,'.',kode_rekening_4) ='$kodeRekening'"));

			$content = array(
				'kodeRekening' => $kodeRekening,
				'namaRekening' => $getNamaRekening['nama_rekening'],
				'kategoriPekerjaan' => $getNamaRekening['kode_rekening_2'],
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
			 "<script type='text/javascript' src='js/popup/popupRekening.js' language='JavaScript' ></script>".
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

	function genDaftarInitial($nm_account='', $height=''){
		$filterAkun = $_REQUEST['filterAkun'];
		$vOpsi = $this->genDaftarOpsi();
		return
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>".
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>".

				//"<input type='hidden' id='".$this->Prefix."tahun_anggaran' name='".$this->Prefix."tahun_anggaran' value='$tahun_anggaran'>".
				"<input type='hidden' id='postFilterK' name='postFilterK' value='".$_REQUEST['postFilterK']."'>".
				"<input type='hidden' id='postFilterL' name='postFilterL' value='".$_REQUEST['postFilterL']."'>".
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
			$hsl ="<input type='checkbox' name='popupRekening_toggle' id='popupRekening_toggle' value='' onclick=popupRekening.checkSemua($jumlahData,'popupRekening_cb','popupRekening_toggle','popupRekening_jmlcek')>";
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
	   	<th class='th01' align='center' width='100'>KODE REKENING</th>
	   	<th class='th01' align='center' width='10000'>NAMA REKENING</th>
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
		 $Koloms[] = array('align="center" ',"<span style='cursor:pointer;color:red;' onclick =$this->Prefix.windowSave('$kodeRekening')>$kodeRekening</span>");
		 $Koloms[] = array('align="left" ',$nama_rekening);

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
	 if(!empty($postFilterK)){
		 $filterBidang = $postFilterK;
		 $filterKodeRekeningKesatu=  $this->cmbQuery("filterBidang",$filterBidang,"select kode_rekening_1,nama_rekening from ref_rekening where kode_rekening_1 !='0' and kode_rekening_2 = '0'","onchange=$this->Prefix.refreshList(true); disabled class='form-control form-control-sm'","-- BIDANG --");
	 }else{
		 $filterKodeRekeningKesatu= $this->cmbQuery("filterBidang",$filterBidang,"select kode_rekening_1,nama_rekening from ref_rekening where kode_rekening_1 !='0' and kode_rekening_2 = '0'","onchange=$this->Prefix.refreshList(true); class='form-control form-control-sm' ","-- BIDANG --");
	 }

		 $filterKodeRekeningKedua = $this->cmbQuery("filterKelompok",$filterKelompok,"select kode_rekening_2,nama_rekening from ref_rekening where kode_rekening_1 ='$filterBidang' and kode_rekening_2 != '0' and kode_rekening_3 = '0'","onchange=$this->Prefix.refreshList(true);  class='form-control form-control-sm'","-- KELOMPOK --");


			$TampilOpt = "
				<div class='form-group'>
					<div class='row' style='margin-top:5px !important;'>
						<label class='col-sm-2 control-label' style='margin-top:6px;color: black;font-size:15px;'>BIDANG</label>
						<div class='col-sm-4'>
							$filterKodeRekeningKesatu
						</div>
						<label class='col-sm-1 control-label' style='margin-top:6px;color: black;font-size:15px;'>JENIS</label>
						<div class='col-sm-4'>
							".
							$this->cmbQuery("filterJenis",$filterJenis,"select kode_rekening_3,nama_rekening from ref_rekening where kode_rekening_1 ='$filterBidang' and kode_rekening_2 = '$filterKelompok' and kode_rekening_3 != '0' and kode_rekening_4 = '00'","onchange=$this->Prefix.refreshList(true); class='form-control form-control-sm'","-- JENIS --")
							."
						</div>
					</div>

					<div class='row' style='margin-top:5px !important;'>
						<label class='col-sm-2 control-label' style='margin-top:6px;color: black;font-size:15px;'>KELOMPOK</label>
						<div class='col-sm-4'>
							$filterKodeRekeningKedua
						</div>

						<label class='col-sm-1 control-label' style='margin-top:6px;color: black;font-size:15px;'>OBJEK</label>
						<div class='col-sm-4'>
							".
							$this->cmbQuery("filterObjek",$filterObjek,"select kode_rekening_4,nama_rekening from ref_rekening where kode_rekening_1 ='$filterBidang' and kode_rekening_2 = '$filterKelompok' and kode_rekening_3 = '$filterJenis' and kode_rekening_4 != '00'","onchange=$this->Prefix.refreshList(true); class='form-control form-control-sm'","-- OBJEK --")
							."
						</div>
					</div>

					<div class='row' style='margin-top:5px !important;'>
						<label class='col-sm-2 control-label' style='margin-top:6px;color: black;font-size:15px;'>NAMA REKENING</label>
						<div class='col-sm-4'>
							<input type='text' name ='filterNamaRekening' id = 'filterNamaRekening' value ='".$_REQUEST['filterNamaRekening']."' class='form-control form-control-sm'>
						</div>

						<div class='col-sm-1'>
						<input type='hidden' id='postFilterK' name='postFilterK' value='$postFilterK'>
						<input type='hidden' id='postFilterL' name='postFilterL' value='$postFilterL'>
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
		$arrKondisi[] = "kode_rekening_4 != '00'";
		// $arrKondisi[] = "kode_rekening_4 != '0'";
		if(!empty($postFilterK))$filterBidang = $postFilterK;
		if(!empty($postFilterL) && $postFilterL !='undefined')$filterKelompok = $postFilterL;
		if(!empty($filterBidang)){
			$arrKondisi[] = "kode_rekening_1 = '$filterBidang'";
			if(!empty($filterKelompok)){
				$arrKondisi[] = "kode_rekening_2 = '$filterKelompok'";
				if(!empty($filterJenis)){
					$arrKondisi[] = "kode_rekening_3 = '$filterJenis'";
					if(!empty($filterObjek))$arrKondisi[] = "kode_rekening_4 = '$filterObjek'";
				}
			}
		}
		if(!empty($filterNamaRekening))$arrKondisi[] = "nama_rekening like '%$filterNamaRekening%'";


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
		$this->form_caption = 'Pilih Rekening';



	 //items ----------------------
		$this->form_fields =
		"<div id='{$this->Prefix}_cont_title' style='position:relative' ></div>".
		"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>".

			//"<input type='hidden' id='".$this->Prefix."tahun_anggaran' name='".$this->Prefix."tahun_anggaran' value='$tahun_anggaran'>".
			"<input type='hidden' id='postFilterK' name='postFilterK' value='".$_REQUEST['postFilterK']."'>".
			"<input type='hidden' id='postFilterL' name='postFilterL' value='".$_REQUEST['postFilterL']."'>".
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
			<form name='popupRekeningForm' id='popupRekeningForm' method='post' action=''>
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
		$form_name = "popupRekeningForm";
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
$popupRekening = new popupRekeningObj();

?>
