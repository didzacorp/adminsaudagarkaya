<?php

class refMemberObj  extends configClass{
	var $Prefix = 'refMember';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'member'; //bonus
	var $TblName_Hapus = 'member';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'refMember';
	var $PageIcon = 'images/administrasi_ico.png';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='refMember.xls';
	var $namaModulCetak='refMember';
	var $Cetak_Judul = 'refMember';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'refMemberForm';
	var $noModul=14;
	var $TampilFilterColapse = 0; //0

	function setTitle(){
		return 'MEMBER';
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

	 if (empty($namaMember)) {
			 $err = "Isi Nama ";
	 } elseif (empty($emailMember)) {
			 $err = "Isi Email";
	 } elseif (empty($alamatMember)) {
			 $err = "Isi Alamat";
	 } elseif (empty($nomorTelepon)) {
			 $err = "Isi Telepon";
	 }

			if($fmST == 0){
			  if ($this->sqlNumRow($this->sqlQuery("select * from member where email='$emailMember'")) !=0) {
		 			 $err = "Email sudah terdaftar";
	  	 }
				if($err==''){
							$dataInsert = array(
								'nama' => $namaMember,
                'email' => $emailMember,
                'alamat' => $alamatMember,
                'nomor_telepon' => $nomorTelepon,
                'nama_bank' => $namaBank,
                'nomor_rekening' => $nomorRekening,
                'nama_rekening' => $namaRekening,
                'upline_level_1' => "0",
                'tanggal_join' => date("Y-m-d"),
                'lisensi' => $lisensiMember,
							);
							$queryInsert = $this->sqlInsert('member',$dataInsert);
							$cek = $queryInsert;
							$this->sqlQuery($queryInsert);
				}
			}else{
				if($err==''){
					$dataUpdate = array(
						'nama' => $namaMember,
						// 'email' => $emailMember,
						'alamat' => $alamatMember,
						'nomor_telepon' => $nomorTelepon,
						'nama_bank' => $namaBank,
						'nomor_rekening' => $nomorRekening,
						'nama_rekening' => $namaRekening,
						'upline_level_1' => "0",
						'tanggal_join' => date("Y-m-d"),
						'lisensi' => $lisensiMember,
					);
					$queryUpdate = $this->sqlUpdate('member',$dataUpdate,"id = '".$idplh."'");
					$this->sqlQuery($queryUpdate);
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
		case 'showDirectTeam':{
			$fm = $this->showDirectTeam($idMember);
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

		case 'bayarKomisi':{
			$cbid = $_REQUEST[$this->Prefix.'_cb'];
			$fm = $this->bayarKomisi($cbid[0]);
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
			"<script type='text/javascript' src='js/refMember/refMember.js' language='JavaScript' ></script>

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
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		$fm = $this->setForm($this->form_idplh);

		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

	function setForm($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 600;
	 $this->form_height = 420;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru';
	  }else{
			$this->form_caption = 'Edit';
			$getData = $this->sqlArray($this->sqlQuery("select * from $this->TblName where id = '$dt'"));
			foreach ($getData as $key => $value) {
	 			 $$key = $value;
	 		 }
			 $readonly = "readonly";

		}

		$this->form_fields = array(
			'namaMember' => array(
						'label'=>'NAMA MEMBER',
						'labelWidth'=>4,
						'contentWidth'=>8,
						'value'=>"<input type='text' name = 'namaMember' id = 'namaMember' class='form-control form-control-sm' value='$nama' >",
						 ),
			'emailMember' => array(
						'label'=>'EMAIL MEMBER',
						'labelWidth'=>4,
						'contentWidth'=>8,
						'value'=>"<input type='text' name = 'emailMember' id = 'emailMember' $readonly class='form-control form-control-sm' value='$email' >",
						 ),
			'nomorTelepon' => array(
						'label'=>'NOMOR TELEPON',
						'labelWidth'=>4,
						'contentWidth'=>8,
						'value'=>"<input type='text' name = 'nomorTelepon' id = 'nomorTelepon' class='form-control form-control-sm' value='$nomor_telepon' >",
						 ),
			 'alamat' => array(
		 				'label'=>"ALAMAT",
		 				'labelWidth'=>4,
		 				'contentWidth'=>8,
		 				'value'=> $this->textArea(array(
		 					'id' => 'alamatMember',
		 					'class' =>"form-control form-control-sm",
							'value' => $alamat
		 				))
		 			),
				'namaBank' => array(
						'label'=>'NAMA BANK',
						'labelWidth'=>4,
						'contentWidth'=>8,
						'value'=>"<input type='text' name = 'namaBank' id = 'namaBank' class='form-control form-control-sm' value='$nama_bank' >",
				 ),
				'nomorRekening' => array(
						'label'=>'NOMOR REKENING',
						'labelWidth'=>4,
						'contentWidth'=>8,
						'value'=>"<input type='text' name = 'nomorRekening' id = nomorRekening' class='form-control form-control-sm' value='$nomor_rekening' >",
				 ),
				'namaRekening' => array(
						'label'=>'ATAS NAMA',
						'labelWidth'=>4,
						'contentWidth'=>8,
						'value'=>"<input type='text' name = 'namaRekening' id = namaRekening' class='form-control form-control-sm' value='$nama_rekening' >",
				 ),
	 			'lisensi' => array(
						'label'=>'LISENSI',
						'labelWidth'=>4,
						'contentWidth'=>8,
						'value'=> cmbArray("lisensiMember",$lisensi,array(array("FREE","FREE"),array("PREMIUM","PREMIUM")),"-- LISENSI --","class='form-control form-control-sm'"),
				 ),
			);
		//tombol
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

	function bayarKomisi($idrefMember){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 175;

			$this->form_caption = 'PEMBAYARAN KOMISI';
			$getData = $this->sqlArray($this->sqlQuery("select * from refMember where id = '$idrefMember'"));
			foreach ($getData as $key => $value) {
	 			 $$key = $value;
	 		 }
			 $jenisrefMember = $type_refMember;
			  $objectSosmed = json_decode($sosial_media);
				$facebook = $objectSosmed->facebook;
				$twiter = $objectSosmed->twiter;
				$instagram = $objectSosmed->instagram;
				$line = $objectSosmed->line;
				$bbm = $objectSosmed->bbm;
				$whatsapp = $objectSosmed->whatsapp;


	  	$res = $this->sqlQuery($query);

	 //items ----------------------
	  $this->form_fields = array(
			'username' => array(
						'label'=>'USERNAME',
						'labelWidth'=>150,
						'value'=>$username
						 ),
			'nama' => array(
						'label'=>'NAMA',
						'labelWidth'=>100,
						'value'=>$nama,
						 ),
			'saldo' => array(
						'label'=>'SALDO',
						'labelWidth'=>100,
						'value'=>$saldo,
						 ),
			'bayar' => array(
						'label'=>'DI BAYAR',
						'labelWidth'=>100,
						'value'=>"<input type='text' name='jumlahBayar' onkeypress='return event.charCode >= 48 && event.charCode <= 57' id='jumlahBayar' >",
						 ),
			'tanggal' => array(
						'label'=>'TANGGAL',
						'labelWidth'=>100,
						'value'=> "<input type='text'  value='".date('d-m-Y')."' readonly>
											<input type='hidden' id='tanggalBayar' name='tanggalbayar' value='".date("Y-m-d")."'>
											",
						 ),
		'buktiTransfer' => array(
						'label'=>'BUKTI TRANFER',
						'labelWidth'=>100,
						'value'=>  "
			  <input type='hidden' name='nameOfFile' id='nameOfFile' >
			  <input type='hidden' name='baseOfFile' id='baseOfFile' >
                <input type='file' name='buktiTransfer' id='buktiTransfer' accept='image/x-png,image/gif,image/jpeg' onchange=$this->Prefix.buktiTransferChanged() placeholder='image'>",
						 ),



			);
		//tombol
		$this->form_menubawah =
			"<input type='button' class='btn btn-success' value='Simpan' onclick ='".$this->Prefix.".savePembayaranKomisi($idrefMember)' title='Simpan'>&nbsp&nbsp".
			"<input type='button' class='btn btn-success' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function broadcastEmail(){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 175;

			$this->form_caption = 'BROADCAST EMAIL';
			$listEmail = implode(';',$_REQUEST['refMember_cb']);

	 //items ----------------------
	  $this->form_fields = array(
			'subject' => array(
						'label'=>'SUBJECT',
						'labelWidth'=>150,
						'value'=>"
						<input type='hidden' name='listEmail' id='listEmail' value='$listEmail'>
						<input type='text' name='subjectEmail' id='subjectEmail' style='width:100%;'>"
						 ),
			'nama' => array(
						'label'=>'',
						'labelWidth'=>100,
						'value'=>"<textarea id='isiEmail' name='isiEmail'></textarea>",
						'type'=>"merge",
						 ),



			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".sendBroadCast($idrefMember)' title='Simpan'>&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm2();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function addTestimoni($idrefMember){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 175;

			$this->form_caption = 'ADD TESTIMONI';
			$getData = $this->sqlArray($this->sqlQuery("select * from refMember where id = '$idrefMember'"));
			foreach ($getData as $key => $value) {
	 			 $$key = $value;
	 		 }
			 $jenisrefMember = $type_refMember;
			  $objectSosmed = json_decode($sosial_media);
				$facebook = $objectSosmed->facebook;
				$twiter = $objectSosmed->twiter;
				$instagram = $objectSosmed->instagram;
				$line = $objectSosmed->line;
				$bbm = $objectSosmed->bbm;
				$whatsapp = $objectSosmed->whatsapp;


	  	$res = $this->sqlQuery($query);

	 //items ----------------------
	  $this->form_fields = array(
			'username' => array(
						'label'=>'USERNAME',
						'labelWidth'=>150,
						'value'=>$username
						 ),
			'nama' => array(
						'label'=>'NAMA',
						'labelWidth'=>100,
						'value'=>$nama,
						 ),
			'saldo' => array(
						'label'=>'SALDO',
						'labelWidth'=>100,
						'value'=>$saldo,
						 ),
		'buktiTransfer' => array(
						'label'=>'TESTIMONI',
						'labelWidth'=>100,
						'value'=>  "
			  <input type='hidden' name='nameOfFile' id='nameOfFile' >
			  <input type='hidden' name='baseOfFile' id='baseOfFile' >
                <input type='file' name='buktiTransfer' id='buktiTransfer' accept='image/x-png,image/gif,image/jpeg' onchange=$this->Prefix.buktiTransferChanged() placeholder='image'>",
						 ),



			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' class='btn btn-success' onclick ='".$this->Prefix.".saveTestimoni($idrefMember)' title='Simpan'>&nbsp&nbsp".
			"<input type='button' value='Batal' class='btn btn-success' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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
  	   <th class='th01' width='5' style='text-align:center;vertical-align:middle;'>No.</th>
  	   $Checkbox
		   <th class='th01' style='text-align:center;vertical-align:middle;width:15%;'>NAMA</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>EMAIL</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>NO TELEPON</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:20%;'>ALAMAT</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>BANK</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>UPLINE</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:7%;'>TANGGAL JOIN</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>LISENSI</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:1%;'>DIRECT TEAM</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>TEAM</th>
	   </tr>
	   </thead>";

		return $headerTable;
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 foreach ($isi as $key => $value) {
			 $$key = $value;
		 }
		 $Koloms   = array();
		 $Koloms[] = array(
				 'align="center" valign="middle"',
				 $no . '.'
		 );
		 if ($Mode == 1)
				 $Koloms[] = array(
						 " align='center'  ",
						 $TampilCheckBox
				 );
		 $Koloms[] = array(
				 'align="left" valign="middle"',
				 $nama
		 );
		 $Koloms[] = array(
				 'align="left" valign="middle"',
				 $email
		 );
		 $Koloms[] = array(
				 'align="left" valign="middle"',
				 $nomor_telepon
		 );
		 $Koloms[] = array(
				 'align="left" valign="middle"',
				 $alamat
		 );
		 $Koloms[] = array(
				 'align="center" valign="middle"',
				 $nama_bank."<br>".
				 $nomor_rekening."<br>A/N ".
				 $nama_rekening
		 );

		 $getNamaUplineLevel1 = sqlArray(sqlQuery("select * from member where id = '$upline_level_1'"));
		 $arrayPiramid = array();

		 if(!empty($getNamaUplineLevel1['nama']))$arrayPiramid[]=$getNamaUplineLevel1['nama'];
		 $Koloms[] = array(
				 'align="center" valign="middle"',
				 implode("<br> <i class='fa fa-chevron-down'></i> <br>",$arrayPiramid)
		 );
		 $Koloms[] = array(
				 'align="center" valign="middle"',
				 $this->generateDate($tanggal_join)
		 );
		 $Koloms[] = array(
				 'align="center" valign="middle"',
				 $lisensi
		 );
		 $jumlahDirectTeam = sqlRowCount(sqlQuery("select * from member where upline_level_1 = '$id'"));
		 $Koloms[] = array(
				 'align="right" valign="middle"',
				 $jumlahDirectTeam
		 );

		 $Koloms[] = array(
				 'align="center" valign="middle"',
				 "<input type='button' class='btn btn-success' value='DETAIL' onclick=$this->Prefix.showDirectTeam($id)> "
		 );

	 return $Koloms;
	}


	function genDaftarOpsi(){
	 global $Ref, $Main;
	 foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}
		if(empty($jumlahData))$jumlahData =50;

			$TampilOpt = "
				<div class='form-group'>
          <div class='row' style='margin-top:5px !important;'>
            <label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>NAMA</label>
            <div class='col-sm-3'>
							<input type='text' class='form-control form-control-sm' name='filterNamaMember' id ='filterNamaMember'  value='$filterNamaMember'>
						</div>
          </div>
          <div class='row' style='margin-top:5px !important;'>
            <label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>EMAIL</label>
            <div class='col-sm-3'>
							<input type='text' class='form-control form-control-sm' name='filterEmailMember' id ='filterEmailMember'  value='$filterEmailMember'>
						</div>
          </div>
          <div class='row' style='margin-top:5px !important;'>
            <label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>NOMOR TELEPON</label>
            <div class='col-sm-3'>
							<input type='text' class='form-control form-control-sm' name='filterNomorTelepon' id ='filterNomorTelepon' value='$filterNomorTelepon'>
						</div>
          </div>
          <div class='row' style='margin-top:5px !important;'>
            <label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>NAMA BANK</label>
            <div class='col-sm-3'>
							<input type='text' class='form-control form-control-sm' name='filterNamaBank' id ='filterNamaBank'  value='$filterNamaBank'>
						</div>
          </div>
          <div class='row' style='margin-top:5px !important;'>
            <label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>ALAMAT</label>
            <div class='col-sm-3'>
							<input type='text' class='form-control form-control-sm' name='filterAlamat' id ='filterAlamat'  value='$filterAlamat'>
						</div>
          </div>
          <div class='row' style='margin-top:5px !important;'>
            <label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>LISENSI</label>
            <div class='col-sm-3'>
							".cmbArray('filterLisensi',$filterLisensi,array(array("FREE","FREE"),array("PREMIUM","PREMIUM")),'-- LISENSI --',"class='form-control form-control-sm'")."
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
		if(!empty($filterNamaMember)){
				$arrKondisi[] = "nama like '%$filterNamaMember%'";
		}
		if(!empty($filterEmailMember)){
				$arrKondisi[] = "email like '%$filterEmailMember%'";
		}
		if(!empty($filterNomorTelepon)){
				$arrKondisi[] = "nomor_telepon like '%$filterNomorTelepon%'";
		}
		if(!empty($filterNamaBank)){
				$arrKondisi[] = "nama_bank like '%$filterNamaBank%'";
		}
		if(!empty($filterAlamat)){
				$arrKondisi[] = "alamat like '%$filterAlamat%'";
		}
		if(!empty($filterLisensi)){
				$arrKondisi[] = "lisensi = '$filterLisensi'";
		}
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
		switch($filterUrut){
			case '1': $arrOrders[] = " type_refMember $Asc1 " ;break;
			case '2': $arrOrders[] = " username $Asc1 " ;break;
			case '3': $arrOrders[] = " nama $Asc1 " ;break;
			case '4': $arrOrders[] = " saldo $Asc1 " ;break;
		}
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

	function showDirectTeam($idMember){
	 global $SensusTmp ,$Main;
	 $cek = "$this->tahunAnggaran:$this->tahunAnggaran"; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 700;
	 $this->form_height = 350;
   $this->form_caption = 'DIREC TEAM';

	 $getDataMember = $this->sqlArray($this->sqlQuery("select * from member where id = '$idMember'"));



			$this->form_fields = array(

			 'namaMember' => array(
						 'label'=>'NAMA MEMBER',
						 'labelWidth'=>3,
						 'contentWidth'=>9,
						 'value'=>"<input type='text' name = 'namaMember' id = 'namaMember'class='form-control form-control-sm' readonly value='".$getDataMember['nama']."' >",
			),
			 'emailMember' => array(
						 'label'=>'EMAIl MEMBER',
						 'labelWidth'=>3,
						 'contentWidth'=>9,
						 'value'=>"<input type='text' name = 'emailMember' id = 'emailMember'class='form-control form-control-sm' readonly value='".$getDataMember['email']."' >",
			),
			'listDirectTeam' => array(
						'contentWidth'=>12,
						'type' => "merge",
						'value'=>"
						<div class='col-sm-12'  id='listDirectTeam'>
						 ".$this->listDirectTeam($idMember)."
						</div>
						"

					),

				);
		$this->form_menubawah =
		"<input type='button' class='btn btn-danger btn-sm' style='background-color: #dc3545; border-color: #dc3545' value='Tutup' onclick=$this->Prefix.Close(); >";
		$form = $this->genFormBootstrapFS();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function listDirectTeam($idMember){
			$cek = '';
			$err = '';
			$datanya='';
			$username = $_COOKIE['coID'];

			$getDataMember = sqlQuery("select * from member where upline_level_1 = '".$idMember."' ");
			$no=1;
			while($dt = $this->sqlArray($getDataMember)){
			foreach ($dt as $key => $value) {
						$$key = $value;
			}

				if($no % 2 == 1){
					$rowClass = "row0";
				}else{
					$rowClass = "row1";
				}
				$datanya.="
							<tr class='$rowClass'>
								<td class='GarisDaftar'  style='text-align:left;valign:middle;' align='center'>$no</a></td>
								<td class='GarisDaftar' style='text-align:left;valign:middle;'>$nama</td>
			          <td class='GarisDaftar' style='text-align:center;valign:middle;'>$email</td>
			          <td class='GarisDaftar' style='text-align:center;valign:middle;'>$nomor_telepon</td>

							</tr>
				";
				$no = $no+1;
			}

			if($no % 2 == 1){
				$rowClass = "row0";
			}else{
				$rowClass = "row1";
			}

			$content =
				"
			<table class='table table-striped floatThead-table' border='1' style='border-collapse: collapse; border-width: 1px 1px 0px; border-style: outset; border-color: rgb(128, 128, 128); border-image: initial; display: table; width: 100%; margin: 0px; '><colgroup><col style='width: 33px;'><col style='width: 30px;'><col style='width: 100px;'><col style='width: 100px;'><col style='width: 400px;'><col style='width: auto;'></colgroup><thead>
					   <tr>
					      <th class='th01' style='text-align:center;vertical-align:middle;width:1%;'>No.</th>
				         <th class='th01' style='text-align:center;vertical-align:middle;width:20%;'>NAMA</th>
				         <th class='th01' style='text-align:center;vertical-align:middle;width:30%;'>EMAIL</th>
				         <th class='th01' style='text-align:center;vertical-align:middle;width:30%;'>Telepon</th>
					   </tr>

					   </thead>
						 $datanya
						 </table>
						"
			;

			return	$content;
		}



}
$refMember = new refMemberObj();
?>
