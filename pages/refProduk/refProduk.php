<?php

class refProdukObj  extends configClass{
	var $Prefix = 'refProduk';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'produk'; //bonus
	var $TblName_Hapus = 'produk';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'refProduk';
	var $PageIcon = 'images/administrasi_ico.png';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='refProduk.xls';
	var $namaModulCetak='refProduk';
	var $Cetak_Judul = 'refProduk';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'refProdukForm';
	var $noModul=14;
	var $TampilFilterColapse = 0; //0

	function setTitle(){
		return 'PRODUK';
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

	 if (empty($namaProduk)) {
			 $err = "Isi Nama produk ";
	 } elseif (empty($deskripsiProduk)) {
			 // $err = "Isi Deskripsi";
	 } elseif (empty($hargaProduk)) {
			 $err = "Isi Harga ";
	 }

			if($fmST == 0){
				if($err==''){
						$getDataMedia = $this->sqlQuery("select * from temp_media_produk where username = '".$this->userName."'");
						$arrayMedia = array();
						while ($dataMedia = $this->sqlArray($getDataMedia)) {
							$arrayMedia[] = array(
							'sourceMedia' => $dataMedia['media'],
							'type' => $dataMedia['type'],
							);
						}
							$dataInsert = array(
								'nama_produk' => $namaProduk,
                'kategori' => $idKategori,
                'deskripsi' => base64_encode($deskripsiProduk),
                'harga' => $this->removeDot($hargaProduk),
                'profit' => $this->removeDot($profitProduk),
                'profit_premium' => $this->removeDot($profitPremiumProduk),
                'komisi' => $this->removeDot($komisiProduk),
                'media' => json_encode($arrayMedia),
                'berat' => $this->removeDot($beratProduk),
                'status' => $statusProduk,
							);
							$queryInsert = $this->sqlInsert('produk',$dataInsert);
							$cek = $queryInsert;
							$this->sqlQuery($queryInsert);
				}
			}else{
				if($err==''){
					$getDataMedia = $this->sqlQuery("select * from temp_media_produk where username = '".$this->userName."'");
					$arrayMedia = array();
					while ($dataMedia = $this->sqlArray($getDataMedia)) {
						$arrayMedia[] = array(
						'sourceMedia' => $dataMedia['media'],
						'type' => $dataMedia['type'],
						);
					}
					$dataUpdate = array(
						'nama_produk' => $namaProduk,
						'kategori' => $idKategori,
						'deskripsi' => base64_encode($deskripsiProduk),
						'harga' => $this->removeDot($hargaProduk),
						'profit' => $this->removeDot($profitProduk),
						'profit_premium' => $this->removeDot($profitPremiumProduk),
						'komisi' => $this->removeDot($komisiProduk),
						'media' => json_encode($arrayMedia),
						'berat' => $this->removeDot($beratProduk),
						'status' => $statusProduk,
					);
					$queryUpdate = $this->sqlUpdate('produk',$dataUpdate,"id = '".$idplh."'");
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
			case 'saveEditMedia': {
          if(empty($sourceMedia)){
            $err = "Isi source media ";
          }elseif(empty($typeMedia)){
            $err = "Pilih type media";
          }else{
            $dataUpdate = array(
              'media' => $sourceMedia,
              'type' => $typeMedia,
              'username' => $this->userName,
            );
            $queryUpdate = $this->sqlUpdate("temp_media_produk",$dataUpdate,"id = '$idEdit'");
            $this->sqlQuery($queryUpdate);
            $cek = $queryUpdate;
          }
          $content = array(
            'tableMedia' => $this->addMedia()
          );
          break;
      }
			case 'editMedia': {
          $content = array(
            'tableMedia' => $this->editMedia($idEdit)
          );
          break;
      }
			case 'saveNewMedia': {
          if(empty($sourceMedia)){
            $err = "Isi source media ";
          }elseif(empty($typeMedia)){
            $err = "Pilih type media";
          }else{
            $dataMedia = array(
              'media' => $sourceMedia,
              'type' => $typeMedia,
              'username' => $this->userName,
            );
            $queryInsert = $this->sqlInsert("temp_media_produk",$dataMedia);
            $this->sqlQuery($queryInsert);
            $cek = $queryInsert;
          }
          $content = array(
            'tableMedia' => $this->addMedia()
          );
          break;
      }
			case 'addMedia':{
				$content = array(
	      	'tableMedia' => $this->addMedia()
	      );
			break;
			}
			case 'batalMedia': {
					$content = array(
						'tableMedia' => $this->tempTableMedia()
					);
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
			"<script type='text/javascript' src='js/refProduk/refProduk.js' language='JavaScript' ></script>

			<link rel='stylesheet' type='text/css' href='css/modal.css'>
			<script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
			".$this->loadCalendarBootstrap()."
			".$this->loadCSSBootstrap()."

			<script type='text/javascript' src='js/quill.min.js' language='JavaScript' ></script>
			<link rel='stylesheet' href='css/quill.snow.css'>
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
   $this->sqlQuery("delete from temp_media_produk where username = '".$_COOKIE['coID']."'");
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru';
	  }else{
			$this->form_caption = 'Edit';
			$getDataEdit = $this->sqlArray($this->sqlQuery("select * from $this->TblName where id = '$dt'"));
			foreach ($getDataEdit as $key => $value) {
	 			 $$key = $value;
 		  }
      $jsonDecodeMedia = json_decode($getDataEdit['media']);
      for ($i=0; $i < sizeof($jsonDecodeMedia) ; $i++) {
        $dataTempMedia = array(
          'username' => $this->userName,
          'media' => $jsonDecodeMedia[$i]->sourceMedia,
          'type' => $jsonDecodeMedia[$i]->type,
        );
        $this->sqlQuery($this->sqlInsert("temp_media_produk",$dataTempMedia));
      }
			$deskripsiProduk = base64_decode($getDataEdit['deskripsi']);

		}

		$this->form_fields = array(
			'namaProduk' => array(
						'label'=>'NAMA PRODUK',
						'labelWidth'=>2,
						'contentWidth'=>10,
						'value'=>"<input type='text' name = 'namaProduk' id = 'namaProduk' class='form-control form-control-sm' value='$nama_produk' >",
						 ),
			'kategori' => array(
						'label'=>'KATEGORI',
						'labelWidth'=>2,
						'contentWidth'=>2,
						'value'=>cmbQuery('idKategori',$kategori,"select id ,nama_kategori from ref_kategori " ,"class='form-control form-control-sm'",'-- KATEGORI --'),
						 ),

			'harga' => array(
						'label'=>'HARGA',
						'labelWidth'=>2,
						'contentWidth'=>2,
						'value'=>  $this->numberText(array(
												'id' => 'hargaProduk',
												'params' => "style='text-align:right;'",
												'value' => $this->numberFormat($harga)
											))
						 ),
			'profit' => array(
						'label'=>'PROFIT',
						'labelWidth'=>2,
						'contentWidth'=>2,
						'value'=>  $this->numberText(array(
												'id' => 'profitProduk',
												'params' => "style='text-align:right;'",
												'value' => $this->numberFormat($profit)
											))
						 ),
			'profit_premium' => array(
						'label'=>'PROFIT PREMIUM',
						'labelWidth'=>2,
						'contentWidth'=>2,
						'value'=>  $this->numberText(array(
												'id' => 'profitPremiumProduk',
												'params' => "style='text-align:right;'",
												'value' => $this->numberFormat($profit_premium)
											))
						 ),
			'komisi' => array(
						'label'=>'KOMISI',
						'labelWidth'=>2,
						'contentWidth'=>2,
						'value'=>  $this->numberText(array(
												'id' => 'komisiProduk',
												'params' => "style='text-align:right;'",
												'value' => $this->numberFormat($komisi)
											))
						 ),
			'berat' => array(
						'label'=>'BERAT',
						'labelWidth'=>2,
						'contentWidth'=>2,
						'value'=>  $this->numberText(array(
												'id' => 'beratProduk',
												'params' => "style='text-align:right;'",
												'value' => $this->numberFormat($berat)
											))
						 ),
	 			'status' => array(
						'label'=>'STATUS',
						'labelWidth'=>2,
						'contentWidth'=>2,
						'value'=> cmbArray("statusProduk",$status,array(array("AKTIF","AKTIF"),array("TIDAK AKTIF","TIDAK AKTIF")),"-- STATUS --","class='form-control form-control-sm'"),
				 ),

				 'media' => array(
									 'contentWidth'=>12,
									 'type' => "merge",
									 'value'=>"
									 <div class='col-sm-12'  id='tableMedia'>
										".$this->tempTableMedia($id)."
									 </div>
									 "
								),
				 'deskripsi' => array(
							 'label'=>'DESKRIPSI',
							 'labelWidth'=>2,
							 'contentWidth'=>10,
							 // 'type' => 'manual',
							 'value'=>"<div id ='deskripsiProduk' class='quill-container ' >$deskripsiProduk</div>",
								),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' class='btn btn-primary btn-sm' style='color:#fff;background-color: #007bff;border-color:#007bff' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan'>&nbsp&nbsp".
			"<input type='button' class='btn btn-danger btn-sm' style='background-color: #dc3545; border-color: #dc3545' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genFormBootstrapFS();
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
		   <th class='th01' style='text-align:center;vertical-align:middle;width:70%;'>NAMA PRODUK</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>KATEGORI</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>HARGA</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>PROFIT</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>PROFIT PREMIUM</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>KOMISI</th>
		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>BERAT</th>
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
				 $nama_produk
		 );
		 $getDataKategori = $this->sqlArray($this->sqlQuery("select * from ref_kategori where id = '$kategori'"));
		 $Koloms[] = array(
				 'align="left" valign="middle"',
				 $getDataKategori['nama_kategori']
		 );
		 $Koloms[] = array(
				 'align="right" valign="middle"',
				 $this->numberFormat($harga)
		 );
		 $Koloms[] = array(
				 'align="right" valign="middle"',
				 $this->numberFormat($profit)
		 );
		 $Koloms[] = array(
				 'align="right" valign="middle"',
				 $this->numberFormat($profit_premium)
		 );
		 $Koloms[] = array(
				 'align="right" valign="middle"',
				 $this->numberFormat($komisi)
		 );
		 $Koloms[] = array(
				 'align="right" valign="middle"',
				 $this->numberFormat($berat)
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
            <label class='col-sm-2 control-label control-label-sm' style='margin-top:6px;color: black;'>NAMA PRODUK</label>
            <div class='col-sm-3'>
							<input type='text' class='form-control form-control-sm' name='filterNamaProduk' id ='filterNamaProduk'  value='$filterNamaProduk'>
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
		if(!empty($filterNamaProduk)){
				$arrKondisi[] = "nama_produk like '%$filterNamaProduk%'";
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
			case '1': $arrOrders[] = " type_refProduk $Asc1 " ;break;
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



	function tempTableMedia($idProduk){
			$cek = '';
			$err = '';
			$datanya='';
			$username = $_COOKIE['coID'];

			// if(!empty($idProduk))$kondisiProduk = " and id_produk = '$idProduk'";
			$nomor = 1;
			$getDataMedia = sqlQuery("select * from temp_media_produk where username = '".$this->userName."' $kondisiProduk");
			$no=1;
			while($dt = $this->sqlArray($getDataMedia)){
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
								<td class='GarisDaftar' style='text-align:left;valign:middle;'>$media</td>
			          <td class='GarisDaftar' style='text-align:center;valign:middle;'>$type</td>
			          <td class='GarisDaftar' style='text-align:center;valign:middle;'>
									<span id='btnOpsi4910'>
										<img id='ubah4910' src='images/administrator/images/edit_f2.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.editMedia($id)>
										<img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.hapusMedia($id)>
									</span>
								</td>

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
				         <th class='th01' style='text-align:center;vertical-align:middle;width:50%;'>SOURCE</th>
				         <th class='th01' style='text-align:center;vertical-align:middle;width:30%;'>TYPE</th>
				         <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>
								 	<span id='atasbutton'>
									 	<a href='javascript:$this->Prefix.addMedia($idProduk)' id='linkAtasButton'><img id='gambarAtasButton' src='datepicker/add-256.png' style='width:20px;height:20px;'></a>
								  </span>
								 </th>
					   </tr>

					   </thead>
						 $datanya
						 </table>
						"
			;

			return	$content;
		}

		function addMedia(){
        // if(!empty($idProduk))$kondisiProduk = " and id_produk = '$idProduk'";
        $className= "row0";
        $nomor = 1;
        $getDataMedia = sqlQuery("select * from temp_media_produk where username = '".$this->userName."' $kondisiProduk");
        while ($dataMedia = sqlArray($getDataMedia)) {
          foreach ($dataMedia as $key => $value) {
              $$key = $value;
          }
					if($no % 2 == 1){
						$rowClass = "row0";
					}else{
						$rowClass = "row1";
					}
          $listMedia.= "
          <tr class='$rowClass'>
            <td class='GarisDaftar' style='text-align:center;valign:middle;'>$nomor</td>
            <td class='GarisDaftar' style='text-align:left;valign:middle;'>$media</td>
            <td class='GarisDaftar' style='text-align:center;valign:middle;'>$type</td>
            <td class='GarisDaftar' style='text-align:center;valign:middle;'>
	            <span id='btnOpsi4910'>
							<img id='ubah4910' src='images/administrator/images/edit_f2.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.editMedia($id)>
							<img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.hapusMedia($id)>
						</span>
            </td>
          </tr>
          ";
          if($nomor % 2 == 1){
            $className = "row0";
          }else{
            $className = "row1";
          }
          $nomor+= 1;

        }
        $arrayType = array(
          array("GAMBAR","GAMBAR"),
          array("VIDEO","VIDEO"),
        );
        $comboType = cmbArray('typeMedia', $typeMedia, $arrayType, '-- TYPE --', "class='form-control form-control-sm'");
        return "
				<table class='table table-striped floatThead-table' border='1' style='border-collapse: collapse; border-width: 1px 1px 0px; border-style: outset; border-color: rgb(128, 128, 128); border-image: initial; display: table; width: 100%; margin: 0px; '><colgroup><col style='width: 33px;'><col style='width: 30px;'><col style='width: 100px;'><col style='width: 100px;'><col style='width: 400px;'><col style='width: auto;'></colgroup><thead>
	    	   <tr style='background: #1094f7;color: white;border-bottom: 2px solid #f55757;'>
						 	<th class='th01' style='text-align:center;vertical-align:middle;width:1%;'>No.</th>
							<th class='th01' style='text-align:center;vertical-align:middle;width:50%;'>SOURCE</th>
							<th class='th01' style='text-align:center;vertical-align:middle;width:30%;'>TYPE</th>
							<th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>
	            <span id='atasbutton'>
							 <a href='javascript:$this->Prefix.addMedia()' id='linkAtasButton'><img id='gambarAtasButton' src='datepicker/add-256.png' style='width:20px;height:20px;'></a>
						  </span>
	           </th>
	    	   </tr>
	        </thead>
	        <tbody>
	          ".$listMedia."
	          <tr class='$className'>
	            <td class='GarisDaftar' style='text-align:center;valign:middle;'>$nomor</td>
	            <td class='GarisDaftar' style='text-align:left;valign:middle;'><input type='text' class='form-control form-control-sm' name='sourceMedia' id='sourceMedia' ></td>
	            <td class='GarisDaftar' style='text-align:center;valign:middle;'>$comboType</td>
	            <td class='GarisDaftar' style='text-align:center;valign:middle;'>
	            <span id='btnOpsi4910'>
		            <img id='ubah4910' src='datepicker/save.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.saveNewMedia()>
		            <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.batalMedia()>
	            </span>
	            </td>
	          </tr>
	        </tbody>

        </table>

        ";
      }

			function editMedia($idEdit){
        // if(!empty($idProduk))$kondisiProduk = " and id_produk = '$idProduk'";
        $className= "row0";
        $nomor = 1;
        $getDataMedia = $this->sqlQuery("select * from temp_media_produk where username = '".$this->userName."'");
        while ($dataMedia = $this->sqlArray($getDataMedia)) {
          foreach ($dataMedia as $key => $value) {
              $$key = $value;
          }
					if($no % 2 == 1){
						$rowClass = "row0";
					}else{
						$rowClass = "row1";
					}
          if($id == $idEdit){
            $arrayType = array(
              array("GAMBAR","GAMBAR"),
              array("VIDEO","VIDEO"),
            );
            $comboType = cmbArray('typeMedia', $type, $arrayType, '-- TYPE --', "class='form-control form-control-sm'");
            $listMedia.= "
            <tr class='$rowClass'>
              <td class='GarisDaftar' style='text-align:center;valign:middle;'>$nomor</td>
              <td class='GarisDaftar' style='text-align:left;valign:middle;'><input type='text' class='form-control' name='sourceMedia' id='sourceMedia' value='$media' ></td>
              <td class='GarisDaftar' style='text-align:center;valign:middle;'>$comboType</td>
              <td class='GarisDaftar' style='text-align:center;valign:middle;'>
              <span id='btnOpsi4910'>
              <img id='ubah4910' src='datepicker/save.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.saveEditMedia($idEdit)>
              <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.batalMedia()>
              </span>
              </td>
            </tr>
            ";
          }else{
            $listMedia.= "
            <tr class='$rowClass'>
              <td class='GarisDaftar' style='text-align:center;valign:middle;'>$nomor</td>
              <td class='GarisDaftar' style='text-align:left;valign:middle;'>$media</td>
              <td class='GarisDaftar' style='text-align:center;valign:middle;'>$type</td>
              <td class='GarisDaftar' style='text-align:center;valign:middle;'>
              <span id='btnOpsi4910'>
  						<img id='ubah4910' src='images/administrator/images/edit_f2.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.editMedia($id)>
  						<img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.hapusMedia($id)>
  						</span>
              </td>
            </tr>
            ";
          }

          if($nomor % 2 == 1){
            $className = "row0";
          }else{
            $className = "row1";
          }
          $nomor+= 1;

        }

        return "
				<table class='table table-striped floatThead-table' border='1' style='border-collapse: collapse; border-width: 1px 1px 0px; border-style: outset; border-color: rgb(128, 128, 128); border-image: initial; display: table; width: 100%; margin: 0px; '><colgroup><col style='width: 33px;'><col style='width: 30px;'><col style='width: 100px;'><col style='width: 100px;'><col style='width: 400px;'><col style='width: auto;'></colgroup><thead>
    	   <tr style='background: #1094f7;color: white;border-bottom: 2px solid #f55757;'>
					 <th class='th01' style='text-align:center;vertical-align:middle;width:1%;'>No.</th>
					 <th class='th01' style='text-align:center;vertical-align:middle;width:50%;'>SOURCE</th>
					 <th class='th01' style='text-align:center;vertical-align:middle;width:30%;'>TYPE</th>
    		   <th class='th01' style='text-align:center;vertical-align:middle;width:10%;'>
            <span id='atasbutton'>
						 <a href='javascript:$this->Prefix.addMedia()' id='linkAtasButton'><img id='gambarAtasButton' src='datepicker/add-256.png' style='width:20px;height:20px;'></a>
					  </span>
           </th>
    	   </tr>
        </thead>
        <tbody>
          ".$listMedia."

        </tbody>

        </table>

        ";
      }



}
$refProduk = new refProdukObj();
?>
