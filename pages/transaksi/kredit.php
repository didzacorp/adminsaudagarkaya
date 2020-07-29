<?php

class transaksiKreditObj  extends DaftarObj2{
	var $Prefix = 'transaksiKredit';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'kredit'; //bonus
	var $TblName_Hapus = 'kredit';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'transaksiKredit';
	var $PageIcon = 'images/administrasi_ico.png';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='transaksiKredit.xls';
	var $namaModulCetak='transaksiKredit';
	var $Cetak_Judul = 'transaksiKredit';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'transaksiKreditForm';
	var $noModul=14;
	var $TampilFilterColapse = 0; //0

	function setTitle(){
		return 'TRANSAKSI KREDIT';
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

	 if(empty($namaPihakLuar)){
		 	$err  ="Isi Nama Pihak Luar";
	 }

			if($fmST == 0){
				if($err==''){
							$dataInsert = array(
													'nama' => $namaPihakLuar,
							);
							$queryInsert = VulnWalkerInsert('kredit',$dataInsert);
							$this->sqlQuery($queryInsert);
				}
			}else{
				if($err==''){
					$dataUpdate = array(
													'nama' => $namaPihakLuar,
					);
					$queryUpdate = VulnWalkerUpdate('kredit',$dataUpdate,"id = '".$idplh."'");
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

	  switch($tipe){

		case 'formBaru':{
			$fm = $this->setFormBaru();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'sendBroadCast':{

			foreach ($_REQUEST as $key => $value) {
	 			 $$key = $value;
	 		}
			$arrayListEmail = explode(';',$listEmail);
			for ($i=0; $i < sizeof($arrayListEmail) ; $i++) {
					$this->mailBroadcast($arrayListEmail[$i],$subjectEmail,$isiEmail);
			}

		break;
		}
		case 'broadcastEmail':{
			foreach ($_REQUEST as $key => $value) {
	 			 $$key = $value;
	 		}
			$fm = $this->broadcastEmail();
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
		case 'addTestimoni':{
			$cbid = $_REQUEST[$this->Prefix.'_cb'];
			$fm = $this->addTestimoni($cbid[0]);
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'upgradetransaksiKredit':{
			$cbid = $_REQUEST[$this->Prefix.'_cb'];
			$idtransaksiKredit = $cbid[0];
			$getDatatransaksiKredit = $this->sqlArray($this->sqlQuery("select * from transaksiKredit where id ='$idtransaksiKredit'"));
			if($getDatatransaksiKredit['type_transaksiKredit'] == "PREMIUM"){
				$err = "Bukan Free transaksiKredit";
			}else{
				$dataPendaftaran = array(
																	'id_transaksiKredit' => $idtransaksiKredit,
																	'tanggal' => date("Y-m-d"),
																	'jumlah' => "250000",
																	'komisi' => "40000",
																);
				$queryPendaftarn = VulnWalkerInsert("pendaftaran",$dataPendaftaran);
				$this->sqlQuery($queryPendaftarn);
				$getIdPendaftaran = $this->sqlArray($this->sqlQuery("select max(id) from pendaftaran where id_transaksiKredit = '$idtransaksiKredit'"));
				$dataKomisi = array(
														"komisi_0" => $getDatatransaksiKredit['upline1'],
														"jenis_komisi" => "PENDAFTARAN",
														"id_pendaftaran" => $getIdPendaftaran['max(id)'],
														"tanggal" => date("Y-m-d"),
											);
				$queryKomisi = VulnWalkerInsert("komisi",$dataKomisi);
				$this->sqlQuery($queryKomisi);
				$this->sqlQuery("update transaksiKredit set saldo = saldo + 40000 where id = '".$getDatatransaksiKredit['upline1']."'");
				$this->sendMailUpline($getDatatransaksiKredit['upline1']);
				$this->sendMailtransaksiKredit($idtransaksiKredit);
				$this->sqlQuery("update transaksiKredit set type_transaksiKredit = 'PREMIUM' where id = '".$idtransaksiKredit."'");
			}

		break;
		}

		case 'savePembayaranKomisi':{
			foreach ($_REQUEST as $key => $value) {
	 			 $$key = $value;
	 		 }
			 if(empty($jumlahBayar)){
				 	$err = "Isi Jumlah Bayar";
			 }

			 if($err == ''){
				 	if(empty($nameOfFile)){
						$imageLocationBuktiTransfer = '';
					}else{
						$arrayFile = explode('.',$nameOfFile);
						$panjangArray = sizeof($arrayFile) - 1;
						$extensiFile =  $arrayFile[$panjangArray];
						$fileName = md5($nama).".".$extensiFile;
						$imageLocationBuktiTransfer = "media/buktiTransfer/".md5(date('Y-m-d')).md5(date('H:i:s')).md5($nama).".".$extensiFile;
						$this->baseToImage($baseOfFile,$imageLocationBuktiTransfer);

					}
				 	$data = array(
										'tanggal'=>$tanggalbayar,
										'id_transaksiKredit'=>$idtransaksiKredit,
										'jumlah'=>$jumlahBayar,
										'bukti_transfer'=>$imageLocationBuktiTransfer,
										'status' => "OK"
									);
					$queryInsert = VulnWalkerInsert("pembayaran_komisi",$data);
					$this->sqlQuery($queryInsert);
					$this->sqlQuery("update transaksiKredit set saldo = saldo - $jumlahBayar where id = '$idtransaksiKredit'");
					$this->sendMaillPembayaranKomisi($idtransaksiKredit,$jumlahBayar);

			 }


		break;
		}
		case 'saveTestimoni':{
			foreach ($_REQUEST as $key => $value) {
	 			 $$key = $value;
	 		 }
			 if(empty($nameOfFile)){
				 	$err = "Pilih Gambar";
			 }

			 if($err == ''){
						$arrayFile = explode('.',$nameOfFile);
						$panjangArray = sizeof($arrayFile) - 1;
						$extensiFile =  $arrayFile[$panjangArray];
						$fileName = md5($nama).".".$extensiFile;
						$imageLocationBuktiTransfer = "media/testimoni/".md5(date('Y-m-d')).md5(date('H:i:s')).md5($nama).".".$extensiFile;
						$this->baseToImage($baseOfFile,$imageLocationBuktiTransfer);
				 	$data = array(
										'id_transaksiKredit'=>$idtransaksiKredit,
										'image'=>$imageLocationBuktiTransfer,
									);
					$queryInsert = VulnWalkerInsert("testimoni",$data);
					$this->sqlQuery($queryInsert);
			 }


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
			"<script type='text/javascript' src='js/transaksi/kredit.js' language='JavaScript' ></script>
			<script src='js/thead.js'></script>
			<script src='js/jquery.fixedTableHeader.js' ></script>
			<script src='https://cdnjs.cloudflare.com/ajax/libs/floatthead/2.0.3/jquery.floatThead.js'></script>

".

			"
			<script src='lib/datepicker/js/bootstrap-datepicker.js'></script>
			<link rel='stylesheet' href='lib/datepicker/css/datepicker.css' />
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
	 $this->form_width = 500;
	 $this->form_height = 200;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru';
	  }else{
			$this->form_caption = 'Edit';
			$getData = $this->sqlArray($this->sqlQuery("select * from $this->TblName where id = '$dt'"));
			foreach ($getData as $key => $value) {
	 			 $$key = $value;
	 		 }
		}
		$arrayKategori = array(
				array('1','RUTIN'),
				array('2','PROJEK'),
		);
		$arrayJenisAKun = array(
				array('1','RUTIN'),
				array('2','PROJEK'),
		);
		$comboKategori = cmbArray('kategoriTransaksi',$kategoriTransaksi,$arrayKategori,'-- Kategori --',"") ;
		$comboJenisAkun = cmbArray('jenisAkun',$jenisAkun,$arrayJenisAKun,'-- Jenis Akun --',"onchange=$this->Prefix.jenisAkunChanged();") ;
	 //items ----------------------
	  $this->form_fields = array(

			'tanggalTransaksi' => array(
						'label'=>'TANGGAL',
						'labelWidth'=>100,
						'value'=>"<input type='text' name = 'tanggalTransaksi' id = 'tanggalTransaksi' class='form-control' value='".generateDate(date("Y-m-d"))."' >",
						 ),
			'kategoriTransaksi' => array(
						'label'=>'KATEGORI',
						'labelWidth'=>100,
						'value'=>$comboKategori,
						 ),
			'jenisAkun' => array(
						'label'=>'JENIS AKUN',
						'labelWidth'=>100,
						'value'=>$comboJenisAkun,
						 ),
			'akunb' => array(
						'label'=>"<span id='textAkun'",
						'labelWidth'=>100,
						'value'=>$comboJenisAkun,
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' class='btn btn-success' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan'>&nbsp&nbsp".
			"<input type='button' class='btn btn-success' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
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

	function bayarKomisi($idtransaksiKredit){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 175;

			$this->form_caption = 'PEMBAYARAN KOMISI';
			$getData = $this->sqlArray($this->sqlQuery("select * from transaksiKredit where id = '$idtransaksiKredit'"));
			foreach ($getData as $key => $value) {
	 			 $$key = $value;
	 		 }
			 $jenistransaksiKredit = $type_transaksiKredit;
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
			"<input type='button' class='btn btn-success' value='Simpan' onclick ='".$this->Prefix.".savePembayaranKomisi($idtransaksiKredit)' title='Simpan'>&nbsp&nbsp".
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
			$listEmail = implode(';',$_REQUEST['transaksiKredit_cb']);

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
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".sendBroadCast($idtransaksiKredit)' title='Simpan'>&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm2();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function addTestimoni($idtransaksiKredit){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 175;

			$this->form_caption = 'ADD TESTIMONI';
			$getData = $this->sqlArray($this->sqlQuery("select * from transaksiKredit where id = '$idtransaksiKredit'"));
			foreach ($getData as $key => $value) {
	 			 $$key = $value;
	 		 }
			 $jenistransaksiKredit = $type_transaksiKredit;
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
			"<input type='button' value='Simpan' class='btn btn-success' onclick ='".$this->Prefix.".saveTestimoni($idtransaksiKredit)' title='Simpan'>&nbsp&nbsp".
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
	  "<thead  align='center'>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox
		   <th class='th01' width='100'>TANGGAL</th>
		   <th class='th01' width='300' >JUMLAH</th>
		   <th class='th01' width='100'>KATEGORI</th>
		   <th class='th01' width='100' >JENIS AKUN</th>
		   <th class='th01' width='100'>AKUN</th>
		   <th class='th01' width='200'>DOKUMEN</th>
		   <th class='th01' width='200'>KETERANGAN</th>
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
	 $Koloms[] = array('align="left" valign="middle"',$nama);
	 return $Koloms;
	}


	function genDaftarOpsi(){
	 global $Ref, $Main;
	 foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}
		 $TampilOpt =
				"<div class='FilterBar' style='margin-top:5px;'>".
				"<table style='width:100%'>
				<tr>
					<td>NAMA PIHAK LUAR</td>
					<td>:</td>
					<td style='width:86%;'>
						<input type='text' class='form-control' name='filterNamaPihakLuar' id ='filterNamaPihakLuar' style='width:400px;' value='$filterNamaPihakLuar'>
					</td>
				</tr>
		    <tr>
				<td></td>
				<td></td>
				<td style='width:86%;'>
				<input class='btn btn-success' type='button' value='Tampilkan' onclick= $this->Prefix.refreshList(true);>
				</td>
				</tr>
				</table>".
				"</div>"

				;


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
		if(!empty($filterNamaPihakLuar)){
				$arrKondisi[] = "nama like '%$filterNamaPihakLuar%'";
		}
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
		switch($filterUrut){
			case '1': $arrOrders[] = " type_transaksiKredit $Asc1 " ;break;
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
		$this->pagePerHal = $jumlahPerHal;
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal;
		$HalDefault=cekPOST($this->Prefix.'_hal',1);
		//$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);

	}

	function sendMailtransaksiKredit($idtransaksiKredit){
			$getDatatransaksiKredit = $this->sqlArray($this->sqlQuery("select * from transaksiKredit where id = '$idtransaksiKredit'"));
			$namatransaksiKredit = $getDatatransaksiKredit['nama'];
			$isiEmail = "Selamat, status keanggotaan anda di ceukokom.com telah menjadi PREMIUM RESELLER

						";
			$arrayData = array(
									'emailTujuan' => $getDatatransaksiKredit['email'],
									'subject' => "Selamat $namatransaksiKredit",
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
	function mailBroadcast($idtransaksiKredit,$subjectEmail,$isiEmail){
			$getDatatransaksiKredit = $this->sqlArray($this->sqlQuery("select * from transaksiKredit where id = '$idtransaksiKredit'"));
			$namatransaksiKredit = $getDatatransaksiKredit['nama'];
			$arrayData = array(
									'emailTujuan' => $getDatatransaksiKredit['email'],
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
	function sendMailUpline($idtransaksiKredit){
			$getDatatransaksiKredit = $this->sqlArray($this->sqlQuery("select * from transaksiKredit where id = '$idtransaksiKredit'"));
			$namatransaksiKredit = $getDatatransaksiKredit['nama'];
			$isiEmail = "Selamat, komisi anda bertambah Rp ".number_format("40000",2,',','.')." dari pendaftaran RESELLER PREMIUM
						";
			$arrayData = array(
									'emailTujuan' => $getDatatransaksiKredit['email'],
									'subject' => "Hai $namatransaksiKredit",
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


	function sendMaillPembayaranKomisi($idtransaksiKredit,$jumlahBayar){
			$getDatatransaksiKredit = $this->sqlArray($this->sqlQuery("select * from transaksiKredit where id = '$idtransaksiKredit'"));
			$namatransaksiKredit = $getDatatransaksiKredit['nama'];
			$isiEmail = "Selamat, pembayaran komisi sebesar Rp ".number_format($jumlahBayar,2,',','.')." pada ".$this->titimangsa(date("Y-m-d"))." berhasil di lakukan
						";
			$arrayData = array(
									'emailTujuan' => $getDatatransaksiKredit['email'],
									'subject' => "Hai $namatransaksiKredit",
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
$transaksiKredit = new transaksiKreditObj();
?>
