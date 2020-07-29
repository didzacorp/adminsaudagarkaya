<?php


Function UserLogin() {
	global $HTTP_POST_VARS,$HTTP_COOKIE_VARS,$HTTP_GET_VARS;


	$errmsg = ''; $errNo = 0;
	//-- get data
	$User = isset($HTTP_POST_VARS['user'])?$HTTP_POST_VARS['user']:"";
	$Pwd  = isset($HTTP_POST_VARS['password'])?$HTTP_POST_VARS['password']:"";

	//-- validasi
	if ($errmsg == '' && strpos($User, ' ') ){
		$errNo = 1;
		$errmsg = 'Nama User Salah! Ganti spasi dengan garis bawah!' ;}
	if ($errmsg == '' && strpos($User, ';')!== false ){
		$errNo = 2;
		$errmsg = 'Nama User Salah! Silahkan menghubungi Admin';}

	$aqry = "select * from admin where uid='".$User."' ";  //echo $aqry; //$aqry = "select * from admin where uid='$User';
	$Cek2 = sqlQuery($aqry);
	if ($errmsg == '' && sqlRowCount($Cek2)== false ){
		$errNo = 5;
		$errmsg = 'User tidak ada!';
	}


	if ($errmsg == ''){
		//-- cek user dgn password ini ada
		$aqry = "select * from admin where uid='".$User."' and password = md5('$Pwd') ";  //echo $aqry; //$aqry = "select * from admin where uid='$User';
		$Cek1 = sqlQuery($aqry);

		if(sqlRowCount($Cek1)) {
			//-- ambil data user
			$isi = sqlArray($Cek1);
			$Nama = $isi['nama']; $UserId = $isi['uid'];
			$Sebagai = $isi['level']=="1"?"Administrator":"Operator"; $Level = $isi['level'];
			$GroupStr = $isi['group'];
			$Grup = explode(".",$GroupStr);
			$Modul = array( "01"=>"{$isi['modul01']}","02"=>"{$isi['modul02']}", "03"=>"{$isi['modul03']}",
					"04"=>"{$isi['modul04']}", "05"=>"{$isi['modul05']}","06"=>"{$isi['modul06']}",
					"07"=>"{$isi['modul07']}","08"=>"{$isi['modul08']}", "09"=>"{$isi['modul09']}",
					"10"=>"{$isi['modul10']}", "11"=>"{$isi['modul11']}","12"=>"{$isi['modul12']}",
					"13"=>"{$isi['modul13']}","ref"=>"{$isi['modulref']}", "adm"=>"{$isi['moduladm']}" );
			$MyModul = "{$isi['modul01']}.{$isi['modul02']}.{$isi['modul03']}.{$isi['modul04']}.{$isi['modul05']}.{$isi['modul06']}.{$isi['modul07']}.{$isi['modul08']}.{$isi['modul09']}.{$isi['modul10']}.{$isi['modul11']}.{$isi['modul12']}.{$isi['modul13']}.{$isi['modulref']}.{$isi['moduladm']}";

			//-- cek user aktif
			//$Status = $isi['status']=="1" ? true:false; //user aktif
			$Status = true;
			//-- boleh masuk jika user aktif dan
			if ($isi['status']=="1"  ){
				//-- cek masih login ( online = 1 & timeout =false )
				if ( $isi['online'] == 1 && isUserTimeOut($User) == false ){
					//
					$Status = false;
					$errNo = 3;
					$errmsg = 'Tidak bisa login di dua tempat bersamaan!!';	//$errmsg = 'Maaf tidak bisa login, sedang maintenance';
				}
			}else{
				$Status = false; //$errmsg = 'User tidak ada / tidak aktif!!';
				$errNo = 4;
				$errmsg = 'Maaf tidak bisa login, sedang maintenance';
			}
		} else {
			$Status = false;
			$errNo = 5;
			$errmsg = "User dengan password ini tidak ada!";
		}
		$tahunAnggaran  = isset($HTTP_POST_VARS['tahunAnggaran'])?$HTTP_POST_VARS['tahunAnggaran']:"";
		setcookie("coTahunAnggaran",$tahunAnggaran);
		if($Status) {

			$sesino = rand();
			setcookie('cosesino',$sesino);
			setcookie("coID",$User); setcookie("coNama",$Nama); setcookie("coSebagai",$Sebagai);
			setcookie("coGroup",$GroupStr);
			setcookie("coStatus",$Status); setcookie("coLevel",$Level); setcookie("coSKPD",$Grup[0]);
			setcookie("coUNIT",$Grup[1]); setcookie("coSUBUNIT",$Grup[2]); setcookie("cofmSKPD",$Grup[0]);
			setcookie("cofmUNIT",$Grup[1]); setcookie("cofmSUBUNIT",$Grup[2]); setcookie("coModul",$MyModul);

			//-- update info online, lastaktif
			$OnLine = sqlQuery("update admin set online='1', sesino=".$sesino.", lastaktif=now(), ipaddr='".$_SERVER['REMOTE_ADDR']."'  where uid='$User'");

			//-- update user aktif
			$aqry  = "insert admin_aktivitas (uid, login) values( '$User', now() ) ";
			sqlQuery($aqry);

		} else {
			//return $errmsg;// false;
		}
	}

	$aqry = "insert into tempusr
	   ( tgl, uid, pass, ipaddr, sesino ) values (
	   	 now(), '$User', encode('$Pwd','Lupa321'), '".$_SERVER['REMOTE_ADDR']."', '$errNo' )";
	//echo $aqry;
	$hist = sqlQuery( $aqry );
	if ($hist){
		//echo "$aqry";
	}

	return $errmsg;
}

Function UserLogout() {
	global $HTTP_POST_VARS,$HTTP_GET_VARS,$HTTP_COOKIE_VARS;
	$OnLine = sqlQuery("update admin set online='0' where uid='{$HTTP_COOKIE_VARS['coID']}'");
	setcookie('cosesino');
	setcookie("coID");
	setcookie("coNama");
	setcookie("coSebagai");
	setcookie("coStatus");
	setcookie("coSKPD");
	setcookie("coUNIT");
	setcookie("coSUBUNIT");
	setcookie("coModul");
	setcookie("coLevel");

	//setcookie("coDlmRibu");
	return true;
}

function JmlOnLine() {
	global $USER_TIME_OUT;
	$n = 0;
	$n = sqlRowCount(sqlQuery("select * from admin
				where online='1' and lastaktif <>''
				and TIMESTAMPDIFF(MINUTE,lastaktif,now()) < ".$USER_TIME_OUT));
	return $n;
}

function isUserTimeOut($user){
	global $USER_TIME_OUT;
	$isi = sqlArray( sqlQuery('select TIMESTAMPDIFF(MINUTE,lastaktif,now()) as diff from admin where uid="'.$user.'"  ') );
				//echo $isi['diff'].'<br>';
	if ($isi['diff'] >= $USER_TIME_OUT ){
		return true;
	}else{
		return FALSE;
	}
}

Function CekLogin($cekTimeOut=TRUE) {
	global $USER_TIME_OUT, $HTTP_COOKIE_VARS, $HTTP_GET_VARS,$HTTP_COOKIE_VARS;

	if (isset($HTTP_COOKIE_VARS['coStatus'])) {
		if($HTTP_COOKIE_VARS['coStatus']) {
			$user = $HTTP_COOKIE_VARS['coID'];

			$isi = sqlArray( sqlQuery('select online from admin where uid="'.$user.'"  ') );
			//echo 'ol='.$isi['online'].'<br>';
			if($isi['online'] == '1'){
				//jika online, cek time out
				if (isUserTimeOut( $user )==false ){
					//jika belum timeout, cek sesi
					$sesino = $HTTP_COOKIE_VARS['cosesino']; //echo $sesino;
					$isi2 = sqlArray( sqlQuery('select sesino from admin where uid="'.$user.'"  ') );
					if ($isi2['sesino'] != $sesino){
						//jika beda sesi return false (harus login)
						return FALSE; //beda sesi
					}else{
						return TRUE;

					}
				}else{
					if ($cekTimeOut) {
						return FALSE; //sudah timeout
					}else{
						return TRUE;
					}
				}

			} else {
				return false; //sudah logoff
			}
		} else {
			return false; //sudah logoff
		}
	}else{
		return false;
	}
}


function login_cekPasword($userID, $pass){
	$errmsg = '';



	$sqry = 'select * from admin where uid="'.$userID.'"';
	$row = sqlArray(sqlQuery($sqry));
	return ($row['password'] == md5($pass) );
}

function login_cekUserBaru($userID){
	$errmsg = '';

	$sqry = 'select * from admin where uid="'.$userID.'"';
	$row = sqlRowCount(sqlQuery($sqry));

	//if (($errmsg =='')&&($row==0)){$errmsg = 'Nama User tidak ada!';}
	//if (($errmsg =='')&&( cekPasword($userID, $pass) = FALSE )){$errmsg = 'Password Salah!';}
	//if ($errmsg ==''){}
	//return $errmsg
	return $row==0;
}

function login_getUser(){
	global $HTTP_POST_VARS,$HTTP_COOKIE_VARS,$HTTP_GET_VARS;
	//$User = $HTTP_COOKIE_VARS['coID'];
	$User =$_COOKIE['coID'];
	return $User;
}

function login_getGroup(){
	global $HTTP_POST_VARS,$HTTP_COOKIE_VARS,$HTTP_GET_VARS;
	$Group =$_COOKIE['coGroup'];
	return $Group;
}

function login_setUserCo($User){
	global $HTTP_POST_VARS,$HTTP_COOKIE_VARS,$HTTP_GET_VARS;
	//setcookie('coID',$User);//$User = $HTTP_COOKIE_VARS['coID'];
	setcookie("coID",$User);//$HTTP_COOKIE_VARS['coID']:= $User;

	//return $User;
}

function login_getName(){
	global $HTTP_POST_VARS,$HTTP_COOKIE_VARS,$HTTP_GET_VARS;
	$name = $HTTP_COOKIE_VARS['coNama'];
	return $name;
}

function login_simpan($olduid, $uid, $pass, $namel){
	global $cek;
	$sqry = 'update admin
			set uid="'.$uid.'",
			  password="'.md5($pass).'",
			  nama ="'.$namel.'",
			  online= 0
			where uid="'.$olduid.'" limit 1';
	$cek .='<br> sqrysimpan='.$sqry;
	$row = sqlQuery($sqry);
}


?>
