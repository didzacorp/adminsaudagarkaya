<?php

class refFunnelObj  extends configClass{
	var $Prefix = 'refFunnel';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'funnel'; //bonus
	var $TblName_Hapus = 'funnel';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'refFunnel';
	var $PageIcon = 'images/administrasi_ico.png';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='refFunnel.xls';
	var $namaModulCetak='refFunnel';
	var $Cetak_Judul = 'refFunnel';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'refFunnelForm';
	var $noModul=14;
	var $TampilFilterColapse = 0; //0

	function setTitle(){
		return 'FUNNEL / LANDING PAGE';
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

	 if (empty($namaFunnel)) {
			 $err = "Isi Nama Funnel";
	 } elseif (empty($linkFunnel)) {
			 $err = "Isi Link";
	 } elseif (empty($statusFunnel)) {
			 $err = "Pilih Funnel";
	 }

			if($fmST == 0){
				if($err==''){
							$dataInsert = array(
								'nama_funnel' => $namaFunnel,
                'link' => $linkFunnel,
                'status' => $statusFunnel,
							);
							$queryInsert = $this->sqlInsert('funnel',$dataInsert);
							$cek = $queryInsert;
							$this->sqlQuery($queryInsert);
				}
			}else{
				if($err==''){
					$dataUpdate = array(
						'nama_funnel' => $namaFunnel,
						'link' => $linkFunnel,
						'status' => $statusFunnel,
					);
					$queryUpdate = $this->sqlUpdate('funnel',$dataUpdate,"id = '".$idplh."'");
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
			"<script type='text/javascript' src='js/refFunnel/refFunnel.js' language='JavaScript' ></script>

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
	 $this->form_height = 240;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru';
	  }else{
			$this->form_caption = 'Edit';
			$getData = $this->sqlArray($this->sqlQuery("select * from $this->TblName where id = '$dt'"));
			foreach ($getData as $key => $value) {
	 			 $$key = $value;
	 		 }

		}

		$this->form_fields = array(
			'namaMember' => array(
						'label'=>'NAMA FUNNEL',
						'labelWidth'=>4,
						'contentWidth'=>8,
						'value'=>"<input type='text' name = 'namaFunnel' id = 'namaFunnel' class='form-control form-control-sm' value='$nama_funnel' >",
						 ),
			'emailMember' => array(
						'label'=>'LINK',
						'labelWidth'=>4,
						'contentWidth'=>8,
						'value'=>"<input type='text' name = 'linkFunnel' id = 'linkFunnel'  class='form-control form-control-sm' value='$link' >",
						 ),
	 			'status' => array(
						'label'=>'STATUS',
						'labelWidth'=>4,
						'contentWidth'=>8,
						'value'=> cmbArray("statusFunnel",$status,array(array("AKTIF","AKTIF"),array("TIDAK AKTIF","TIDAK AKTIF")),"-- STATUS --","class='form-control form-control-sm'"),
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

	function bayarKomisi($idrefFunnel){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 175;

			$this->form_caption = 'PEMBAYARAN KOMISI';
			$getData = $this->sqlArray($this->sqlQuery("select * from refFunnel where id = '$idrefFunnel'"));
			foreach ($getData as $key => $value) {
	 			 $$key = $value;
	 		 }
			 $jenisrefFunnel = $type_refFunnel;
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
			"<input type='button' class='btn btn-success' value='Simpan' onclick ='".$this->Prefix.".savePembayaranKomisi($idrefFunnel)' title='Simpan'>&nbsp&nbsp".
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
			$listEmail = implode(';',$_REQUEST['refFunnel_cb']);

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
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".sendBroadCast($idrefFunnel)' title='Simpan'>&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm2();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function addTestimoni($idrefFunnel){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 175;

			$this->form_caption = 'ADD TESTIMONI';
			$getData = $this->sqlArray($this->sqlQuery("select * from refFunnel where id = '$idrefFunnel'"));
			foreach ($getData as $key => $value) {
	 			 $$key = $value;
	 		 }
			 $jenisrefFunnel = $type_refFunnel;
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
			"<input type='button' value='Simpan' class='btn btn-success' onclick ='".$this->Prefix.".saveTestimoni($idrefFunnel)' title='Simpan'>&nbsp&nbsp".
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
		   <th class='th01' style='text-align:center;vertical-align:middle;width:70%;'>NAMA FUNNEL</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>LINK</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>TRAFIC</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>STATUS</th>
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
				 $nama_funnel
		 );
		 $Koloms[] = array(
				 'align="left" valign="middle"',
				 $link
		 );
		 $Koloms[] = array(
				 'align="right" valign="middle"',
				 $this->numberFormat($jumlah_trafic)
		 );
		 $Koloms[] = array(
				 'align="center" valign="middle"',
				 $status
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
            <label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>NAMA FUNNEL</label>
            <div class='col-sm-3'>
							<input type='text' class='form-control form-control-sm' name='filterNamaFunnel' id ='filterNamaFunnel'  value='$filterNamaFunnel'>
						</div>
          </div>
          <div class='row' style='margin-top:5px !important;'>
            <label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>LINK</label>
            <div class='col-sm-3'>
							<input type='text' class='form-control form-control-sm' name='filterLink' id ='filterLink'  value='$filterLink'>
						</div>
          </div>

          <div class='row' style='margin-top:5px !important;'>
            <label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>STATUS</label>
            <div class='col-sm-2'>
							".cmbArray('filterStatus',$filterStatus,array(array("AKTIF","AKTIF"),array("TIDAK AKTIF","TIDAK AKTIF")),'-- STATUS --',"class='form-control form-control-sm'")."
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
		if(!empty($filterNamaFunnel)){
				$arrKondisi[] = "nama_funnel like '%$filterNamaFunnel%'";
		}
		if(!empty($filterLink)){
				$arrKondisi[] = "link like '%$filterLink%'";
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
		switch($filterUrut){
			case '1': $arrOrders[] = " type_refFunnel $Asc1 " ;break;
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

	 $getDataMember = $this->sqlArray($this->sqlQuery("select * from funnel where id = '$idMember'"));



			$this->form_fields = array(

			 'namaMember' => array(
						 'label'=>'NAMA FUNNEL / LANDING PAGE',
						 'labelWidth'=>3,
						 'contentWidth'=>9,
						 'value'=>"<input type='text' name = 'namaMember' id = 'namaMember'class='form-control form-control-sm' readonly value='".$getDataMember['nama']."' >",
			),
			 'emailMember' => array(
						 'label'=>'EMAIl FUNNEL / LANDING PAGE',
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

			$getDataMember = sqlQuery("select * from funnel where upline_level_1 = '".$idMember."' ");
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
$refFunnel = new refFunnelObj();
?>
