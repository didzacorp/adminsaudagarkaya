<?php

class refRekeningObj  extends configClass{
	var $Prefix = 'refRekening';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_rekening'; //bonus
	var $TblName_Hapus = 'ref_rekening';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'refRekening';
	var $PageIcon = 'images/administrasi_ico.png';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='refRekening.xls';
	var $namaModulCetak='refRekening';
	var $Cetak_Judul = 'refRekening';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'refRekeningForm';
	var $noModul=14;
	var $TampilFilterColapse = 0; //0

	function setTitle(){
		return 'REFERENSI REKENING';
	}
	function filterSaldoMiring(){
		return "";
	}
	function setMenuEdit(){
		return "
						<li class='nav-item' style='margin-right: 10px;margin-left: 10px;'>
	    				<a class='toolbar' id='' href='javascript:$this->Prefix.Baru()' title='Baru'>
	    					<img src='images/administrator/images/sections.png' alt='button' name='save' width='22' height='22' border='0' align='middle'>
	    					Baru
	    				</a>
            </li>
						<li class='nav-item' style='margin-right: 10px;margin-left: 10px;'>
	    				<a class='toolbar' id='' href='javascript:$this->Prefix.Edit()' title='Edit'>
	    					<img src='images/administrator/images/edit_f2.png' alt='button' name='save' width='22' height='22' border='0' align='middle'>
	    					Edit
	    				</a>
            </li>
						<li class='nav-item' style='margin-right: 10px;margin-left: 10px;'>
	    				<a class='toolbar' id='' href='javascript:$this->Prefix.Hapus()' title='Hapus'>
	    					<img src='images/administrator/images/delete_f2.png' alt='button' name='save' width='22' height='22' border='0' align='middle'>
	    					Hapus
	    				</a>
            </li>


						";
	}
	function setMenuView(){
	return "";

}
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 foreach ($_REQUEST as $key => $value) {
			 $$key = $value;
		 }
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];

	 if(empty($nama)){
		 	$err  ="Isi Nama Kas";
	 }

			if($fmST == 0){
				if($err==''){
							$dataInsert = array(
													'kode_rekening_1' => $kodeRekening1,
													'kode_rekening_2' => $kodeRekening2,
													'kode_rekening_3' => $kodeRekening3,
													'kode_rekening_4' => genNumber($kodeRekening4),
													'nama_rekening' => $nama,
							);
							$queryInsert = sqlInsert('ref_rekening',$dataInsert);
							$this->sqlQuery($queryInsert);
							$cek = $queryInsert;
				}
			}else{
				if($err==''){
					$dataUpdate = array(
													'nama_rekening' => $nama,
					);
					$queryUpdate = sqlUpdate('ref_rekening',$dataUpdate,"id = '".$idplh."'");
					$this->sqlQuery($queryUpdate);
					$cek = $queryInsert;
				}
			}

			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
    }

	function set_selector_other2($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;

	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}

	function set_selector_other($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;

	  switch($tipe){

		case 'formBaru':{
			$fm = $this->setFormBaru();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'saveBaruRekening2':{
			foreach ($_REQUEST as $key => $value) {
	 			 $$key = $value;
	 		}
				if(empty($nama)){
					$err = "Isi nama";
				}else{
					$data = array(
													'kode_rekening_1' => $kodeRekening1,
													'kode_rekening_2' => $kodeRekening2New,
													'kode_rekening_3' => '0',
													'kode_rekening_4' => '00',
													'nama_rekening' => $nama,
												);
					$query = sqlInsert("ref_rekening",$data);
					$this->sqlQuery($query);
					$cek = $query;
				}
				$content = array(
													"kodeRekening2" => cmbQuery('kodeRekening2',$kodeRekening2New,"select kode_rekening_2,concat(kode_rekening_2,'. ',nama_rekening) from ref_rekening where kode_rekening_1 ='$kodeRekening1' and kode_rekening_2 !='0' and kode_rekening_3 = '0' and kode_rekening_4 = '00'",'style="class="form-control form-control-sm" onchange="'.$this->Prefix.'.kodeRekening2Changed()"','--- Pilih Kode Rekening ---'),
													"kodeRekening3" => cmbQuery('kodeRekening3',$kodeRekening3,"select kode_rekening_3,concat(kode_rekening_3,'. ',nama_rekening) from ref_rekening where kode_rekening_1 ='$kodeRekening1' and kode_rekening_2 ='$kodeRekening2New' and kode_rekening_3 != '0' and kode_rekening_4 = '00'",'style="class="form-control form-control-sm" onchange="'.$this->Prefix.'.kodeRekening3Changed()"','--- Pilih Kode Rekening ---'),
													"kodeRekening4" => $comboKodeRekening4,
												);
		break;
		}
		case 'saveEdit':{
			foreach ($_REQUEST as $key => $value) {
	 			 $$key = $value;
	 		}
				$dataUpdate = array(
												'nama_rekening' => $nama,
				);
				$queryUpdate = sqlUpdate('ref_rekening',$dataUpdate,"id = '".$idplh."'");
				$this->sqlQuery($queryUpdate);
				$cek = $queryUpdate;
		break;
		}
		case 'saveBaruRekening3':{
			foreach ($_REQUEST as $key => $value) {
	 			 $$key = $value;
	 		}
				if(empty($nama)){
					$err = "Isi nama";
				}else{
					$data = array(
													'kode_rekening_1' => $kodeRekening1,
													'kode_rekening_2' => $kodeRekening2,
													'kode_rekening_3' => $kodeRekening3New,
													'kode_rekening_4' => '00',
													'nama_rekening' => $nama,
												);
					$query = sqlInsert("ref_rekening",$data);
					$this->sqlQuery($query);
					$cek = $query;
				}
				$content = array(

													"kodeRekening3" => cmbQuery('kodeRekening3',$kodeRekening3New,"select kode_rekening_3,concat(kode_rekening_3,'. ',nama_rekening) from ref_rekening where kode_rekening_1 ='$kodeRekening1' and kode_rekening_2 ='$kodeRekening2' and kode_rekening_3 != '0' and kode_rekening_4 = '00'",'style="class="form-control form-control-sm" onchange="'.$this->Prefix.'.kodeRekening3Changed()"','--- Pilih Kode Rekening ---'),
													"kodeRekening4" => $comboKodeRekening4,
												);
		break;
		}
		case 'kodeRekening1Changed':{
			foreach ($_REQUEST as $key => $value) {
	 			 $$key = $value;
	 		}
				$content = array(
													"kodeRekening2" => cmbQuery('kodeRekening2',$kodeRekening2,"select kode_rekening_2,concat(kode_rekening_2,'. ',nama_rekening) from ref_rekening where kode_rekening_1 ='$kodeRekening1' and kode_rekening_2 !='0' and kode_rekening_3 = '0' and kode_rekening_4 = '00'",'style="class="form-control form-control-sm" onchange="'.$this->Prefix.'.kodeRekening2Changed()"','--- Pilih Kode Rekening ---'),
													"kodeRekening3" => cmbQuery('kodeRekening3',$kodeRekening3,"select kode_rekening_3,concat(kode_rekening_3,'. ',nama_rekening) from ref_rekening where kode_rekening_1 ='$kodeRekening1' and kode_rekening_2 ='$kodeRekening2' and kode_rekening_3 != '0' and kode_rekening_4 = '00'",'style="class="form-control form-control-sm" onchange="'.$this->Prefix.'.kodeRekening3Changed()"','--- Pilih Kode Rekening ---'),
													"kodeRekening4" => $comboKodeRekening4,

												);
		break;
		}
		case 'kodeRekening2Changed':{
			foreach ($_REQUEST as $key => $value) {
	 			 $$key = $value;
	 		}
				$content = array(
													"kodeRekening3" => cmbQuery('kodeRekening3',$kodeRekening3,"select kode_rekening_3,concat(kode_rekening_3,'. ',nama_rekening) from ref_rekening where kode_rekening_1 ='$kodeRekening1' and kode_rekening_2 ='$kodeRekening2' and kode_rekening_3 != '0' and kode_rekening_4 = '00'",'style="class="form-control form-control-sm" onchange="'.$this->Prefix.'.kodeRekening3Changed()"','--- Pilih Kode Rekening ---'),
													"kodeRekening4" => $comboKodeRekening4,
												);
		break;
		}
		case 'kodeRekening3Changed':{
			foreach ($_REQUEST as $key => $value) {
	 			 $$key = $value;
	 		}
				$getMaxKodeRekening4 = $this->sqlArray($this->sqlQuery("select max(kode_rekening_4) from ref_rekening where kode_rekening_1 = '$kodeRekening1' and kode_rekening_2 = '$kodeRekening2' and kode_rekening_3='$kodeRekening3'"));
				$cek = "select max(kode_rekening_4) from ref_rekening where kode_rekening_1 = '$kodeRekening1' and kode_rekening_2 = '$kodeRekening2' and kode_rekening_3='$kodeRekening3'";

				$content = array(
													"kodeRekening4" => genNumber($getMaxKodeRekening4['max(kode_rekening_4)'] + 1),
												);
		break;
		}

		case 'baruKodeRekening2':{
				$fm = $this->baruKodeRekening2();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
			}
		case 'baruKodeRekening3':{
				$fm = $this->baruKodeRekening3();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
			}
		case 'formEdit':{
			$fm = $this->setFormEdit();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
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
			"<script type='text/javascript' src='js/refRekening/refRekening.js' language='JavaScript' ></script>

			<link rel='stylesheet' type='text/css' href='css/modal.css'>
			<script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
			".$this->loadCalendarBootstrap()."
			".$this->loadCSSBootstrap()."


			</style>
".

			"<script type='text/javascript' src='ckeditor/ckeditor.js' language='JavaScript' ></script>


".
			$scriptload;
	}

	function genFormKB($withForm=TRUE, $params=NULL, $center=TRUE){
		$form_name = $this->Prefix.'_KBform';

		$content="
			<form name='$form_name' id='$form_name' method='post' action=''>
				<div class='modal-dialog modal-lg'>
						<div class='modal-content' style='width:$this->form_width;height:$this->form_height'>
								<div class='modal-header' style='min-height: 56.428571px; padding: 15px; border-bottom: 1px solid #dfe8f1;'>
										<h4 class='modal-title' style='margin-bottom:0;'  style='color:black;'>$this->form_caption</h4>
								</div>
								<div class='modal-body' style='padding:12px 12px 12px;'>
									".$this->setForm_contentBS()."
								</div>
								<!-- padding: 15px -->
								<div class='modal-footer' style=' ; text-align: right; border-top: 1px solid #dfe8f1;'>
										<input type='button' class='btn btn-success' value='hidden' title='hideen' style='  display: none;'>
										".
										$this->form_menubawah.
										"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
										<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
										."
								</div>
						</div>
				</div>
			</form>
		";
		return $content;
	}

	function baruKodeRekening2(){
	 global $SensusTmp, $Main;
	 $REK_DIGIT_O=$Main->REK_DIGIT_O;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 650;
	 $this->form_height = 220;

		$this->form_caption = 'Baru Kode Kelompok';
		foreach ($_REQUEST as $key => $value) {
			 $$key = $value;
		}
		$getNamaKodeRekening1 = $this->sqlArray($this->sqlQuery("select * from ref_rekening where kode_rekening_1 = '$kodeRekening1'"));
		$namaRekening = $kodeRekening1.". ".$getNamaKodeRekening1['nama_rekening'];
		$getMaxKodeRekening2 = $this->sqlArray($this->sqlQuery("select max(kode_rekening_2) from ref_rekening where kode_rekening_1 ='$kodeRekening1'"));
		$maxKodeRekening2 = $getMaxKodeRekening2['max(kode_rekening_2)'] + 1;
	 //items ----------------------
	  $this->form_fields = array(
			'akun' => array(
						 'label'=>'KODE AKUN',
						 'labelWidth'=>3,
						 'contentWidth'=>9,
						 'value'=>
							 "
							 <input type='text' value='".$namaRekening."' class='form-control form-control-sm' readonly>
 								<input type ='hidden' name='kodeRekening1' id='kodeRekening1' value='".$kodeRekening1."'>
							 "
							),
			'Kelompok' => array(
						 'label'=>'KODE KELOMPOK',
						 'labelWidth'=>3,
						 'contentWidth'=>9,
						 'type' => "manual",
						 'value'=>
							 "
							 <div class='col-sm-2'>
								 <input type='text' name='kodeRekening2New' id='kodeRekening2New' class='form-control form-control-sm' value='".$maxKodeRekening2."'  readonly>
							 </div>
							 <div class='col-sm-7'>
								 <input type='text' name='nama' id='nama' value='".$nama."'  class='form-control form-control-sm' placeholder='Nama Kode Kelompok'>
							 </div>
							 "
							),

			);
		//tombol
		$this->form_menubawah =
		"<input type='button' class='btn btn-primary btn-sm' style='color:#fff;background-color: #007bff;border-color:#007bff' value='Simpan' onclick ='".$this->Prefix.".saveBaruRekening2()' title='Simpan'>&nbsp&nbsp".
		"<input type='button' class='btn btn-danger btn-sm' style='background-color: #dc3545; border-color: #dc3545' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function baruKodeRekening3(){
	 global $SensusTmp, $Main;
	 $REK_DIGIT_O=$Main->REK_DIGIT_O;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 650;
	 $this->form_height = 220;

		$this->form_caption = 'Baru Kode Kelompok';
		foreach ($_REQUEST as $key => $value) {
			 $$key = $value;
		}
		$getNamaKodeRekening2 = $this->sqlArray($this->sqlQuery("select * from ref_rekening where kode_rekening_1='$kodeRekening1' and kode_rekening_2 = '$kodeRekening2'"));
		$namaRekening = $kodeRekening2.". ".$getNamaKodeRekening2['nama_rekening'];
		$getMaxKodeRekening3 = $this->sqlArray($this->sqlQuery("select max(kode_rekening_3) from ref_rekening where kode_rekening_1='$kodeRekening1' and kode_rekening_2 ='$kodeRekening2'"));
		$maxKodeRekening3 = $getMaxKodeRekening3['max(kode_rekening_3)'] + 1;
	 //items ----------------------

			$this->form_fields = array(
			 'akun' => array(
							'label'=>'KODE AKUN',
							'labelWidth'=>3,
							'contentWidth'=>9,
							'value'=>
								"
								<input type='text' value='".$namaRekening."' class='form-control form-control-sm' readonly>
									 <input type ='hidden' name='kodeRekening2' id='kodeRekening2' value='".$kodeRekening2."'>
								"
							 ),
			 'Kelompok' => array(
							'label'=>'KODE JENIS',
							'labelWidth'=>3,
							'contentWidth'=>9,
							'type' => "manual",
							'value'=>
								"
								<div class='col-sm-2'>
									<input type='text' name='kodeRekening3New' id='kodeRekening3New' class='form-control form-control-sm' value='".$maxKodeRekening3."'  readonly>
								</div>
								<div class='col-sm-7'>
									<input type='text' name='nama' id='nama' value='".$nama."'  class='form-control form-control-sm' placeholder='Nama Kode Kelompok'>
								</div>
								"
							 ),

			 );
		//tombol
		$this->form_menubawah =
		"<input type='button' class='btn btn-primary btn-sm' style='color:#fff;background-color: #007bff;border-color:#007bff' value='Simpan' onclick ='".$this->Prefix.".saveBaruRekening3()' title='Simpan'>&nbsp&nbsp".
		"<input type='button' class='btn btn-danger btn-sm' style='background-color: #dc3545; border-color: #dc3545' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	//form ==================================
	function setFormBaru(){
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

  	function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		global $SensusTmp, $Main;
 	 $REK_DIGIT_O=$Main->REK_DIGIT_O;

 	 $cek = ''; $err=''; $content='';
 	 $json = TRUE;	//$ErrMsg = 'tes';
 	 $form_name = $this->Prefix.'_formKB';
 	 $this->form_width = 650;
 	 $this->form_height = 200;

 		$this->form_caption = 'Baru Kode Kelompok';
 		foreach ($_REQUEST as $key => $value) {
 			 $$key = $value;
 		}
		$getNamaRekening = $this->sqlArray($this->sqlQuery("select * from ref_rekening where id = '$this->form_idplh'"));
 	 //items ----------------------
 	  $this->form_fields = array(

			'akun' => array(
						 'label'=>'KODE AKUN',
						 'labelWidth'=>3,
						 'contentWidth'=>9,
						 'value'=>
							 "
							 <input type='text' name='nama' id='nama' value='".$getNamaRekening['nama_rekening']."' class='form-control form-control-sm' placeholder='Nama Rekening' >
							 "
							),



 			);
 		//tombol
 		$this->form_menubawah =
		"<input type='button' class='btn btn-primary btn-sm' style='color:#fff;background-color: #007bff;border-color:#007bff' value='Simpan' onclick ='".$this->Prefix.".saveEdit($this->form_idplh)'  title='Simpan'>&nbsp&nbsp".
		"<input type='button' class='btn btn-danger btn-sm' style='background-color: #dc3545; border-color: #dc3545' value='Batal' onclick ='".$this->Prefix.".Close()' >";

 		$form = $this->genFormBootstrap();
 		$content = $form;
 		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function setForm($dt){
	 global $SensusTmp ,$Main;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	$this->form_width = 750;
	 $this->form_height = 300;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'FORM BARU KODE REKENING';
	//	$nip	 = '';
	  }/*else{
		$this->form_caption = 'Edit';
		$readonly='readonly';

	  }*/
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = $this->sqlQuery($query);

		$fmKA = $_REQUEST['fmka'];
		$fmKB = $_REQUEST['fmkb'];
		$fmKC = $_REQUEST['fmkc'];
		$fmKD = $_REQUEST['fmkd'];
		$fmKE = $_REQUEST['fmke'];

	 //items ----------------------
	  // $this->form_fields = array(
		//
		// 	'kode_Akun' => array(
		// 				'label'=>'KODE REKENING',
		// 				'labelWidth'=>150,
		// 				'value'=>
		// 				cmbQuery('kodeRekening1',$kodeRekening1,"select kode_rekening_1,concat(kode_rekening_1,'. ',nama_rekening) from ref_rekening where kode_rekening_1 !='0' and kode_rekening_2 ='0' and kode_rekening_3 = '0' and kode_rekening_4 = '00'",'style="class="form-control form-control-sm" onchange="'.$this->Prefix.'.kodeRekening1Changed()"','--- Pilih Kode Rekening ---'),
		// 				 ),
		//
		// 	'kode_kelompok' => array(
		// 				'label'=>'KODE KELOMPOK',
		// 				'labelWidth'=>100,
		// 				'value'=>
		// 				cmbQuery('kodeRekening2',$kodeRekening2,"select kode_rekening_2,concat(kode_rekening_2,'. ',nama_rekening) from ref_rekening where kode_rekening_1 ='$kodeRekening1' and kode_rekening_2 !='0' and kode_rekening_3 = '0' and kode_rekening_4 = '00'",'style="class="form-control form-control-sm" onchange="'.$this->Prefix.'.kodeRekening2Changed()"','--- Pilih Kode Rekening ---')." &nbsp <input type='button' value='Baru' onclick ='".$this->Prefix.".baruKodeRekening2()' title='Kode Kelompok' >"
		// 			),
		//
		// 	'kode_Jenis' => array(
		// 				'label'=>'KODE JENIS',
		// 				'labelWidth'=>100,
		// 				'value'=>
		// 				cmbQuery('kodeRekening3',$kodeRekening3,"select kode_rekening_3,concat(kode_rekening_3,'. ',nama_rekening) from ref_rekening where kode_rekening_1 ='$kodeRekening1' and kode_rekening_2 ='$kodeRekening2' and kode_rekening_3 != '0' and kode_rekening_4 = '00'",'style="class="form-control form-control-sm" onchange="'.$this->Prefix.'.kodeRekening3Changed()"','--- Pilih Kode Rekening ---')." &nbsp <input type='button' value='Baru' onclick ='".$this->Prefix.".baruKodeRekening3()' title='Kode Kelompok' >"
		// 				 ),
		// 	'Kode_Rincian_Objek' => array(
		// 				'label'=>'KODE RINCIAN OBJEK',
		// 				'labelWidth'=>100,
		// 				'value'=>"<div style='float:left;'>
		// 				<input type='text' name='kodeRekening4' id='kodeRekening4' value='".$kodeRekening4."' style='width:50px;' readonly>
		// 				<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode Rincian Objek' style='width:450px;'>
		// 				</div>",
		// 				 ),
		// 	);

		$this->form_fields = array(

			 'kode_Akun' => array(
							'label'=>'KODE REKENING',
							'labelWidth'=>3,
							'contentWidth'=>7,
							'value'=>cmbQuery('kodeRekening1',$kodeRekening1,"select kode_rekening_1,concat(kode_rekening_1,'. ',nama_rekening) from ref_rekening where kode_rekening_1 !='0' and kode_rekening_2 ='0' and kode_rekening_3 = '0' and kode_rekening_4 = '00'",'class="form-control form-control-sm" onchange="'.$this->Prefix.'.kodeRekening1Changed()"','--- Pilih Kode Rekening --- '),
							 ),
			 'kodeKelompok' => array(
							'label'=>'KODE KELOMPOK',
							'labelWidth'=>3,
							'contentWidth'=>9,
							'type'=> 'manual',
							'value'=>
								"
								<div class='col-sm-7'>
									".cmbQuery('kodeRekening2',$kodeRekening2,"select kode_rekening_2,concat(kode_rekening_2,'. ',nama_rekening) from ref_rekening where kode_rekening_1 ='$kodeRekening1' and kode_rekening_2 !='0' and kode_rekening_3 = '0' and kode_rekening_4 = '00'",' class="form-control form-control-sm" onchange="'.$this->Prefix.'.kodeRekening2Changed()"','--- Pilih Kode Rekening ---')."
								</div>

								<div class='col-sm-1'>
									<input type='button' class='btn btn-info btn-sm'  value='Baru' onclick=$this->Prefix.baruKodeRekening2(); style='margin-top: 1px;margin-top: 1px;background-color: #484e48;'>
								</div>
								"
							 ),
			 'kode_Jenis' => array(
							'label'=>'KODE JENIS',
							'labelWidth'=>3,
							'contentWidth'=>9,
							'type'=> 'manual',
							'value'=>
							"
							<div class='col-sm-7'>
								".cmbQuery('kodeRekening3',$kodeRekening3,"select kode_rekening_3,concat(kode_rekening_3,'. ',nama_rekening) from ref_rekening where kode_rekening_1 ='$kodeRekening1' and kode_rekening_2 ='$kodeRekening2' and kode_rekening_3 != '0' and kode_rekening_4 = '00'",'class="form-control form-control-sm" onchange="'.$this->Prefix.'.kodeRekening3Changed()"','--- Pilih Kode Rekening ---')."
							</div>

							<div class='col-sm-1'>
								<input type='button' class='btn btn-info btn-sm'  value='Baru' onclick=$this->Prefix.baruKodeRekening3(); style='margin-top: 1px;margin-top: 1px;background-color: #484e48;'>
							</div>
							"

							 ),
			 'Kode_Rincian_Objek' => array(
							'label'=>'KODE RINCIAN OBJEK',
							'labelWidth'=>3,
							'contentWidth'=>9,
							'type'=> 'manual',
							'value'=>
								"
								<div class='col-sm-2'>
									<input type='text' name='kodeRekening4' id='kodeRekening4' class='form-control form-control-sm' value='".$kodeRekening4."'  readonly>
								</div>
								<div class='col-sm-7'>
									<input type='text' name='nama' id='nama' value='".$nama."'  class='form-control form-control-sm' placeholder='Nama Kode Rincian Objek'>
								</div>
								"
							 ),

			);



		$this->form_menubawah =

		"<input type='button' class='btn btn-primary btn-sm' style='color:#fff;background-color: #007bff;border-color:#007bff' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan'>&nbsp&nbsp".
		"<input type='button' class='btn btn-danger btn-sm' style='background-color: #dc3545; border-color: #dc3545' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genFormBootstrap();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function baseToImage($base64_string, $output_file) {

	    $ifp = fopen( $output_file, 'wb' );
	    $data = explode( ',', $base64_string );

	    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

	    fclose( $ifp );

	    return $output_file;
	}




	function setPage_HeaderOther(){
	return
			"";
	}

	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
		"<thead>
		 <tr>
			 <th class='th01' width='5' style='text-align:center;vertical-align:middle;' >No.</th>
			 $Checkbox
			 <th class='th02'  colspan='4' style='text-align:center;vertical-align:middle;width:5%;' >KODE REKENING</th>
			 <th class='th01'  style='text-align:center;vertical-align:middle;width:90%;' >NAMA REKENING</th>
		 </tr>


		 </thead>";

		return $headerTable;
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 foreach ($isi as $key => $value) {
			 $$key = $value;
		 }
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
		if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 // $Koloms[] = array('align="center"',"<span style='color:red;cursor:pointer;' onclick=$this->Prefix.detailOrder($id)>$id</span> ");
	 $Koloms[] = array('align="center"',$kode_rekening_1);
	 $Koloms[] = array('align="center"',$kode_rekening_2);
	 $Koloms[] = array('align="center"',$kode_rekening_3);
	 $Koloms[] = array('align="center"',$kode_rekening_4);
	 $Koloms[] = array('align="left"',$nama_rekening);
	 return $Koloms;
	}


	function genDaftarOpsi(){
	 global $Ref, $Main;
	 foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}
		if(empty($jumlahData))$jumlahData =50;
		$comboKodeRekening1 = cmbQuery('filterKodeRekening1',$filterKodeRekening1,"select kode_rekening_1,concat(kode_rekening_1,'. ',nama_rekening) from ref_rekening where kode_rekening_1 !='0' and kode_rekening_2 ='0' and kode_rekening_3 = '0' and kode_rekening_4 = '00'",'class="form-control form-control-sm" onchange="'.$this->Prefix.'.refreshList()"','--- Pilih Kode Rekening ---');
		$comboKodeRekening2 = cmbQuery('filterKodeRekening2',$filterKodeRekening2,"select kode_rekening_2,concat(kode_rekening_2,'. ',nama_rekening) from ref_rekening where kode_rekening_1 ='$filterKodeRekening1' and kode_rekening_2 !='0' and kode_rekening_3 = '0' and kode_rekening_4 = '00'",'class="form-control form-control-sm" onchange="'.$this->Prefix.'.refreshList()"','--- Pilih Kode Rekening ---');
		$comboKodeRekening3 = cmbQuery('filterKodeRekening3',$filterKodeRekening3,"select kode_rekening_3,concat(kode_rekening_3,'. ',nama_rekening) from ref_rekening where kode_rekening_1 ='$filterKodeRekening1' and kode_rekening_2 ='$filterKodeRekening2' and kode_rekening_3 != '0' and kode_rekening_4 = '00'",'class="form-control form-control-sm" onchange="'.$this->Prefix.'.refreshList()"','--- Pilih Kode Rekening ---');
		$comboKodeRekening4 = cmbQuery('filterKodeRekening4',$filterKodeRekening4,"select kode_rekening_4,concat(kode_rekening_4,'. ',nama_rekening) from ref_rekening where kode_rekening_1 ='$filterKodeRekening1' and kode_rekening_2 ='$filterKodeRekening2' and kode_rekening_3 = '$filterKodeRekening3' and kode_rekening_4 != '00'",'class="form-control form-control-sm" onchange="'.$this->Prefix.'.refreshList()"','--- Pilih Kode Rekening ---');




				$TampilOpt = "
					<div class='form-group'>
						<div class='row' style='margin-top:5px !important;'>
							<label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>KODE REKENING</label>
							<div class='col-sm-3'>
								$comboKodeRekening1
							</div>
						</div>
						<div class='row' style='margin-top:5px !important;'>
							<label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>KODE KELOMPOK</label>
							<div class='col-sm-3'>
								$comboKodeRekening2
							</div>
						</div>
						<div class='row' style='margin-top:5px !important;'>
							<label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>KODE JENIS</label>
							<div class='col-sm-3'>
								$comboKodeRekening3
							</div>
						</div>
						<div class='row' style='margin-top:5px !important;'>
							<label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>KODE RINCIAN OBJEK</label>
							<div class='col-sm-3'>
								$comboKodeRekening4
							</div>
						</div>
						<div class='row' style='margin-top:5px !important;'>
							<label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>NAMA REKENING</label>
							<div class='col-sm-3'>
								<input type='text' class='form-control form-control-sm' name='filterNamaRekening' id ='filterNamaRekening' style='width:400px;' value='$filterNamaRekening'>
							</div>
						</div>


						<div class='row' style='margin-top:5px !important;'>
							<label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>JUMLAH DATA</label>
							<div class='col-sm-1'>
									<input type='text' class='form-control form-control-sm'  name='jumlahData' id ='jumlahData' style='width:70px;' value='$jumlahData' >
							</div>
							<div class='col-sm-1'>
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
		//kondisi -----------------------------------
		foreach ($_REQUEST as $key => $value) {
 			$$key = $value;
 		}
		$arrKondisi = array();
		if(!empty($filterKodeRekening1)){
				$arrKondisi[] = "kode_rekening_1 = '$filterKodeRekening1'";
		}
		if(!empty($filterKodeRekening2)){
				$arrKondisi[] = "kode_rekening_2 = '$filterKodeRekening2'";
		}
		if(!empty($filterKodeRekening3)){
				$arrKondisi[] = "kode_rekening_3 = '$filterKodeRekening3'";
		}
		if(!empty($filterKodeRekening4)){
				$arrKondisi[] = "kode_rekening_4 = '$filterKodeRekening4'";
		}
		if(!empty($filterNamaRekening)){
				$arrKondisi[] = "nama_rekening like '%$filterNamaRekening%'";
		}
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
		// switch($filterUrut){
		// 	case '1': $arrOrders[] = " type_refRekening $Asc1 " ;break;
		// 	case '2': $arrOrders[] = " username $Asc1 " ;break;
		// 	case '3': $arrOrders[] = " nama $Asc1 " ;break;
		// 	case '4': $arrOrders[] = " saldo $Asc1 " ;break;
		// }
		$Order= join(',',$arrOrders);
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//$Order ="";
		//limit --------------------------------------
		/**$HalDefault=cekPOST($this->Prefix.'_hal',1);	//Cat:Settingan Lama
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;
		**/
		if(empty($jumlahData))$jumlahData=50;
		$this->pagePerHal = $jumlahData;
		$Main->PagePerHal = $jumlahData;
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal;
		$HalDefault=cekPOST($this->Prefix.'_hal',1);
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal;
		$Limit = $Mode == 3 ? '': $Limit;
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);

	}

	function sendMailrefRekening($idrefRekening){
			$getDatarefRekening = $this->sqlArray($this->sqlQuery("select * from refRekening where id = '$idrefRekening'"));
			$namarefRekening = $getDatarefRekening['nama'];
			$isiEmail = "Selamat, status keanggotaan anda di ceukokom.com telah menjadi PREMIUM RESELLER

						";
			$arrayData = array(
									'emailTujuan' => $getDatarefRekening['email'],
									'subject' => "Selamat $namarefRekening",
									'isiEmail' => $isiEmail,
			);
			$curl = curl_init();
			curl_setopt($curl,CURLOPT_URL, "http://admin.ceukokom.com/pages/mailgun/mail.php");
			curl_setopt($curl,CURLOPT_POST, sizeof($arrayData));
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36");
			curl_setopt($curl,CURLOPT_POSTFIELDS, $arrayData);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($curl);
	}
	function mailBroadcast($idrefRekening,$subjectEmail,$isiEmail){
			$getDatarefRekening = $this->sqlArray($this->sqlQuery("select * from refRekening where id = '$idrefRekening'"));
			$namarefRekening = $getDatarefRekening['nama'];
			$arrayData = array(
									'emailTujuan' => $getDatarefRekening['email'],
									'subject' =>  $subjectEmail,
									'isiEmail' => $isiEmail,
			);
			$curl = curl_init();
			curl_setopt($curl,CURLOPT_URL, "http://admin.ceukokom.com/pages/mailgun/mail.php");
			curl_setopt($curl,CURLOPT_POST, sizeof($arrayData));
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36");
			curl_setopt($curl,CURLOPT_POSTFIELDS, $arrayData);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($curl);
	}
	function sendMailUpline($idrefRekening){
			$getDatarefRekening = $this->sqlArray($this->sqlQuery("select * from refRekening where id = '$idrefRekening'"));
			$namarefRekening = $getDatarefRekening['nama'];
			$isiEmail = "Selamat, komisi anda bertambah Rp ".number_format("40000",2,',','.')." dari pendaftaran RESELLER PREMIUM
						";
			$arrayData = array(
									'emailTujuan' => $getDatarefRekening['email'],
									'subject' => "Hai $namarefRekening",
									'isiEmail' => $isiEmail,
			);
			$curl = curl_init();
			curl_setopt($curl,CURLOPT_URL, "http://admin.ceukokom.com/pages/mailgun/mail.php");
			curl_setopt($curl,CURLOPT_POST, sizeof($arrayData));
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36");
			curl_setopt($curl,CURLOPT_POSTFIELDS, $arrayData);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($curl);
	}


	function sendMaillPembayaranKomisi($idrefRekening,$jumlahBayar){
			$getDatarefRekening = $this->sqlArray($this->sqlQuery("select * from refRekening where id = '$idrefRekening'"));
			$namarefRekening = $getDatarefRekening['nama'];
			$isiEmail = "Selamat, pembayaran komisi sebesar Rp ".number_format($jumlahBayar,2,',','.')." pada ".$this->titimangsa(date("Y-m-d"))." berhasil di lakukan
						";
			$arrayData = array(
									'emailTujuan' => $getDatarefRekening['email'],
									'subject' => "Hai $namarefRekening",
									'isiEmail' => $isiEmail,
			);
			$curl = curl_init();
			curl_setopt($curl,CURLOPT_URL, "http://admin.ceukokom.com/pages/mailgun/mail.php");
			curl_setopt($curl,CURLOPT_POST, sizeof($arrayData));
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36");
			curl_setopt($curl,CURLOPT_POSTFIELDS, $arrayData);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($curl);
	}
	function titimangsa($date) {
			$BulanIndo    = array("Januari", "Februari", "Maret","April", "Mei", "Juni","Juli", "Agustus", "September","Oktober", "November", "Desember");
			$tahun        = substr($date, 0, 4);
			$bulan        = substr($date, 5, 2);
			$tgl          = substr($date, 8, 2);
			$result       = $tgl." ".$BulanIndo[(int)$bulan-1]." ".$tahun;
			return($result);
	}

}
$refRekening = new refRekeningObj();
?>
