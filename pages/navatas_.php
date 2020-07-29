<?php

/*
2010.09.17:
 	- menu nav atas hanya untuk penatausahaan (pg=05)

*/
$Main->NavAtas = '';

if ($Pg=='05'){
	$notnavatas = $_REQUEST['notnavatas'];
	$tipebi = $_REQUEST['tipebi'];
	if (empty($notnavatas)){
		
		/*switch($tipebi){
			case 'pilih':{
				$Main->NavAtas = 
					"<!--menubar_page-->
					<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
					<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
				
					<A href=\"?Pg=$Pg&SPg=03&tipebi=pilih\" title='Buku Inventaris' >BI</a> |
					<A href=\"?Pg=$Pg&SPg=04&tipebi=pilih\" title='Tanah' >KIB A</a>  |  
					<A href=\"?Pg=$Pg&SPg=05&tipebi=pilih\" title='Peralatan & Mesin'>KIB B</a>  |  
					<A href=\"?Pg=$Pg&SPg=06&tipebi=pilih\" title='Gedung & Bangunan'>KIB C</a>  |  
					<A href=\"?Pg=$Pg&SPg=07&tipebi=pilih\" title='Jalan, Irigasi & Jaringan'>KIB D</a>  |  
					<A href=\"?Pg=$Pg&SPg=08&tipebi=pilih\" title='Aset Tetap Lainnya'>KIB E</a>  |  
					<A href=\"?Pg=$Pg&SPg=09&tipebi=pilih\" title='Konstruksi Dalam Pengerjaan'>KIB F</a>  					
					  &nbsp&nbsp&nbsp
					</td></tr></table>";
				break;
			}
			default:{*/
				//$SPg = $_REQUEST['$SPg']; ECHO 	$SPg;
				switch($SPg){
					case '03' : $styleMenu0 = " style='color:blue;' "; break;
					case '04' : $styleMenu1 = " style='color:blue;' "; break;
					case '05' : $styleMenu2 = " style='color:blue;' "; break;
					case '06' : $styleMenu3 = " style='color:blue;' "; break;
					case '07' : $styleMenu4 = " style='color:blue;' "; break;
					case '08' : $styleMenu5 = " style='color:blue;' "; break;
					case '09' : $styleMenu6 = " style='color:blue;' "; break;
					case '11' : $styleMenu7 = " style='color:blue;' "; break;
					case '12' : $styleMenu9 = " style='color:blue;' "; break;
					case '13' : $styleMenu10 = " style='color:blue;' "; break;
					case 'KIR' : $styleMenu12 = " style='color:blue;' "; break;
					case 'KIP' : $styleMenu13 = " style='color:blue;' "; break;
				}
				
				if($Pg=='05' && ($SPg=='belumsensus'  || $SPg=='KIR' || $SPg=='KIP' )) $styleMenu11 =" style='color:blue;' ";
				//$Pg = $_REQUEST['Pg'];
				/*switch($Pg){
					case 'sensus' : $styleMenu10 = " style='color:blue;' "; break;
					//default: $styleMenu0 = " style='color:blue;' "; break;
				}*/
				$Main->NavAtas = 
					"<!--menubar_page-->
					<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
					<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
				
					<A href=\"index.php?Pg=$Pg&SPg=03\" title='Buku Inventaris' $styleMenu0>BI</a> |
					<A href=\"index.php?Pg=$Pg&SPg=04\" title='Tanah' $styleMenu1>KIB A</a>  |  
					<A href=\"index.php?Pg=$Pg&SPg=05\" title='Peralatan & Mesin' $styleMenu2>KIB B</a>  |  
					<A href=\"index.php?Pg=$Pg&SPg=06\" title='Gedung & Bangunan' $styleMenu3>KIB C</a>  |  
					<A href=\"index.php?Pg=$Pg&SPg=07\" title='Jalan, Irigasi & Jaringan' $styleMenu4>KIB D</a>  |  
					<A href=\"index.php?Pg=$Pg&SPg=08\" title='Aset Tetap Lainnya' $styleMenu5>KIB E</a>  |  
					<A href=\"index.php?Pg=$Pg&SPg=09\" title='Konstruksi Dalam Pengerjaan' $styleMenu6>KIB F</a>  |  
					<!--
					<A href=\"index.php?Pg=05&SPg=KIR\" title='Kartu Inventaris Ruang' $styleMenu12>KIR</a>  |  
					<A href=\"index.php?Pg=05&SPg=KIP\" title='Kartu Inventaris Pegawai' $styleMenu13>KIP</a>  |  
					-->
					
					<!--<A href=\"?Pg=$Pg&SPg=03&fmKONDBRG=3\" title='Aset Lainnya'>ASET LAINNYA</a>  |  -->
					<!--<A href=\"javascript:showAsetLain()\" title='Aset Lainnya'>ASET LAINNYA</a>  |-->
					<A href=\"index.php?Pg=$Pg&SPg=11\" title='Rekap BI' $styleMenu7>REKAP BI</a> |
					<A target='blank' href=\"pages.php?Pg=map&SPg=03\" title='Peta Sebaran' $styleMenu8>PETA</a> |
					<A href=\"index.php?Pg=$Pg&SPg=12\" title='Daftar Mutasi' $styleMenu9>MUTASI</a>  |
					<A href=\"index.php?Pg=$Pg&SPg=13\" title='Rekap Mutasi' $styleMenu10>REKAP MUTASI</a> |
					<!--<A href=\"pages.php?Pg=sensus\" title='Sensus' $styleMenu11>SENSUS</a>-->
					<A href=\"index.php?Pg=05&SPg=belumsensus\" title='Sensus' $styleMenu11>SENSUS</a>
					  &nbsp&nbsp&nbsp
					</td></tr></table>";
			//	break;
			//}
		//}
		//*
		if ($SPg == 'belumsensus' || $SPg=='KIR' || $SPg=='KIP' ) {
			switch ($SPg){
				case 'belumsensus': $styleMenu2_1 = " style='color:blue;'"; break;
				case 'KIR': $styleMenu2_6 = " style='color:blue;'"; break;
				case 'KIP': $styleMenu2_7 = " style='color:blue;'"; break;
				
			}
			
			if($Pg=='SensusTidakTercatat') $styleMenu2_8 = " style='color:blue;'";
			
			$Main->NavAtas = 
			$Main->NavAtas.
			"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin: 1 0 0 0'>
			<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
			
			
			<!--<A href=\"pages.php?Pg=sensus&menu=kertaskerja\" title='Kertas Kerja' $styleMenu2_5>Kertas Kerja</a> |  -->
			<A href=\"index.php?Pg=05&SPg=belumsensus\" title='Belum Cek' $styleMenu2_1>Belum Cek</a> |
			<A href=\"pages.php?Pg=SensusTidakTercatat\" title='Barang Tidak Tercatat' $styleMenu2_8>Tidak Tercatat</a> |
			
			<!--<A href=\"pages.php?Pg=sensus\" title='Sudah Cek' $styleMenu2_2>Sudah Cek</a>  |  -->
			<A href=\"pages.php?Pg=sensus&menu=ada\" title='Ada Barang' $styleMenu2_2>Ada</a>  |  
			<A href=\"pages.php?Pg=sensus&menu=tidakada\" title='Tidak Ada Barang' $styleMenu2_5>Tidak Ada</a>  |  
			
			<!--<A href=\"pages.php?Pg=sensus&menu=diusulkan\" title='Diusulkan Penghapusan' $styleMenu2_3>Diusulkan</a>  |  -->
			<A href=\"pages.php?Pg=SensusHasil\" title='Rekapitulasi Hasil Sensus' $styleMenu2_4>Hasil Sensus</a>  |
			
			<A href=\"index.php?Pg=05&SPg=KIR\" title='Kartu Inventaris Ruang' $styleMenu2_6>KIR</a>  |  
			<A href=\"index.php?Pg=05&SPg=KIP\" title='Kartu Inventaris Pegawai' $styleMenu2_7>KIP</a>  
					
			
			  &nbsp&nbsp&nbsp
			</td></tr></table>";
		}//*/
		
	}
}else if ($Pg=='06'){
	/*$Main->NavAtas = "
	<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
	<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>

	<A href=\"?Pg=$Pg&SPg=$SPg&SSPg=03\" title='Buku Inventaris'>BI</a> |
	<A href=\"?Pg=$Pg&SPg=$SPg&SSPg=04\" title='Tanah'>KIB A</a>  |  
	<A href=\"?Pg=$Pg&SPg=$SPg&SSPg=05\" title='Peralatan & Mesin'>KIB B</a>  |  
	<A href=\"?Pg=$Pg&SPg=$SPg&SSPg=06\" title='Gedung & Bangunan'>KIB C</a>  |  
	<A href=\"?Pg=$Pg&SPg=$SPg&SSPg=07\" title='Jalan, Irigasi & Jaringan'>KIB D</a>  |  
	<A href=\"?Pg=$Pg&SPg=$SPg&SSPg=08\" title='Aset Tetap Lainnya'>KIB E</a>  |  
	<A href=\"?Pg=$Pg&SPg=$SPg&SSPg=09\" title='Konstruksi Dalam Pengerjaan'>KIB F</a>  &nbsp&nbsp&nbsp

	</td></tr></table>
	";*/
}else if (($Pg=='09' && $SPg != '03') || ($Pg=='10') || $Pg=='12' ){
	
	$SSPg = $_REQUEST['SSPg'];
	
	$menustyle03 =''; 
	$menustyle04 =''; 
	$menustyle05 =''; 
	$menustyle06 =''; 
	$menustyle07 =''; 
	$menustyle08 =''; 
	$menustyle09 =''; 
	
	switch($SSPg){
		case '04' : $menustyle04 = "style='color:blue'"; break;
		case '05' : $menustyle05 = "style='color:blue'"; break;
		case '06' : $menustyle06 = "style='color:blue'"; break;
		case '07' : $menustyle07 = "style='color:blue'"; break;
		case '08' : $menustyle08 = "style='color:blue'"; break;
		case '09' : $menustyle09 = "style='color:blue'"; break;		
		default: $menustyle03 ="style='color:blue'"; break;
	}
	
	$menupenghapusan = $Pg !='09'?  '' :
		"<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		<A href=\"pages.php?Pg=usulanhapus\" title='Usulan Penghapusan'>USULAN </a> |
		<A href=\"pages.php?Pg=usulanhapusba\" title='Berita Acara Penghapusan'>BERITA ACARA</a>  |  
		<A href=\"pages.php?Pg=usulanhapussk\" title='Usulan SK Gubernur'>USULAN SK</a>  |
		<A href=\"index.php?Pg=09&SPg=01\" title='Daftar Penghapusan' style='color:blue'>PENGHAPUSAN </a>  
		&nbsp&nbsp&nbsp	
		</td></tr>";
	$Main->NavAtas = "
	
		<!--menubar_page-->
		<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 4 0'>
		$menupenghapusan
		
		<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	
	
		<A href=\"?Pg=$Pg&SPg=$SPg&SSPg=03\" title='Buku Inventaris' $menustyle03>BI</a> |
		<A href=\"?Pg=$Pg&SPg=$SPg&SSPg=04\" title='Tanah' $menustyle04>KIB A</a>  |  
		<A href=\"?Pg=$Pg&SPg=$SPg&SSPg=05\" title='Peralatan & Mesin' $menustyle05>KIB B</a>  |  
		<A href=\"?Pg=$Pg&SPg=$SPg&SSPg=06\" title='Gedung & Bangunan' $menustyle06>KIB C</a>  |  
		<A href=\"?Pg=$Pg&SPg=$SPg&SSPg=07\" title='Jalan, Irigasi & Jaringan' $menustyle07>KIB D</a>  |  
		<A href=\"?Pg=$Pg&SPg=$SPg&SSPg=08\" title='Aset Tetap Lainnya' $menustyle08>KIB E</a>  |  
		<A href=\"?Pg=$Pg&SPg=$SPg&SSPg=09\" title='Konstruksi Dalam Pengerjaan' $menustyle09>KIB F</a>  &nbsp&nbsp&nbsp
		<!--<A href=\"?Pg=$Pg&SPg=$SPg\" title='Rekap BI'>REKAP BI</a> &nbsp&nbsp&nbsp-->
		</td></tr></table>
		";
}else {
	$Main->NavAtas = '';
}

?>