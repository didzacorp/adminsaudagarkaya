<?php

function getSKPD($prefix='',$kol1_width=100, $styleWidth='', $setcookie_ = TRUE ) {
	global $HTTP_COOKIE_VARS;
	$cek = '';

	$PilihSKPD = "<option value='00'>--- Semua Satuan Kerja ---</option>";
    $PilihBagian = "<option value='00'>--- Semua Bagian ---</option>";
    $PilihSubBagian = "<option value='00'>--- Semua Sub Bagian ---</option>";

	$fmSKPD = $_REQUEST[$prefix.'fmBidang'];
	$fmBagian = $_REQUEST[$prefix.'fmBagian'];
	$fmSubBagian = $_REQUEST[$prefix.'fmSubBagian'];
	$semuaSatKer = $_REQUEST['semuaSatKer'];


	$coGroup = $_COOKIE['coGroup'];

	//jika kosong ambil dari set cookie
	if ($fmSKPD=='') $fmSKPD = $_COOKIE['cofmSKPD'];
	if ($fmBagian=='') $fmBagian = $_COOKIE['cofmUNIT'];
	if ($fmSubBagian=='') $fmSubBagian = $_COOKIE['cofmSUBUNIT'];

	//cek cookie hak akses
	$kondSKPD = " kode like '%.00.00%' ";
	$kondBagian = " substr(kode,1,2)='$fmSKPD' and substr(kode,4,2) <>'00' and kode like '%.00' ";
	$kondSubBagian = " substr(kode,1,2)='$fmSKPD' and substr(kode,4,2)='$fmBagian' and substr(kode,7,2) <>'00' ";
	if($_COOKIE['coSKPD'] != '00'){
		$kondSKPD = " substr(kode,1,2)='".$_COOKIE['coSKPD']."' and kode like '%.00.00%' ";
		$PilihSKPD = '';
	}
	if($_COOKIE['coUNIT'] != '00'  ){
		$PilihBagian = '';
		$kondBagian = " substr(kode,1,2)='".$_COOKIE['coSKPD']."' and substr(kode,4,2) ='".$_COOKIE['coUNIT']."' and kode like '%.00' ";
	}
	if($_COOKIE['coSUBUNIT'] != '00' ){
		$PilihSubBagian = '';
		$kondSubBagian = " substr(kode,1,2)='".$_COOKIE['coSKPD']."' and substr(kode,4,2)='".$_COOKIE['coUNIT']."' and substr(kode,7,2) ='".$_COOKIE['coSUBUNIT'] ."' ";
	}


	//list bidang ----------------------------------------
    if($semuaSatKer == 0){
		$kondSKPD = " kode = '01.00.00' ";
	}
	$aqry = "select substr(kode,1,2) as kode, nm_bagian as nama from ref_bagian where $kondSKPD order by kode ;";   $cek .= $aqry;
    $Qry = sqlQuery($aqry);
    $Ops = "";
    while ($isi = sqlArray($Qry)) {
        $sel = $fmSKPD == $isi['kode'] ? "selected" : "";
        $Ops .= "<option $sel value='{$isi['kode']}'>{$isi['kode']}. {$isi['nama']}</option>\n";
    }
	$ListSKPD =
		//$fmSKPD. ' '.
		//$aqry .
		"<select $disSKPD name='".$prefix."fmBidang' id='".$prefix."fmBidang'
			onChange=\"".$prefix.".pilihBidang()\"
			$style
		> $PilihSKPD $Ops</select>";

	//list bagian -----------------------------------------
	$aqry = "select substr(kode,4,2) as kode, nm_bagian as nama from ref_bagian where $kondBagian  order by kode ;";   $cek .= $aqry;
    $Qry = sqlQuery($aqry);
    $Ops = "";
    while ($isi = sqlArray($Qry)) {
        $sel = $fmBagian == $isi['kode'] ? "selected" : "";
        $Ops .= "<option $sel value='{$isi['kode']}'>{$isi['kode']}. {$isi['nama']}</option>\n";
    }
	$ListBagian =
		//$fmBagian. ' '.
		//$aqry .
		"<select $disSKPD name='".$prefix."fmBagian' id='".$prefix."fmBagian'
			onChange=\"".$prefix.".pilihBagian()\"
			$style
		> $PilihBagian $Ops</select>";


	//list sub bagian -------------------------------------
	$aqry = "select substr(kode,7,2) as kode, nm_bagian as nama from ref_bagian where $kondSubBagian  order by kode ;";   $cek .= $aqry;
    $Qry = sqlQuery($aqry);
    $Ops = "";
    while ($isi = sqlArray($Qry)) {
        $sel = $fmSubBagian == $isi['kode'] ? "selected" : "";
        $Ops .= "<option $sel value='{$isi['kode']}'>{$isi['kode']}. {$isi['nama']}</option>\n";
    }
	$ListSubBagian =
		//$fmSubBagian.' '.
		//$aqry .
		"<select $disSKPD name='".$prefix."fmSubBagian' id='".$prefix."fmSubBagian'
			onChange=\"".$prefix.".pilihSubBagian()\"
			$style
		> $PilihSubBagian $Ops</select>";


	if($fmSKPD == '') $fmSKPD ='00';
	if($fmBagian == '') $fmBagian ='00';
	if($fmSubBagian == '') $fmSubBagian ='00';

	if($setcookie_){
		setcookie('cofmSKPD',$fmSKPD);
		setcookie('cofmUNIT',$fmBagian);
		setcookie('cofmSUBUNIT',$fmSubBagian);
	}

	return array('Bidang'=>$ListSKPD, 'Bagian'=>$ListBagian, 'SubBagian'=>$ListSubBagian , 'cek'=>$cek);
}

function getSKPD_($prefix='',$kol1_width=100, $styleWidth='', $setcookie_ = TRUE ) {
    //global $DisAbled;
    global $fmWIL, $fmSKPD, $fmBagian, $fmSUBBagian, $fmTAHUNANGGARAN, $fmKEPEMILIKAN, $Main, $HTTP_COOKIE_VARS, $Pg, $SPg;
    //$disSKPD = ""; $disBagian = ""; $disSUBBagian = "";
    //echo "<br>Group=".login_getGroup();
	$cek = '';
    $disSKPD = $DisAbled;
    $disBagian = $DisAbled;
    $disSUBBagian = $DisAbled;

    $KondisiSKPD = "";
    $KondisiBagian = "";
    $KondisiSUBBagian = "";
    $PilihSKPD = "<option value='00'>--- Semua BIDANG ---</option>";
    $PilihBagian = "<option value='00'>--- Semua ASISTEN / OPD ---</option>";
    $PilihSUBBagian = "<option value='00'>--- Semua BIRO / UPTD/B ---</option>";

	$fmSKPD = $_REQUEST[$prefix.'fmSKPD'];
	$fmBagian = $_REQUEST[$prefix.'fmBagian'];
	$fmSUBBagian = $_REQUEST[$prefix.'fmSUBBagian'];

	$style = $styleWidth==''? '' : " style='width:$styleWidth' ";

	if ($fmSKPD != "00" && $fmSKPD!='') {
		$KondisiSKPD = " c='$fmSKPD'";
		$PilihSKPD = "";
	}else{
		$KondisiSKPD = " c<>'00'";
	}
	if ($fmBagian != "00" && $fmBagian!='') {
		$KondisiBagian = " and d='$fmBagian'";
		$PilihBagian = "";
	} else {
		$KondisiBagian = " and d<>'00'";
	}
	if ($fmSUBBagian != "00" && $fmSUBBagian!='') {
		$KondisiSUBBagian = " and e='$fmSUBBagian'";
		$PilihSUBBagian = "";
	}else{
		$KondisiSUBBagian = " and e<>'00'"; //$PilihSUBBagian = " and e<>'00' ";
	}

	if($setcookie_){
		setcookie('cofmSKPD',$fmSKPD);
		setcookie('cofmBagian',$fmBagian);
		setcookie('cofmSUBBagian',$fmSUBBagian);
	}

   //skpd ------------------------------------
    //$cekskpd = 'kon='.$KondisiSKPD;
    $aqry = "select * from ref_skpd where $KondisiSKPD and d='00'  order by c;";   $cek .= $aqry;
    $Qry = sqlQuery($aqry);
    $Ops = "";
    while ($isi = sqlArray($Qry)) {
        $sel = $fmSKPD == $isi['c'] ? "selected" : "";
        $Ops .= "<option $sel value='{$isi['c']}'>{$isi['c']}. {$isi['nm_skpd']}</option>\n";
    }
	$ListSKPD =
		$cekskpd .
		"<select $disSKPD name='".$prefix."fmSKPD' id='".$prefix."fmSKPD'
			onChange=\"".$prefix.".pilihBidang()\"
			$style
		> $PilihSKPD $Ops</select>";

	//Bagian -------------------------------------
	//$aqry = "select * from ref_skpd where c='$fmSKPD' and e = '00' $KondisiBagian order by d;";$cek .= $aqry;
	$aqry = "select * from ref_skpd where c='$fmSKPD' and d <> '00' and e='00'  order by d;";$cek .= $aqry;
    $Qry = sqlQuery($aqry);
    $Ops = "";
    while ($isi = sqlArray($Qry)) {
        $sel = $fmBagian == $isi['d'] ? "selected" : "";
        $Ops .= "<option $sel value='{$isi['d']}'>{$isi['d']}. {$isi['nm_skpd']}</option>\n";
    }
    $ListBagian =
		"<select $disBagian name='".$prefix."fmBagian' id='".$prefix."fmBagian'
			onChange=\"".$prefix.".pilihBagian()\"
			$style
		>$PilihBagian $Ops
		</select>";

	//sub Bagian ----------------------------------
	$aqry = "select * from ref_skpd where c='$fmSKPD' and d='$fmBagian' and e<>'00' order by e"; $cek .= $aqry;
    $Qry = sqlQuery($aqry);
    $Ops = "";
    while ($isi = sqlArray($Qry)) {
        $sel = $fmSUBBagian == $isi['e'] ? "selected" : "";
        $Ops .= "<option $sel value='{$isi['e']}'>{$isi['e']}. {$isi['nm_skpd']}</option>\n";
    }
    $ListSUBBagian =
		"<select $disSUBBagian name='".$prefix."fmSUBBagian' id='".$prefix."fmSUBBagian'
			onChange=\"".$prefix.".pilihSubBagian()\"
			$style
		>$PilihSUBBagian $Ops</select>";


    return array('bidang'=>$ListSKPD, 'Bagian'=>$ListBagian, 'subBagian'=>$ListSUBBagian , 'cek'=>$cek);
}



$bidang = ''; $Bagian=''; $subBagian=''; $cek = '';
$idprs = $_REQUEST['idprs'];
$prefix = $_REQUEST['nm'];
$width = $_REQUEST['width'];
$setcookie = $_REQUEST['setcookie'];
if(empty($setcookie)) $setcookie = 1;
$get=getSKPD($prefix,100,$width,$setcookie==1);
/*switch($idprs){
	case 'pilihBidang':{
		$content =
		break;
	}
}
*/
$pageArr = array(
	'Bidang'=>$get['Bidang'],
	'Bagian'=>$get['Bagian'],
	'SubBagian'=>$get['SubBagian'],
	'cek'=>$get['cek'],
);
$page = json_encode($pageArr);
echo $page;


?>
