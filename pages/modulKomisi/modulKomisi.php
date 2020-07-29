<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
class modulKomisiObj  extends configClass{
	var $Prefix = 'modulKomisi';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'view_rekap_komisi'; //bonus
	var $TblName_Hapus = 'komisi';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id_member');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'modulKomisi';
	var $PageIcon = 'images/administrasi_ico.png';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='modulKomisi.xls';
	var $namaModulCetak='modulKomisi';
	var $Cetak_Judul = 'modulKomisi';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'modulKomisiForm';
	var $noModul=14;
	var $TampilFilterColapse = 0; //0

	function setTitle(){
		return 'KOMISI';
	}
	function filterSaldoMiring(){
		return "";
	}
	function setMenuEdit(){
		return "

			<li class='nav-item' style='margin-right: 10px;margin-left: 10px;'>
				<a class='toolbar' id='' href='javascript:$this->Prefix.Laporan()' title='Laporan'>
					<img src='images/administrator/images/print_f2.png' alt='button' name='save' width='22' height='22' border='0' align='middle'>
					Laporan
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
			  if ($this->sqlNumRow($this->sqlQuery("select * from komisi where email='$emailMember'")) !=0) {
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
							$queryInsert = $this->sqlInsert('komisi',$dataInsert);
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
					$queryUpdate = $this->sqlUpdate('komisi',$dataUpdate,"id = '".$idplh."'");
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
			case 'viewLaporan':{
				$json = FALSE;
				$this->viewLaporan();
				break;
			}
			case 'Laporan':{
				$fm = $this->Laporan();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
			}
			case 'saveKonfirmasi': {
					$get     = $this->saveKonfirmasi();
					$cek     = $get['cek'];
					$err     = $get['err'];
					$content = $get['content'];
					break;
			}
			case 'Konfirmasi':{
				$fm = $this->Konfirmasi($modulKomisi_cb[0]);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
			}
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
			"<script type='text/javascript' src='js/modulKomisi/modulKomisi.js' language='JavaScript' ></script>

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
						'label'=>'NAMA KOMISI',
						'labelWidth'=>4,
						'contentWidth'=>8,
						'value'=>"<input type='text' name = 'namaMember' id = 'namaMember' class='form-control form-control-sm' value='$nama' >",
						 ),
			'emailMember' => array(
						'label'=>'EMAIL KOMISI',
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

	function bayarKomisi($idmodulKomisi){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 175;

			$this->form_caption = 'PEMBAYARAN KOMISI';
			$getData = $this->sqlArray($this->sqlQuery("select * from modulKomisi where id = '$idmodulKomisi'"));
			foreach ($getData as $key => $value) {
	 			 $$key = $value;
	 		 }
			 $jenismodulKomisi = $type_modulKomisi;
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
			"<input type='button' class='btn btn-success' value='Simpan' onclick ='".$this->Prefix.".savePembayaranKomisi($idmodulKomisi)' title='Simpan'>&nbsp&nbsp".
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
			$listEmail = implode(';',$_REQUEST['modulKomisi_cb']);

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
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".sendBroadCast($idmodulKomisi)' title='Simpan'>&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm2();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function addTestimoni($idmodulKomisi){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 175;

			$this->form_caption = 'ADD TESTIMONI';
			$getData = $this->sqlArray($this->sqlQuery("select * from modulKomisi where id = '$idmodulKomisi'"));
			foreach ($getData as $key => $value) {
	 			 $$key = $value;
	 		 }
			 $jenismodulKomisi = $type_modulKomisi;
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
			"<input type='button' value='Simpan' class='btn btn-success' onclick ='".$this->Prefix.".saveTestimoni($idmodulKomisi)' title='Simpan'>&nbsp&nbsp".
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
		   <th class='th01' style='text-align:center;vertical-align:middle;width:7%;'>PERIODE</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:20%;'>NAMA</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:5%;'>EMAIL</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:5%;'>NOMOR TELEPON</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:5%;'>BANK</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:5%;'>NOMOR REKENING</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:5%;'>NAMA REKENING</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>OMSET</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>PROFIT</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>REFERAL</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>TOTAL KOMISI</th>
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
			$explodeTanggal = explode("-",$periode);
			$Koloms[] = array(
					'align="center" valign="middle"',
					$explodeTanggal[1]."-".$explodeTanggal[0]
			);
			$getDataMember = $this->sqlArray($this->sqlQuery("select * from member where id = '$id_member'"));
			$Koloms[] = array(
					'align="left" valign="middle"',
					$getDataMember['nama']
			);
			$Koloms[] = array(
					'align="left" valign="middle"',
					$getDataMember['email']
			);
			$Koloms[] = array(
					'align="left" valign="middle"',
					$getDataMember['nomor_telepon']
			);
			$Koloms[] = array(
					'align="left" valign="middle"',
					$getDataMember['nama_bank']
			);
			$Koloms[] = array(
					'align="left" valign="middle"',
					$getDataMember['nomor_rekening']
			);
			$Koloms[] = array(
					'align="left" valign="middle"',
					$getDataMember['nama_rekening']
			);
			// $getDataTransaksi['status'] == 'BELUM BAYAR' || $getDataTransaksi['status'] == 'MENUNGGU KONFIRMASI' ) && $statusTransaksi == 'TERKONFIRMASI'
			if(!empty($filterPeriode)){
					$explodePeriode = explode("-",$filterPeriode);
					$arrKondisi[] = "year(tanggal) = '".$explodePeriode[1]."' and month(tanggal) = '".$explodePeriode[0]."'";
					// $getTotalPenjualan = $this->sqlArray($this->sqlQuery("select count(id) from transaksi where status not in ('BELUM BAYAR','MENUNGGU KONFIRMASI') and year(tanggal) = '".$explodePeriode[1]."' and month(tanggal) = '".$explodePeriode[0]."' and id_member = '$id_member' "));
					// $getDataKomisi = $this->sqlArray($this->sqlQuery("select sum(komisi) from komisi where id_member = '$id_member' and year(tanggal) = '".$explodePeriode[1]."' and month(tanggal) = '".$explodePeriode[0]."' "));

			}else{
				$arrKondisi[] = "year(tanggal) = '".date("Y")."' and month(tanggal) = '".date("m")."'";
				// $getTotalPenjualan = $this->sqlArray($this->sqlQuery("select count(id) from transaksi where status not in ('BELUM BAYAR','MENUNGGU KONFIRMASI') and year(tanggal) = '".date("Y")."' and month(tanggal) = '".date("m")."' "));
				// $getDataKomisi = $this->sqlArray($this->sqlQuery("select sum(komisi) from komisi where id_member = '$id_member' and year(tanggal) = '".date("Y")."' and month(tanggal) = '".date("m")."'  and id_member = '$id_member' "));
			}
			$Koloms[] = array(
					'align="right" valign="middle"',
					$this->numberFormat($omset_profit,0)
			);
			$Koloms[] = array(
					'align="right" valign="middle"',
					$this->numberFormat($profit,0)
			);
			$Koloms[] = array(
					'align="right" valign="middle"',
					$this->numberFormat($komisi_referal,0)
			);
			$Koloms[] = array(
					'align="right" valign="middle"',
					$this->numberFormat($profit + $komisi_referal,0)
			);


	 return $Koloms;
	}


	function genDaftarOpsi(){
	 global $Ref, $Main;
	 foreach ($_REQUEST as $key => $value) {
			$$key = $value;
		}
		if(empty($jumlahData))$jumlahData =50;
		$arrayStatus = array(
			 array("BELUM BAYAR","BELUM BAYAR"),
			 array("MENUNGGU KONFIRMASI","MENUNGGU KONFIRMASI"),
			 array("TERKONFIRMASI","TERKONFIRMASI"),
			 array("DIKIRIM","DIKIRIM"),
			 array("SELESAI","SELESAI"),
		 );
	  if(empty($filterPeriode)){
			$filterPeriode = date("m-Y");
		}
		$TampilOpt = "
			<div class='form-group'>
				<div class='row' style='margin-top:5px !important;'>
					<label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>PERIODE</label>
					<div class='col-sm-3'>
						<input type='text' class='form-control form-control-sm' name='filterPeriode' id ='filterPeriode'  value='$filterPeriode'>
					</div>
				</div>
				<div class='row' style='margin-top:5px !important;'>
					<label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>NAMA MEMBER</label>
					<div class='col-sm-4'>
						<input type='text' class='form-control form-control-sm' name='filterNamaMember' id ='filterNamaMember'  value='$filterNamaMember'>
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
		if(!empty($filterPeriode)){
				$explodePeriode = explode("-",$filterPeriode);
				$arrKondisi[] = "periode = '".$explodePeriode[1]."-".$explodePeriode[0]."'";
		}else{
			$arrKondisi[] = "periode = '".date("Y")."-".date("m")."'";
		}


		if(!empty($filterNamaMember)){
				$arrKondisi[] = "id_member in (select id from member where nama like '%$filterNamaMember%') ";
		}

		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
    // $arrOrders[] = " id desc ";

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

	function Konfirmasi($idTransaksi){
	 global $SensusTmp ,$Main;
	 $cek = "$this->tahunAnggaran:$this->tahunAnggaran"; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 700;
	 $this->form_height = 350;
   $this->form_caption = 'KOMISI';

	 $getDataTransaksi = $this->sqlArray($this->sqlQuery("select * from komisi where id = '$idTransaksi'"));
	 $getDataMember = $this->sqlArray($this->sqlQuery("select * from member where id ='".$getDataTransaksi['id_member']."'"));
	 $arrayStatus = array(
			array("BELUM BAYAR","BELUM BAYAR"),
			array("MENUNGGU KONFIRMASI","MENUNGGU KONFIRMASI"),
			array("TERKONFIRMASI","TERKONFIRMASI"),
			array("DIKIRIM","DIKIRIM"),
			array("SELESAI","SELESAI"),
		);


			$this->form_fields = array(

			 'namaMember' => array(
						 'label'=>'NAMA MEMBER',
						 'labelWidth'=>3,
						 'contentWidth'=>9,
						 'value'=>"<input type='text' name = 'namaMember' id = 'namaMember' class='form-control form-control-sm' readonly value='".$getDataMember['nama']."' readonly >",
			),
			 'tanggalTransaksi' => array(
						 'label'=>'TANGGAL KOMISI',
						 'labelWidth'=>3,
						 'contentWidth'=>9,
						 'value'=>"<input type='text' name = 'tanggalTransaksi' id = 'tanggalTransaksi' class='form-control form-control-sm' readonly value='".$this->generateDate($getDataTransaksi['tanggal'])."' >",
			),
			 'namaPembeli' => array(
						 'label'=>'NAMA PEMBELI',
						 'labelWidth'=>3,
						 'contentWidth'=>9,
						 'value'=>"<input type='text' name = 'namaPembeli' id = 'namaPembeli' class='form-control form-control-sm' readonly value='".$getDataTransaksi['nama_pembeli']."' >",
			),
			 'emailPembeli' => array(
						 'label'=>'EMAIL PEMBELI',
						 'labelWidth'=>3,
						 'contentWidth'=>9,
						 'value'=>"<input type='text' name = 'emailPembeli' id = 'emailPembeli' class='form-control form-control-sm' readonly value='".$getDataTransaksi['email_pembeli']."' >",
			),
			 'nomorTelepon' => array(
						 'label'=>'NOMOR TELEPON',
						 'labelWidth'=>3,
						 'contentWidth'=>9,
						 'value'=>"<input type='text' name = 'nomor_telepon' id = 'nomor_telepon' class='form-control form-control-sm' readonly value='".$getDataTransaksi['nomor_telepon']."' >",
			),

			 'alamatPembeli' => array(
						 'label'=>'ALAMAT',
						 'labelWidth'=>3,
						 'contentWidth'=>9,
						 'value'=>$this->textArea(array(
				  							'id' => 'alamatPembeli',
				  							'value' => $getDataTransaksi['alamat_pengiriman'],
				  							'params' =>'readonly',
				 								'class' => 'form-control form-control-sm'
				  						))
			),
			'listDirectTeam' => array(
						'contentWidth'=>12,
						'type' => "merge",
						'value'=>"
						<div class='col-sm-12'  id='listDirectTeam'>
						 ".$this->listDetailTransaksi($idTransaksi)."
						</div>
						"
					),
			'kodeUnik' => array(
						'label'=>'KODE UNIK',
						'labelWidth'=>3,
						'contentWidth'=>9,
						'value'=>"<input type='text' name = 'kodeUnik' id = 'kodeUnik' class='form-control form-control-sm' readonly value='".$getDataTransaksi['kode_unik']."' >",
		 ),
			'Total' => array(
						'label'=>'TOTAL',
						'labelWidth'=>3,
						'contentWidth'=>9,
						'value'=>"<input type='text' name = 'total' id = 'total' class='form-control form-control-sm' readonly value='".$this->numberFormat($getDataTransaksi['total'])."' >",
		 ),
			'servicePengiriman' => array(
						'label'=>'SERVICE PENGIRIMAN',
						'labelWidth'=>3,
						'contentWidth'=>9,
						'value'=>"<input type='text' name = 'servicePengiriman' id = 'servicePengiriman' class='form-control form-control-sm' readonly value='".$getDataTransaksi['service_pengiriman']."' >",
		 ),
		 'keterangan' => array(
					 'label'=>'KETERANGAN',
					 'labelWidth'=>3,
					 'contentWidth'=>9,
					 'value'=>$this->textArea(array(
											'id' => 'keteranganTransaksi',
											'value' => $getDataTransaksi['keterangan'],
											'class' => 'form-control form-control-sm'
										))
		),
			'nomorResi' => array(
						'label'=>'NOMOR RESI',
						'labelWidth'=>3,
						'contentWidth'=>9,
						'value'=>"<input type='text' name = 'nomorResi' id = 'nomorResi' class='form-control form-control-sm'  value='".$getDataTransaksi['nomor_resi']."' >",
		 ),
		 'status' => array(
				 'label'=>'STATUS',
				 'labelWidth'=>3,
				 'contentWidth'=>9,
				 'value'=> cmbArray("statusTransaksi",$getDataTransaksi['status'],$arrayStatus,"-- STATUS --","class='form-control form-control-sm'"),
			),


		);
		$this->form_menubawah =
		"<input type='button' class='btn btn-primary btn-sm' style='color:#fff;background-color: #007bff;border-color:#007bff' value='Simpan' onclick ='".$this->Prefix.".saveKonfirmasi($idTransaksi)' title='Simpan'>&nbsp&nbsp".
		"<input type='button' class='btn btn-danger btn-sm' style='background-color: #dc3545; border-color: #dc3545' value='Tutup' onclick=$this->Prefix.Close(); >";
		$form = $this->genFormBootstrapFS();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function listDetailTransaksi($idTransaksi){
			$cek = '';
			$err = '';
			$datanya='';
			$username = $_COOKIE['coID'];

			$getDataDetailTransaksi = sqlQuery("select * from detail_komisi where id_komisi = '$idTransaksi'");
			$no=1;
			while($dt = $this->sqlArray($getDataDetailTransaksi)){
				foreach ($dt as $key => $value) {
							$$key = $value;
				}
				$getDataProduk = $this->sqlArray($this->sqlQuery("select * from produk where id ='$id_produk'"));


				if($no % 2 == 1){
					$rowClass = "row0";
				}else{
					$rowClass = "row1";
				}
				$subTotal += $total;
				$datanya.="
							<tr class='$rowClass'>
								<td class='GarisDaftar'  style='text-align:left;valign:middle;' align='center'>$no</a></td>
								<td class='GarisDaftar' style='text-align:left;valign:middle;'>".$getDataProduk['nama_produk']."</td>
								<td class='GarisDaftar' style='text-align:right;valign:middle;'>".$this->numberFormat($jumlah,0)."</td>
		            <td class='GarisDaftar' style='text-align:right;valign:middle;'>".$this->numberFormat($harga,0)."</td>
		            <td class='GarisDaftar' style='text-align:right;valign:middle;'>".$this->numberFormat($total,0)."</td>
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
				         <th class='th01' style='text-align:center;vertical-align:middle;width:60%;'>PRODUK</th>
				         <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>QTY</th>
				         <th class='th01' style='text-align:center;vertical-align:middle;width:15%;'>HARGA</th>
				         <th class='th01' style='text-align:center;vertical-align:middle;width:20%;'>TOTAL</th>
					   </tr>

					   </thead>
						 $datanya
						 <tr class='$rowClass'>
								<td class='GarisDaftar' style='text-align:right;valign:middle;' colspan='4'>TOTAL</td>
								<td class='GarisDaftar' style='text-align:right;valign:middle;'>".$this->numberFormat($subTotal,0)."</td>
							</tr>
						 </table>
						"
			;

			return	$content;
		}

		function saveKonfirmasi()
    {
        global $HTTP_COOKIE_VARS;
        global $Main;
        foreach ($_REQUEST as $key => $value) {
            $$key = $value;
        }
        $cek     = '';
        $err     = '';
        $content = '';
        $json    = TRUE;

        $fmST  = $_REQUEST[$this->Prefix . '_fmST'];
        $idplh = $_REQUEST[$this->Prefix . '_idplh'];
        if (empty($statusTransaksi)) {
            $err = "Pilih status";
        }

        if ($err == '') {
          $getDataTransaksi = $this->sqlArray($this->sqlQuery("select * from komisi where id='$idEdit'"));
          $getDataMember = $this->sqlArray($this->sqlQuery("select * from member where id ='".$getDataTransaksi['id_member']."'"));

          if($getDataTransaksi['jenis_komisi'] == 'PENJUALAN'){
            if(($getDataTransaksi['status'] == 'BELUM BAYAR' || $getDataTransaksi['status'] == 'MENUNGGU KONFIRMASI' ) && $statusTransaksi == 'TERKONFIRMASI'){
              $getDetailTransaksi = sqlQuery("select * from detail_komisi where id_komisi ='$idEdit'");
              while ($dataDetailTransaksi = sqlArray($getDetailTransaksi)) {
                $getDataProduk = $this->sqlArray($this->sqlQuery("select * from produk where id = '".$dataDetailTransaksi['id_produk']."'"));
                $arrayKomisiProduk = json_decode($getDataProduk['komisi']);
                $arrayBagiKomisi[] = array(
                   "komisiLevel1" =>  $getDataProduk['komisi'] * $dataDetailTransaksi['jumlah'],
                   "komisiMember" =>  $getDataProduk['profit'] * $dataDetailTransaksi['jumlah'],
                   "jumlahProduk" =>  $dataDetailTransaksi['jumlah'],
                );
              }
              $getDataUplineNomor1 = $this->sqlArray($this->sqlQuery("select * from member where id = '".$getDataMember['upline_level_1']."'"));

              for ($i=0; $i < sizeof($arrayBagiKomisi); $i++) {
                  if($getDataUplineNomor1['lisensi'] == "PREMIUM"){
                    $totalKomisiLevel1 += $arrayBagiKomisi[$i]['komisiLevel1'];
                  }
                  $jumlahProduk += $arrayBagiKomisi[$i]['jumlahProduk'];
                  $komisiMember += $arrayBagiKomisi[$i]['komisiMember'];
              }
              if($getDataUplineNomor1['lisensi'] == "PREMIUM"){
                $dataKomisiMemberLevel1 = array(
                    'id_komisi' => $idEdit,
                    'komisi' => $totalKomisiLevel1,
                    'jenis_komisi' => "PENJUALAN",
                    'id_member' => $getDataMember['upline_level_1'],
                    'tanggal' => date("Y-m-d"),
                  );
                $this->insertKomisi($dataKomisiMemberLevel1,$getDataMember['upline_level_1']);
              }
              $dataKomisiMember = array(
                  'id_komisi' => $idEdit,
                  'komisi' => $komisiMember,
                  'jenis_komisi' => "PENJUALAN",
                  'id_member' => $getDataTransaksi['id_member'],
                  'tanggal' => date("Y-m-d"),
                );
              $this->insertKomisi($dataKomisiMember,$getDataTransaksi['id_member']);

              $queryUpdateTransaksi = "UPDATE komisi set status = 'TERKONFIRMASI',nomor_resi='$nomorResi',keterangan = '$keteranganTransaksi', update_time = now() where id = '$idEdit'";
              sqlQuery($queryUpdateTransaksi);
              sqlQuery("UPDATE member set jumlah_barang = jumlah_barang + $jumlahProduk where id = '".$getDataTransaksi['id_member']."'");
              $subjectEmail = "Order no #".$idEdit." Pembayaran Terkonfirmasi" ;
              $bodyEmail = "
              <p>&nbsp;</p>
              <div class='container' style='text-align: center; font-family: monospace; font-size: 16px;'>
              <div class='row justify-content-center'>
              <div class='col-md-12'>
              <div class='card header_card'>
              <div class='card-body'>
              <h4 class='heading text-center'>Pembayaran order nomor #$idEdit:</h4>
              <h3 class='heading text-center'>Rp ".$this->numberFormat($getDataTransaksi['total'])."</h3>
              </div>
              </div>
              </div>
              <div class='col-md-12'>
              <div class='card card_rounded'>
              <div class='card-body text-center'>
              <h4>Sudah Terkonfirmasi</h4>
              <h5>&nbsp;</h5>
              <h5>Ke Salah Satu Rekening Dibawah ini :</h5>
              <div class='bank-box'>
              <div class='p-2 icon-bank'><img style='width: 150px;' src='https://upload.wikimedia.org/wikipedia/id/thumb/e/e0/BCA_logo.svg/472px-BCA_logo.svg.png' /></div>
              <h4><strong>6041678787</strong></h4>
              <h5>Cabang Alam Sutera</h5>
              <h5>Atas Nama Saudagar Kaya</h5>
              </div>
              <div class='option-divider-bordered'>
              <div class='row justify-content-center overlap-row'>
              <div class='pills-heading'><strong>ATAU</strong></div>
              </div>
              </div>
              <div class='bank-box'>
              <div class='p-2 icon-bank'><img style='width: 150px;' src='https://upload.wikimedia.org/wikipedia/id/thumb/f/fa/Bank_Mandiri_logo.svg/1280px-Bank_Mandiri_logo.svg.png' /></div>
              <h4><strong>1640016787873</strong></h4>
              <h5>Cabang Tangerang BFI Tower</h5>
              <h5>Atas Nama Saudagar Kaya</h5>
              </div>
              <div class='option-divider-bordered'>
              <div class='row justify-content-center overlap-row'>
              <div class='pills-heading'><strong>ATAU</strong></div>
              </div>
              </div>
              <div class='bank-box'>
              <div class='p-2 icon-bank'><img style='width: 150px;' src='https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_BRI.png' /></div>
              <h4><strong>050901001197307</strong></h4>
              <h5>Cabang BSD Menara BRI</h5>
              <h5>Atas Nama Saudagar Kaya</h5>
              </div>
              <h5 style='color: blue;'>*MOHON DIPERHATIKAN : Jika Anda melakukan transfer dari rekening bank selain 3 bank di atas, kami sarankan Anda transfernya ke akun Bank BCA kami, untuk proses verifikasi yang lebih cepat. Terima kasih.</h5>
              <br />
              <p class='card-text'>Transaksi ini bersifat <strong>non refundable / tidak bisa dikembalikan</strong> dan Setelah Anda melakukan komisi ini maka Anda telah setuju dengan semua ketentuan yang berlaku.</p>
              </div>
              </div>
              </div>
              </div>
              </div>
              ";
              $this->sendEmailKonfirmasi($getDataTransaksi['email_pembeli'],$subjectEmail,$bodyEmail);

            }else{
              $queryUpdateTransaksi = "UPDATE komisi set nomor_resi='$nomorResi',keterangan = '$keterangan', update_time = now() where id = '$idEdit'";
              sqlQuery($queryUpdateTransaksi);
            }
          }else{

          }

          // $queryUpdate = sqlUpdate('komisi', $dataUpdate,"id = '$idEdit'");
          sqlQuery($queryUpdate);
          $cek = $queryUpdateTransaksi;
        }

        return array(
            'cek' => $cek,
            'err' => $err,
            'content' => $content
        );
    }

		function insertKomisi($dataInsert,$idMember){
			$queryInsertKomisi = $this->sqlInsert("komisi",$dataInsert);
			$this->sqlQuery($queryInsertKomisi);
			// $queryUpdateKomisi = "UPDATE users set komisi = komisi + ".$dataInsert['komisi']." where id = '$idMember'";
			// sqlQuery($queryUpdateKomisi);
		}
		function sendEmailKonfirmasi($emailPenerima,$subjectEmail,$bodyEmail){
      // $subject = 'Amazon SES test (AWS SDK for PHP)';
      // $plaintext_body = 'This email was sent with Amazon SES using the AWS SDK for PHP.' ;
      // $html_body =  '<h1>AWS Amazon Simple Email Service Test Email</h1>'.
      //               '<p>This email was sent with <a href="https://aws.amazon.com/ses/">'.
      //               'Amazon SES</a> using the <a href="https://aws.amazon.com/sdk-for-php/">'.
      //               'AWS SDK for PHP</a>.</p>';
      //
      // $m = new SimpleEmailServiceMessage();
      // $m->addTo('boniw@getnada.com');
      // $m->setFrom('boniw@getnada.com');
      // $m->setSubject($subjectEmail);
      // $m->setMessageFromString($bodyEmail);
      //
      // $ses = new SimpleEmailService('AKIA4YKMZQ5RBE3KCB6U', '1fg/k8gy96DCu0c+HLKLDxE7wUYK0rGTDmVs7H+r');
      // $ses->sendEmail($m);

      $mail = new PHPMailer(true);
      $sender = 'support@akademibisnis.id';
      $senderName = 'Support';
      $usernameSmtp = 'AKIA4YKMZQ5RJHSI3LYY';
      $passwordSmtp = 'BNqKliB/Zjrz1YCqHxf4ZefVmDAfRjpKIOKLxH1luFfO';
      $host = 'email-smtp.us-west-2.amazonaws.com';
      $port = 587;
      try {
          // Specify the SMTP settings.
          $mail->isSMTP();
          $mail->setFrom($sender, $senderName);
          $mail->Username   = $usernameSmtp;
          $mail->Password   = $passwordSmtp;
          $mail->Host       = $host;
          $mail->Port       = $port;
          $mail->SMTPAuth   = true;
          $mail->SMTPSecure = 'tls';
          $mail->addCustomHeader('X-SES-CONFIGURATION-SET');

          // Specify the message recipients.
          $mail->addAddress($emailPenerima);
          // You can also add CC, BCC, and additional To recipients here.

          // Specify the content of the message.
          $mail->isHTML(true);
          $mail->Subject    = $subjectEmail;
          $mail->Body       = $bodyEmail;
          // $mail->AltBody    = $bodyText;
          $mail->Send();
          // echo "Email sent!" , PHP_EOL;
      } catch (phpmailerException $e) {
          // echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
      } catch (Exception $e) {
          // echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
      }
    }

		function Laporan(){
		 global $SensusTmp;
		 $cek = ''; $err=''; $content='';
		 $json = TRUE;	//$ErrMsg = 'tes';
		 $form_name = $this->Prefix.'_form';
		 $this->form_width = 400;//800 default
		 $this->form_height = 160;//default 160
			$this->form_caption = 'Laporan';
			$status = '1';
			$tanggalSPK = date("d-m-Y");
			$tahun = $this->tahunAnggaran;

			$arrayStatus = array(
												 array('1','AKTIF'),
												 array('2','TIDAK AKTIF'),
			);
			$arrayJenisLaporan = array(
												 array('1','DAFTAR KOMISI'),
			);
			$comboStatus = cmbArray('status',$status,$arrayStatus,'-- STATUS --',"class='form-control'") ;
		 //items ----------------------
		  $this->form_fields = array(

				'jenisLaporan' => array(
						'label'=>'JENIS LAPORAN',
						'labelWidth'=>5,
						'contentWidth'=>6,
						'value' => cmbArray('jenisLaporan',1,$arrayJenisLaporan,'-- JENIS LAPORAN --',"class='form-control form-control-sm'"),
						 ),
				// 'tanggalCetak' => array(
				// 			'label'=>'TANGGAL CETAK',
				// 			'labelWidth'=>5,
				// 			'contentWidth'=>6,
				// 			'value'=> "<input type='text' id='tanggalCetak' name='tanggalCetak' value='".$this->generateDate(date("Y-m-d"))."' class='form-control form-control-sm' >",
				// 		)
				);
			//tombol
			$this->form_menubawah =
				"
				 <input type='hidden' id='filterPeriode' name='filterPeriode' value='".$_REQUEST['filterPeriode']."' >
				".
				"<input type='button' class='btn btn-primary btn-sm' style='color:#fff;background-color: #007bff;border-color:#007bff' value='Cetak' onclick ='".$this->Prefix.".viewLaporan()' title='Cetak'>&nbsp&nbsp".
				"<input type='button' class='btn btn-danger btn-sm' style='background-color: #dc3545; border-color: #dc3545' value='Tutup' onclick ='".$this->Prefix.".Close()' >";

			$form = $this->genFormBootstrap();
			$content = $form;//$content = 'content';
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
		}
		function viewLaporan(){
			foreach ($_POST as $key => $value) {
				$$key = $value;
			}
			if($jenisLaporan == "1"){
				$this->viewDaftarKomisi();
			}
		}

		function viewDaftarKomisi(){
		 foreach ($_REQUEST as $key => $value) {
		   $$key = $value;
		 }





		 //MULAI Halaman Laporan ------------------------------------------------------------------------------------------
		 $css = $xls ? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		 $trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
		 $width = "33cm";
		 $height = "21.5cm";



		 echo
		   "<html>
		   <link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css'>
		   <link rel='stylesheet' type='text/css' href='css/pageNumber.css'>
		   <script type='text/javascript' src='assets/js/jquery-3.2.1.min.js'></script>
		   ".$trChild."
		   <script type='text/javascript' src='assets/js/bootstrap.min.js'></script>".
		     "<head>
		       <title>$Main->Judul</title>
		       $css
		       $this->Cetak_OtherHTMLHead
		       <style>
		         .ukurantulisan{
		           font-size:15px;
		         }
		         .ukurantulisan1{
		           font-size:20px;
		         }
		         .ukurantulisanIdPenerimaan{
		           font-size:16px;
		         }
		         thead { display: table-header-group; }
		       </style>
		     </head>".
		   "<body >
		     <div style='width:$this->Cetak_WIDTH_Landscape;'>
				 <table class=\"rangkacetak\" style='width: 33cm; font-family: sans-serif; height: 21.5cm;'>
					 <tr>
						 <td valign=\"top\"> <div style='text-align:center;'>
						 <table style='width: 100%; border: solid 1px; margin-bottom: 1%;'>
							 <tr>

								 <td style='text-align: center;'>
									 <span class='ukurantulisanIdPenerimaan' style='font-weight: bold;' >
										 DAFTAR KOMISI<br>
										 <span class='ukurantulisanIdPenerimaan' style='font-weight: bold;'>PERIODE  ".$_REQUEST['filterPeriode']." </span>

									 </span>
								 </td>

							 </tr>
						 </table>
		           ";
		 echo "
           <br>
             <table table width='100%' class='cetak' border='1' style='margin:2 0 0 0;width:100%;'>
	             <thead>
		             <tr>
		                 <th class='th01' style='width:1%;'  >No.</th>
										 <th class='th01' style='text-align:center;vertical-align:middle;width:7%;'>PERIODE</th>
									   <th class='th01' style='text-align:center;vertical-align:middle;width:20%;'>NAMA</th>
									   <th class='th01' style='text-align:center;vertical-align:middle;width:5%;'>EMAIL</th>
									   <th class='th01' style='text-align:center;vertical-align:middle;width:5%;'>NOMOR TELEPON</th>
									   <th class='th01' style='text-align:center;vertical-align:middle;width:5%;'>BANK</th>
									   <th class='th01' style='text-align:center;vertical-align:middle;width:5%;'>NOMOR REKENING</th>
									   <th class='th01' style='text-align:center;vertical-align:middle;width:5%;'>NAMA REKENING</th>
									   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>OMSET</th>
									   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>PROFIT</th>
									   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>REFERAL</th>
									   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>TOTAL KOMISI</th>
	               </tr>
               </thead>
		 ";

		 $arrayKondisi = $this->getDaftarOpsi();
		 $no = 1;

		 $qry ="select * from  $this->TblName ".$arrayKondisi['Kondisi']." ";
		 $aqry = $this->sqlQuery($qry);
		 while($daqry = $this->sqlArray($aqry)){
		   foreach ($daqry as $key => $value) {
		       $$key = $value;
		   }
		   if($this->nomorKolom % 2 == 1){
		     $rowClass = "row0";
		   }else{
		     $rowClass = "row1";
		   }

				 $explodeTanggal = explode("-",$periode);
			 	$Koloms[] = array(
			 			'align="center" valign="middle"',
			 			$explodeTanggal[1]."-".$explodeTanggal[0]
			 	);
			 	$getDataMember = $this->sqlArray($this->sqlQuery("select * from member where id = '$id_member'"));
			 	$Koloms[] = array(
			 			'align="left" valign="middle"',
			 			$getDataMember['nama']
			 	);
			 	$Koloms[] = array(
			 			'align="left" valign="middle"',
			 			$getDataMember['email']
			 	);
			 	$Koloms[] = array(
			 			'align="left" valign="middle"',
			 			$getDataMember['nomor_telepon']
			 	);
			 	$Koloms[] = array(
			 			'align="left" valign="middle"',
			 			$getDataMember['nama_bank']
			 	);
			 	$Koloms[] = array(
			 			'align="left" valign="middle"',
			 			$getDataMember['nomor_rekening']
			 	);
			 	$Koloms[] = array(
			 			'align="left" valign="middle"',
			 			$getDataMember['nama_rekening']
			 	);
			 	// $getDataTransaksi['status'] == 'BELUM BAYAR' || $getDataTransaksi['status'] == 'MENUNGGU KONFIRMASI' ) && $statusTransaksi == 'TERKONFIRMASI'
			 	if(!empty($filterPeriode)){
			 			$explodePeriode = explode("-",$filterPeriode);
			 			$arrKondisi[] = "year(tanggal) = '".$explodePeriode[1]."' and month(tanggal) = '".$explodePeriode[0]."'";
			 			// $getTotalPenjualan = $this->sqlArray($this->sqlQuery("select count(id) from transaksi where status not in ('BELUM BAYAR','MENUNGGU KONFIRMASI') and year(tanggal) = '".$explodePeriode[1]."' and month(tanggal) = '".$explodePeriode[0]."' and id_member = '$id_member' "));
			 			// $getDataKomisi = $this->sqlArray($this->sqlQuery("select sum(komisi) from komisi where id_member = '$id_member' and year(tanggal) = '".$explodePeriode[1]."' and month(tanggal) = '".$explodePeriode[0]."' "));

			 	}else{
			 		$arrKondisi[] = "year(tanggal) = '".date("Y")."' and month(tanggal) = '".date("m")."'";
			 		// $getTotalPenjualan = $this->sqlArray($this->sqlQuery("select count(id) from transaksi where status not in ('BELUM BAYAR','MENUNGGU KONFIRMASI') and year(tanggal) = '".date("Y")."' and month(tanggal) = '".date("m")."' "));
			 		// $getDataKomisi = $this->sqlArray($this->sqlQuery("select sum(komisi) from komisi where id_member = '$id_member' and year(tanggal) = '".date("Y")."' and month(tanggal) = '".date("m")."'  and id_member = '$id_member' "));
			 	}
			 	$Koloms[] = array(
			 			'align="right" valign="middle"',
			 			$this->numberFormat($omset_profit,0)
			 	);
			 	$Koloms[] = array(
			 			'align="right" valign="middle"',
			 			$this->numberFormat($profit,0)
			 	);
			 	$Koloms[] = array(
			 			'align="right" valign="middle"',
			 			$this->numberFormat($komisi_referal,0)
			 	);
			 	$Koloms[] = array(
			 			'align="right" valign="middle"',
			 			$this->numberFormat($profit + $komisi_referal,0)
			 	);
		    $kolomData = "
		      <tr class='$rowClass' valign='top' style='color:$colorRowBarangPertama;'>
		        	<td align='center' class='GarisCetak'>$no</td>
		          <td align='center' class='GarisCetak'>".$explodeTanggal[1]."-".$explodeTanggal[0]."</td>
		          <td align='left' class='GarisCetak'>".$getDataMember['nama']."</td>
		          <td align='left' class='GarisCetak'>".$getDataMember['email']."</td>
		          <td align='left' class='GarisCetak'>".$getDataMember['nomor_telepon']."</span></td>
		        	<td align='left' class='GarisCetak'>".$getDataMember['nama_bank']."</td>
		        	<td align='left' class='GarisCetak'>".$getDataMember['nomor_rekening']."</td>
		        	<td align='left' class='GarisCetak'>".$getDataMember['nama_rekening']."</td>
		        	<td align='right' class='GarisCetak'>".$this->numberFormat($omset_profit,0)."</td>
		        	<td align='right' class='GarisCetak'>".$this->numberFormat($profit,0)."</td>
		        	<td align='right' class='GarisCetak'>".$this->numberFormat($komisi_referal,0)."</td>
		        	<td align='right' class='GarisCetak'>".$this->numberFormat($profit + $komisi_referal,0)."</td>
		    </tr>
		    ";
				$totalOmset += $omset_profit;
				$totalProfit += $profit;
				$totalKomisiReferal += $komisi_referal;
				$totalKomisi += $profit + $komisi_referal;





		    $no += 1;
	      $this->nomorKolom  += 1;
		    echo $kolomData;
		    $kolomData= '';

		 }
		 echo        "

		   <tr class='$rowClass' valign='top'>

		   <td align='left' class='GarisCetak' colspan='8' style='text-align:right'> <b> TOTAL </td>
		   <td align='right' class='GarisCetak'><b>".$this->numberFormat($totalOmset,0)."</td>
		   <td align='right' class='GarisCetak'><b>".$this->numberFormat($totalProfit,0)."</td>
		   <td align='right' class='GarisCetak'><b>".$this->numberFormat($totalKomisiReferal,0)."</td>
		   <td align='right' class='GarisCetak'><b>".$this->numberFormat($totalKomisi,0)."</td>
		   </tr>
		   </table>";

		   echo "
		         </table>
		       </div>
		     </body>
		   </html>";

		}



}
$modulKomisi = new modulKomisiObj();
?>
