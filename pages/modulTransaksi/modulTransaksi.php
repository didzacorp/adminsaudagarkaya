<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
class modulTransaksiObj  extends configClass{
	var $Prefix = 'modulTransaksi';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'transaksi'; //bonus
	var $TblName_Hapus = 'transaksi';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'modulTransaksi';
	var $PageIcon = 'images/administrasi_ico.png';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='modulTransaksi.xls';
	var $namaModulCetak='modulTransaksi';
	var $Cetak_Judul = 'modulTransaksi';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'modulTransaksiForm';
	var $noModul=14;
	var $TampilFilterColapse = 0; //0

	function setTitle(){
		return 'TRANSAKSI';
	}
	function filterSaldoMiring(){
		return "";
	}
	function setMenuEdit(){
		return "

						<li class='nav-item' style='margin-right: 10px;margin-left: 10px;'>
	    				<a class='toolbar' id='' href='javascript:$this->Prefix.Konfirmasi()' title='Konfirmasi'>
	    					<img src='images/administrator/images/edit_f2.png' alt='button' name='save' width='22' height='22' border='0' align='middle'>
	    					Konfirmasi
	    				</a>
            </li>
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
			  if ($this->sqlNumRow($this->sqlQuery("select * from transaksi where email='$emailMember'")) !=0) {
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
							$queryInsert = $this->sqlInsert('transaksi',$dataInsert);
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
					$queryUpdate = $this->sqlUpdate('transaksi',$dataUpdate,"id = '".$idplh."'");
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
				$fm = $this->Konfirmasi($modulTransaksi_cb[0]);
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
			"<script type='text/javascript' src='js/modulTransaksi/modulTransaksi.js' language='JavaScript' ></script>

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
						'label'=>'NAMA TRANSAKSI',
						'labelWidth'=>4,
						'contentWidth'=>8,
						'value'=>"<input type='text' name = 'namaMember' id = 'namaMember' class='form-control form-control-sm' value='$nama' >",
						 ),
			'emailMember' => array(
						'label'=>'EMAIL TRANSAKSI',
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

	function bayarKomisi($idmodulTransaksi){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 175;

			$this->form_caption = 'PEMBAYARAN KOMISI';
			$getData = $this->sqlArray($this->sqlQuery("select * from modulTransaksi where id = '$idmodulTransaksi'"));
			foreach ($getData as $key => $value) {
	 			 $$key = $value;
	 		 }
			 $jenismodulTransaksi = $type_modulTransaksi;
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
			"<input type='button' class='btn btn-success' value='Simpan' onclick ='".$this->Prefix.".savePembayaranKomisi($idmodulTransaksi)' title='Simpan'>&nbsp&nbsp".
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
			$listEmail = implode(';',$_REQUEST['modulTransaksi_cb']);

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
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".sendBroadCast($idmodulTransaksi)' title='Simpan'>&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm2();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function addTestimoni($idmodulTransaksi){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 175;

			$this->form_caption = 'ADD TESTIMONI';
			$getData = $this->sqlArray($this->sqlQuery("select * from modulTransaksi where id = '$idmodulTransaksi'"));
			foreach ($getData as $key => $value) {
	 			 $$key = $value;
	 		 }
			 $jenismodulTransaksi = $type_modulTransaksi;
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
			"<input type='button' value='Simpan' class='btn btn-success' onclick ='".$this->Prefix.".saveTestimoni($idmodulTransaksi)' title='Simpan'>&nbsp&nbsp".
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
  	   <th class='th01' width='5' style='text-align:center;vertical-align:middle;' colspan='1' rowspan='2'>No.</th>
		 	".str_replace(">"," colspan='1' rowspan = '2' style='text-align:center;vertical-align:middle;'>",$Checkbox)."
		   <th class='th01' style='text-align:center;vertical-align:middle;width:7%;' colspan='1' rowspan='2' >TANGGAL</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:15%;' colspan='1' rowspan='2' >MEMBER</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:5%;' colspan='1' rowspan='2' >JENIS TRANSAKSI</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:20%;' colspan='4' rowspan='1' >PENJUALAN</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;' colspan='2' rowspan='1' >PENGIRIMAN</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;' colspan='1' rowspan='2' >SUB TOTAL</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:7%;'  colspan='1' rowspan='2' >KODE UNIK</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;' colspan='1' rowspan='2' >TOTAL</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:1%;'  colspan='1' rowspan='2'>STATUS</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;' colspan='1' rowspan='2'>KETERANGAN</th>
	   </tr>
		 <tr  >
			 <th class='th01'  width='100' colspan='1' rowspan='1' style='text-align:center;vertical-align:middle;'>NAMA</th>
			 <th class='th01'  width='100' colspan='1' rowspan='1' style='text-align:center;vertical-align:middle;'>ALAMAT</th>
			 <th class='th01'  width='100' colspan='1' rowspan='1' style='text-align:center;vertical-align:middle;'>EMAIL</th>
			 <th class='th01'  width='100' colspan='1' rowspan='1' style='text-align:center;vertical-align:middle;'>TELEPON</th>
			 <th class='th01'  width='100' colspan='1' rowspan='1' style='text-align:center;vertical-align:middle;'>SERVICE</th>
			 <th class='th01'  width='100' colspan='1' rowspan='1' style='text-align:center;vertical-align:middle;'>ONGKIR</th>
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
					'align="center" valign="middle"',
					$this->generateDate($tanggal)
			);
			$getDataMember = $this->sqlArray($this->sqlQuery("select * from member where id = '$id_member'"));
			$Koloms[] = array(
					'align="left" valign="middle"',
					$getDataMember['nama']
			);
			$Koloms[] = array(
					'align="left" valign="middle"',
					$jenis_transaksi
			);
			$Koloms[] = array(
					'align="left" valign="middle"',
					$nama_pembeli
			);
			if($jenis_transaksi == 'PENJUALAN'){
				$alamat = $alamat_pengiriman." ,".$kecamatan_pengiriman." ,".$kota_pengiriman." ,".$provinsi_pengiriman." ".$kode_pos_pengiriman;
			}
			$Koloms[] = array(
					'align="left" valign="middle"',
					$alamat
			);
			$Koloms[] = array(
					'align="left" valign="middle"',
					$email_pembeli
			);
			$Koloms[] = array(
					'align="left" valign="middle"',
					$nomor_telepon
			);
			$Koloms[] = array(
					'align="left" valign="middle"',
					$service_pengiriman
			);
			$Koloms[] = array(
					'align="right" valign="middle"',
					$this->numberFormat($ongkir,0)
			);
			$Koloms[] = array(
					'align="right" valign="middle"',
					$this->numberFormat($sub_total ,0)
			);
			$Koloms[] = array(
					'align="right" valign="middle"',
					$this->numberFormat($kode_unik,0)
			);
			$Koloms[] = array(
					'align="right" valign="middle"',
					$this->numberFormat($total,0)
			);
			$Koloms[] = array(
					'align="left" valign="middle"',
					$status
			);
			$Koloms[] = array(
					'align="left" valign="middle"',
					$keterangan
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
		$TampilOpt = "
			<div class='form-group'>
				<div class='row' style='margin-top:5px !important;'>
					<label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>TANGGAL</label>
					<div class='col-sm-3'>
						<input type='text' class='form-control form-control-sm' name='filterTanggal' id ='filterTanggal'  value='$filterTanggal'>
					</div>
				</div>
				<div class='row' style='margin-top:5px !important;'>
					<label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>NOMOR TRANSAKSI</label>
					<div class='col-sm-1'>
						<input type='text' class='form-control form-control-sm'  name='filterIdTransaksi' id ='filterIdTransaksi'  value='$filterIdTransaksi' >
					</div>
				</div>
				<div class='row' style='margin-top:5px !important;'>
					<label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>NAMA PEMBELI</label>
					<div class='col-sm-4'>
						<input type='text' class='form-control form-control-sm' name='filterNamaPembeli' id ='filterNamaPembeli'  value='$filterNamaPembeli'>
					</div>
				</div>
				<div class='row' style='margin-top:5px !important;'>
					<label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>NAMA MEMBER</label>
					<div class='col-sm-4'>
						<input type='text' class='form-control form-control-sm' name='filterNamaMember' id ='filterNamaMember'  value='$filterNamaMember'>
					</div>
				</div>
				<div class='row' style='margin-top:5px !important;'>
					<label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>NOMOR RESI</label>
					<div class='col-sm-4'>
						<input type='text' class='form-control form-control-sm' name='filterNomorResi' id ='filterNomorResi'  value='$filterNomorResi'>
					</div>
				</div>
				<div class='row' style='margin-top:5px !important;'>
					<label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>STATUS</label>
					<div class='col-sm-2'>
						".cmbArray("filterStatus",$filterStatus,$arrayStatus,"-- STATUS --","class='form-control form-control-sm'")."
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
		if(!empty($filterTanggal)){
				$arrKondisi[] = "tanggal = '".$this->generateDate($filterTanggal)."'";
		}
		if(!empty($filterIdTransaksi)){
				$arrKondisi[] = "id = '$filterIdTransaksi'";
		}
		if(!empty($filterNamaPembeli)){
				$arrKondisi[] = "nama_pembeli like '%$filterNamaPembeli%'";
		}
		if(!empty($filterNomorResi)){
				$arrKondisi[] = "nomor_resi like '%$filterNomorResi%'";
		}
		if(!empty($filterNamaMember)){
				$arrKondisi[] = "id_member in (select id from member where nama like '%$filterNamaMember%') ";
		}
		if(!empty($filterStatus)){
				$arrKondisi[] = "status = '$filterStatus'";
		}
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
    $arrOrders[] = " id desc ";

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
   $this->form_caption = 'TRANSAKSI';

	 $getDataTransaksi = $this->sqlArray($this->sqlQuery("select * from transaksi where id = '$idTransaksi'"));
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
						 'label'=>'TANGGAL TRANSAKSI',
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

			$getDataDetailTransaksi = sqlQuery("select * from detail_transaksi where id_transaksi = '$idTransaksi'");
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
          $getDataTransaksi = $this->sqlArray($this->sqlQuery("select * from transaksi where id='$idEdit'"));
          $getDataMember = $this->sqlArray($this->sqlQuery("select * from member where id ='".$getDataTransaksi['id_member']."'"));

          if($getDataTransaksi['jenis_transaksi'] == 'PENJUALAN'){
            if(($getDataTransaksi['status'] == 'BELUM BAYAR' || $getDataTransaksi['status'] == 'MENUNGGU KONFIRMASI' ) && $statusTransaksi == 'TERKONFIRMASI'){
              $getDetailTransaksi = sqlQuery("select * from detail_transaksi where id_transaksi ='$idEdit'");
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
                    'id_transaksi' => $idEdit,
                    'komisi' => $totalKomisiLevel1,
                    'jenis_komisi' => "PENJUALAN",
                    'id_member' => $getDataMember['upline_level_1'],
                    'tanggal' => date("Y-m-d"),
                  );
                $this->insertKomisi($dataKomisiMemberLevel1,$getDataMember['upline_level_1']);
              }
              $dataKomisiMember = array(
                  'id_transaksi' => $idEdit,
                  'komisi' => $komisiMember,
                  'jenis_komisi' => "PROFIT",
                  'id_member' => $getDataTransaksi['id_member'],
                  'tanggal' => date("Y-m-d"),
                );
              $this->insertKomisi($dataKomisiMember,$getDataTransaksi['id_member']);

              $queryUpdateTransaksi = "UPDATE transaksi set status = 'TERKONFIRMASI',nomor_resi='$nomorResi',keterangan = '$keteranganTransaksi', update_time = now() where id = '$idEdit'";
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
              <h4><strong>437.128.5843</strong></h4>
              <h5>Atas Nama Andy Sudaryanto</h5>
              </div>
              <div class='option-divider-bordered'>
              <div class='row justify-content-center overlap-row'>
              <div class='pills-heading'><strong>ATAU</strong></div>
              </div>
              </div>
              <div class='bank-box'>
              <div class='p-2 icon-bank'><img style='width: 150px;' src='https://upload.wikimedia.org/wikipedia/id/thumb/f/fa/Bank_Mandiri_logo.svg/1280px-Bank_Mandiri_logo.svg.png' /></div>
              <h4><strong>131.001.363.9408</strong></h4>
              <h5>Atas Nama Andy Sudaryanto</h5>
              </div>
              <div class='option-divider-bordered'>
              <div class='row justify-content-center overlap-row'>
              <div class='pills-heading'><strong>ATAU</strong></div>
              </div>
              </div>
              <div class='bank-box'>
              <div class='p-2 icon-bank'><img style='width: 150px;' src='https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_BRI.png' /></div>
              <h4><strong>763.701.002.274.508</strong></h4>
              <h5>Atas Nama Andy Sudaryanto</h5>
              </div>
              <h5 style='color: blue;'>*MOHON DIPERHATIKAN : Jika Anda melakukan transfer dari rekening bank selain 3 bank di atas, kami sarankan Anda transfernya ke akun Bank BCA kami, untuk proses verifikasi yang lebih cepat. Terima kasih.</h5>
              <br />
              <p class='card-text'>Transaksi ini bersifat <strong>non refundable / tidak bisa dikembalikan</strong> dan Setelah Anda melakukan transaksi ini maka Anda telah setuju dengan semua ketentuan yang berlaku.</p>
              </div>
              </div>
              </div>
              </div>
              </div>
              ";
              $this->sendEmailKonfirmasi($getDataTransaksi['email_pembeli'],$subjectEmail,$bodyEmail);

							if($getDataMember['lisensi'] == 'FREE'){
								$getDataMember = $this->sqlArray($this->sqlQuery("select * from member where id = '".$getDataMember['id']."'"));
								if($jumlahProduk >= 7){
									$this->sqlQuery("UPDATE member set lisensi ='PREMIUM' where id = '".$getDataMember['id']."'");
								}elseif($getDataMember['jumlah_barang'] >= 12){
									$this->sqlQuery("UPDATE member set lisensi ='PREMIUM' where id = '".$getDataMember['id']."'");
								}
							}
            }else{
              $queryUpdateTransaksi = "UPDATE transaksi set nomor_resi='$nomorResi',keterangan = '$keterangan', update_time = now() where id = '$idEdit'";
              sqlQuery($queryUpdateTransaksi);
            }
          }else{

          }

          // $queryUpdate = sqlUpdate('transaksi', $dataUpdate,"id = '$idEdit'");
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

			// $emailPenerima = "support@saudagarkaya.com";
			//komen
      $mail = new PHPMailer(true);
      $sender = 'support@saudagarkaya.com';
      $senderName = 'Support';
      $usernameSmtp = 'AKIAQBXG7F42UTEVWIJW';
      $passwordSmtp = 'BIcZplisnAwqjmJ0n2tmU9+0E6n0FPZcAshEhYeoZ2c5';
      $host = 'email-smtp.ap-southeast-2.amazonaws.com';
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
												 array('1','INVOICE'),
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

			$arrayIdTransaksi = $_REQUEST['modulTransaksi_cb'];
			$idTransaksi = $arrayIdTransaksi[0];
			$this->form_menubawah =
				"
				 <input type='hidden' id='idTransaksi' name='idTransaksi' value='$idTransaksi' >
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
				$this->viewInvoice();
			}
		}
		function viewInvoice(){
			foreach ($_POST as $key => $value) {
       	  $$key = $value;
         }
         $style = "<style>
             body {
                 font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
                 text-align: center;
                 color: #777;
             }

             body h1 {
                 font-weight: 300;
                 margin-bottom: 0px;
                 padding-bottom: 0px;
                 color: #000;
             }

             body h3 {
                 font-weight: 300;
                 margin-top: 10px;
                 margin-bottom: 20px;
                 font-style: italic;
                 color: #555;
             }

             body a {
                 color: #06F;
             }

             .invoice-box {
                 max-width: 800px;
                 margin: auto;
                 padding: 30px;
                 border: 1px solid #eee;
                 box-shadow: 0 0 10px rgba(0, 0, 0, .15);
                 font-size: 16px;
                 line-height: 24px;
                 font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
                 color: #555;
             }

             .invoice-box table {
                 width: 100%;
                 line-height: inherit;
                 text-align: left;
             }

             .invoice-box table td {
                 padding: 5px;
                 vertical-align: top;
             }

             .invoice-box table tr td:nth-child(2) {
                 text-align: right;
             }

             .invoice-box table tr.top table td {
                 padding-bottom: 20px;
             }

             .invoice-box table tr.top table td.title {
                 font-size: 45px;
                 line-height: 45px;
                 color: #333;
             }

             .invoice-box table tr.information table td {
                 padding-bottom: 40px;
             }

             .invoice-box table tr.heading td {
                 background: #eee;
                 border-bottom: 1px solid #ddd;
                 font-weight: bold;
             }

             .invoice-box table tr.details td {
                 padding-bottom: 20px;
             }

             .invoice-box table tr.item td {
                 border-bottom: 1px solid #eee;
             }

             .invoice-box table tr.item.last td {
                 border-bottom: none;
             }

             .invoice-box table tr.total td:nth-child(2) {
                 border-top: 2px solid #eee;
                 font-weight: bold;
             }

             @media only screen and (max-width: 600px) {
                 .invoice-box table tr.top table td {
                     width: 100%;
                     display: block;
                     text-align: center;
                 }
                 .invoice-box table tr.information table td {
                     width: 100%;
                     display: block;
                     text-align: center;
                 }
             }
         </style>";

         $getDataTransaksi = $this->sqlArray($this->sqlQuery("select * from transaksi where id ='$idTransaksi'"));
         $getDataDetailTransaksi  = $this->sqlQuery("select * from detail_transaksi where id_transaksi = '$idTransaksi'");
         $no = 1;
         while ($dataDetailTransaksi = $this->sqlArray($getDataDetailTransaksi)) {
           $getDataProduk = $this->sqlArray($this->sqlQuery("select * from produk where id = '".$dataDetailTransaksi['id_produk']."'"));
           $rowDetailPenjualan .= "
           <tr class='item'>
               <td style='text-align:right;'>
                 $no
               </td>
               <td style='text-align:left;'>
                   ".$getDataProduk['nama_produk']."
               </td>

               <td style='text-align:right;'>
                   ".$this->numberFormat($dataDetailTransaksi['harga'])."
               </td>
               <td style='text-align:right;'>
                   ".$this->numberFormat($dataDetailTransaksi['jumlah'])."
               </td>
               <td style='text-align:right;'>
                  ".$this->numberFormat($dataDetailTransaksi['total'] )."
               </td>
           </tr>

           ";
           $subTotal += $dataDetailTransaksi['total'];
           $no += 1;
         }

         $rowShipment = "
         <tr class='total'>
             <td colspan='4' style='text-align:right;'>Shipment :</td>
             <td>
                  ".$this->numberFormat($getDataTransaksi['ongkir'])."
             </td>
         </tr>

         ";
         // $kodeUnik = $getDataTransaksi['total'] - ( $getDataTransaksi['ongkir'] +  $subTotal);
         $kodeUnik = $getDataTransaksi['kode_unik'];
         echo "

         $style
         <title> INVOICE </title>
         <div class='invoice-box'>
             <table cellpadding='0' cellspacing='0'>
                 <tbody>
                     <tr class='top'>
                         <td colspan='6'>
                             <table>
                                 <tbody>
                                     <tr>
                                         <td class='title'>
                                             <img src='assets/img/logo.png' style='width:100%; max-width:300px;'>
                                         </td>

                                         <td>
                                             Order Nomor #: $idTransaksi
                                             <br> Tanggal : ".$this->generateDate($getDataTransaksi['tanggal'])."
                                             <br> Pengiriman : ".$getDataTransaksi['service_pengiriman']."
                                         </td>
                                     </tr>
                                 </tbody>
                             </table>
                         </td>
                     </tr>

                     <tr class='information'>
                         <td colspan='6'>
                             <table>
                                 <tbody>
                                     <tr>
                                         <td>
                                             ".$getDataTransaksi['alamat_pengiriman']."
                                             <br> ".$getDataTransaksi['kecamatan_pengiriman']."
                                             <br> ".$getDataTransaksi['kota_pengiriman'].", ".$getDataTransaksi['provinsi_pengiriman']." ".$getDataTransaksi['kode_pos_pengiriman']."
                                         </td>

                                         <td>
                                             ".$getDataTransaksi['nama_pembeli'].".
                                             <br> ".$getDataTransaksi['nomor_telepon']."
                                         </td>
                                     </tr>
                                 </tbody>
                             </table>
                         </td>
                     </tr>
                     <tr class='heading' >
                         <td style='width:2%;text-align:center'>
                             No.
                         </td>
                         <td  style='width:40%;text-align:center'>
                             Produk
                         </td>
                         <td  style='width:15%;text-align:center'>
                             Harga
                         </td>
                         <td  style='width:10%;text-align:center'>
                             Jumlah
                         </td>
                         <td  style='width:20%;text-align:center'>
                             Total
                         </td>
                     </tr>
                     $rowDetailPenjualan
                     <tr class='total'>
                         <td colspan='4' style='text-align:right;'>Sub Total :</td>
                         <td>
                              ".$this->numberFormat($subTotal)."
                         </td>
                     </tr>
                     $rowShipment
                     <tr class='total'>
                         <td colspan='4' style='text-align:right;'>Kode Unik :</td>
                         <td>
                              ".$this->numberFormat($kodeUnik)."
                         </td>
                     </tr>
                     <tr class='total'>
                         <td colspan='4' style='text-align:right;'>Total :</td>
                         <td>
                              ".$this->numberFormat($getDataTransaksi['total'])."
                         </td>
                     </tr>
                 </tbody>
             </table>
         </div>
         ";

		}



}
$modulTransaksi = new modulTransaksiObj();
?>
