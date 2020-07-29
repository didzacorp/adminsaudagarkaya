<?php
include "config.php";
class GenerateJSON extends Config{
  var $arrayFixIndexTable = array();
  var $blockListExtension = array(
      array('.bck'),
      array('bck'),
      array(',bck'),
      array('.BCK'),
      array('.backup'),
      array('.201'),
      array('201'),
      array('.php_'),
      array('.php_'),
      array('.bck'),
      array('.git'),
      array('_DOC'),
      array('.doc'),
      array('.xls'),
  );
  function __construct(){
    $options = getopt(null, array(
      "type:",
      "databaseFile:",
      "date:",
      "action:",
      "tableName:",
      "viewName:",
      "defaultValue:",
      "triggerName:",
      "routineName:",
      "dirName:",
      "databaseName:",
      "tableDirName:",
      "triggerDirName:",
      "viewDirName:",
      "routineDirName:",
      "fileName:",
      "checkResult:",

    ));
    foreach ($options as $key => $value) {
       $$key = $value;
    }
    $arrayKodeSKPD = array();

    $kondisiSKPD = " 1 = 1";
    $getDataSKPD = $this->sqlQuery("select * from ref_skpd where e1 !='000'     order by c1,c,d,e,e1");
    while ($dataSKPD = $this->sqlArray($getDataSKPD)) {
      $arrayKodeSKPD[] = $dataSKPD['c1'].".".$dataSKPD['c'].".".$dataSKPD['d'].".".$dataSKPD['e'].".".$dataSKPD['e1'];
    }

    $arrayPost = array();
    $getSettingTahunInventaris = $this->sqlArray($this->sqlQuery("select * from setting where Id='THN_INVENTARIS'"));
    $getSettingInventaris = $this->sqlArray($this->sqlQuery("select * from setting_inventaris where thn_sensus = '".$getSettingTahunInventaris['nilai']."'"));
    $arrKondisi = array();
    $getKondisiSettingInventaris = $this->sqlArray($this->sqlQuery("select * from setting where Id ='STATUS_ASET'"));
    $getTahunPerolehan = $this->sqlArray($this->sqlQuery("select * from setting where Id ='TAHUN_PEROLEHAN'"));
    $explodeTahunPerolehan = explode(";",$getTahunPerolehan['nilai']);

    for ($iZX=0; $iZX < sizeof($arrayKodeSKPD); $iZX++) {
      $kodeSKPD = $arrayKodeSKPD[$iZX];
      $explodeKodeSKPD = explode(".",$kodeSKPD);
      // $getGrupKodeBarang = $this->sqlQuery("select concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j) as kodeBarang, sum(nilai_perolehan_prev) as hargaSaldoAwal, sum(jml_barang) as jumlahSaldoAwal, staset_prev  from buku_induk  Where  c1 = '".$explodeKodeSKPD[0]."' and c = '".$explodeKodeSKPD[1]."' and d = '".$explodeKodeSKPD[2]."' and e = '".$explodeKodeSKPD[3]."' and e1 = '".$explodeKodeSKPD[4]."'   and status_barang_prev not in(3) and  thn_perolehan >= ".$explodeTahunPerolehan[0]." and thn_perolehan <= ".$explodeTahunPerolehan[1]."   and staset_prev in (".$getKondisiSettingInventaris['nilai'].") group by c1,c,d,e,e1,f1,f2,f,g,h,i,j,staset_prev");
      $getDataRekap = $this->sqlArray($this->sqlQuery("select sum(jumlah_saldo_awal), sum(harga_saldo_awal)  from rekap_inventaris where   c1 = '".$explodeKodeSKPD[0]."' and c = '".$explodeKodeSKPD[1]."' and d = '".$explodeKodeSKPD[2]."' and e = '".$explodeKodeSKPD[3]."' and e1 = '".$explodeKodeSKPD[4]."' and tahun='".$getSettingTahunInventaris['nilai']."'  "));
      $rekapInventaris = $getDataRekap['sum(jumlah_saldo_awal)'];
      // $getJumlahSudahInventaris = $this->sqlArray($this->sqlQuery("select count(idbi) from inventaris where tahun_sensus = '2019' and c1 = '".$explodeKodeSKPD[0]."' and c = '".$explodeKodeSKPD[1]."' and d = '".$explodeKodeSKPD[2]."' and e = '".$explodeKodeSKPD[3]."' and e1 = '".$explodeKodeSKPD[4]."' "));
      $getSaldoDariBI = $this->sqlArray($this->sqlQuery("select sum(nilai_perolehan_prev) as hargaSaldoAwal, sum(jml_barang) as jumlahSaldoAwal  from buku_induk  Where  c1 = '".$explodeKodeSKPD[0]."' and c = '".$explodeKodeSKPD[1]."' and d = '".$explodeKodeSKPD[2]."' and e = '".$explodeKodeSKPD[3]."' and e1 = '".$explodeKodeSKPD[4]."'   and status_barang_prev not in(3) and  thn_perolehan >= ".$explodeTahunPerolehan[0]." and thn_perolehan <= ".$explodeTahunPerolehan[1]."   and staset_prev in (".$getKondisiSettingInventaris['nilai'].")"));

      if($rekapInventaris != $getSaldoDariBI['jumlahSaldoAwal']){
        file_put_contents('listSKPDSaldoAwal.txt', $kodeSKPD .PHP_EOL , FILE_APPEND | LOCK_EX);
        echo "\033[0;31m".$kodeSKPD." => ".$this->numberFormat($rekapInventaris)." || ".$this->numberFormat($getSaldoDariBI['jumlahSaldoAwal'])." ERROR "."\033[0m"." \n";
      }else{
        echo  "KODE SKPD : $kodeSKPD"." => ".$this->numberFormat($rekapInventaris)." || ".$this->numberFormat($getSaldoDariBI['jumlahSaldoAwal'])."\n";
      }


    }


  }
  function updateRusakBeratJSON($fileName){
    $arrayIdRusakBerat = json_decode(file_get_contents($fileName));
    for ($i=0; $i < sizeof($arrayIdRusakBerat) ; $i++) {
      echo $this->prosesUpdateRusakBerat($arrayIdRusakBerat[$i])."\n";
    }
  }
  function updateRusakBerat($fileName){
    $arrayIdRusakBerat = explode("\n",file_get_contents($fileName));
    // $arrayIdRusakBerat = array("7988");
    for ($i=0; $i < sizeof($arrayIdRusakBerat) ; $i++) {
      echo $this->prosesUpdateRusakBerat($arrayIdRusakBerat[$i])."\n";
    }
  }
  function updateTidakAda($fileName){
    $arrayIdTidakAda = explode("\n",file_get_contents($fileName));
    // $arrayIdTidakAda = array("3223349","3223346","3224962");
    for ($i=0; $i < sizeof($arrayIdTidakAda) ; $i++) {
      echo $this->prosesUpdateTidakAda($arrayIdTidakAda[$i])."\n";
    }
  }
  function updateTidakAdaJSON($fileName){
    $arrayIdTidakAda = json_decode(file_get_contents($fileName));
    // $arrayIdTidakAda = array("3223349","3223346","3224962");
    for ($i=0; $i < sizeof($arrayIdTidakAda) ; $i++) {
      echo $this->prosesUpdateTidakAda($arrayIdTidakAda[$i])."\n";
    }
  }
  function prosesUpdateRusakBerat($idUpdate){

    if (!empty($idUpdate)) {
        $thn_login = "2018";
        $uid     = "BOT CLI";
        $cek     = '';
        $err     = '';
        $content = '';
        $json    = TRUE;
        $fmST    = $_REQUEST[$this->Prefix . '_fmST'];
        $idubah  = $idUpdate;
        $_REQUEST['tgl_sk'] = "31-12-2018";
        $_REQUEST['thn_buku'] = "2018";
        $_REQUEST['tgl_buku'] = "31-12-2018";
        $no_sk = "CLI DZAKIR";

        $gen_tgl = $_REQUEST['tgl_buku'] . '-' . $_REQUEST['thn_buku'];
        $tgl     = "2018-12-31";

        $tgl_sk = date('Y-m-d', strtotime($_REQUEST['tgl_sk']));
        $KondisiBarang = array(
      		array("1","Baik"),
      		array("2","Kurang Baik"),
      		array("3","Rusak Berat")
      	);
        $kondisi_baru = $KondisiBarang[2][0];
        $ket          = "Reklas RB dari Inventaris";



        $exptglsk = explode('-', $_REQUEST['tgl_sk']);
        $cektglsk = $exptglsk[2] . '-' . $exptglsk[1] . '-' . $exptglsk[0];

        if ($err == '' && $no_sk == '')
            $err = 'NOMOR belum diisi !';

        if ($err == '' && !$this->cektanggal($tgl))
            $err = 'TANGGAL BUKU salah!';
        if ($err == '' && !$this->cektanggal($cektglsk))
            $err = 'TANGGAL BAST salah!';
        $thn_bast = substr($tgl_sk, 0, 4);
        if ($err == '' && $thn_bast > $thn_login)
            $err = 'TAHUN BAST maximal ' . $thn_login . ' !';
        if ($err == '' && $this->compareTanggal($tgl, date('Y-m-d')) == 2)
            $err = 'TANGGAL BUKU tidak lebih besar dari Hari ini!';
        if ($err == '') {
            $limit  = 2;
            $getcnt = "select * from buku_induk where id = '$idUpdate' and kondisi !=$kondisi_baru and id not in(select idbi from t_kondisi where kond_akhir =$kondisi_baru and year(tgl)=$thn_login) limit 0,$limit";

            //$err='qyr='.$getcnt;
            $jml          = $this->sqlRowCount($this->sqlQuery($getcnt));
            $content->jml = $jml;
            $result       = $this->sqlQuery($getcnt);
            while ($old = $this->sqlArray($result)) {
                $idbiawal      = $old['idawal'];
                $idbi          = $old['id'];
                $kondisi       = $old['kondisi'];
                $staset_lama   = $old['staset'];
                $status_barang = $old['status_barang'];
                $noreg         = $old['noreg'];
                $dif_kondisi   = $kondisi_baru - $kondisi;
                $nilai_buku    = $this->getNilaiBuku($idbi, $tgl, 0);
                $nilai_susut   = $this->getAkumPenyusutan($idbi, $tgl);

                // $cekbi = cekBI($idbi);
                $cekbi = "";
                // if ($err == '' && !empty($cekbi) )
                //     $err = 'Warning,ID Barang ' . $idbi . ' rusak (' . $cekbi . '),Harap hubungi admin!';

                $maxtrans = $this->sqlArray($this->sqlQuery("select max(tgl_buku) as maxtgl from t_transaksi where idbi='$idbi'"));
                if ($err == '' && $this->compareTanggal($tgl, $maxtrans['maxtgl']) == 0)
                    $err = 'TANGGAL BUKU tidak lebih kecil dari tanggal transaksi sebelumnya!';

                $tgl_susutAkhir = $this->sqlArray($this->sqlQuery("select tgl from penyusutan where idbi='$idbi' and jns_trans2=30 order by id desc limit 1"));
                // if ($err == '' && sudahClosing($tgl, $old['c'], $old['d'], $old['e'], $old['e1'], $old['c1']))
                //     $err = 'Tanggal sudah Closing !';
                if ($err == '' && $tgl <= $tgl_susutAkhir['tgl'])
                    $err = "Id Barang " . $idbi . " Sudah ada penyusutan !";
                // - tanggal harus <= tgl hari ini
                //tgl >=tgl_buku
                if ($this->compareTanggal($tgl, $old['tgl_buku']) == 0)
                    $err = "TANGGAL BUKU tidak lebih kecil dari TANGGAL BUKU BARANG!";
                if ($err == '' && $status_barang != 1)
                    $err = "Id Barang " . $idbi . " Status barang bukan Inventaris !";
                if ($err == '' && $noreg == '0000')
                    $err = 'Id Barang ' . $idbi . ' No. Register masih 0000,belum di generate !';

                $cekpmfsebagian = $this->sqlArray($this->sqlQuery("select count(*) as cnt from pemanfaatan where bentuk_pemanfaatan=7 and idbi_awal = '$idbiawal'"));
                if ($err == '' && $cekpmfsebagian['cnt'] > 0)
                    $err = "Gagal,Id Barang " . $idbi . "  sudah di pemanfaatan sebagian !";

                if ($err == '') {
                    $bi   = $this->sqlArray($this->sqlQuery("select * from buku_induk where id='$idbi'"));
                    $aqry = "insert into t_kondisi (tgl,idbi,uid,tgl_update,ket, kond_awal,kond_akhir,idbi_awal,dif_kondisi,no_bast,tgl_bast,dokumen_sumber,staset_lama,nilai_buku,nilai_susut) " . " values('$tgl','$idbi','$uid',now(),'$ket', '$kondisi','$kondisi_baru','" . $bi['idawal'] . "','$dif_kondisi','$no_sk','$tgl_sk','6','$staset_lama','$nilai_buku','$nilai_susut') ";
                    $cek .= $aqry;
                    $qry = $this->sqlQuery($aqry);

                    $exequery = "UPDATE buku_induk set kondisi='$kondisi_baru',staset=9 where id='$idbi' ";
                    $qry      = $this->sqlQuery($exequery);
                    //$err.='cek='.$aqry;
                }
            } //end while
        } //end if


        $dataUpdataTidakTercatat = array(
            'idbi' => $getIdBi['max(id)']
        );

        $cek = $getcnt;

    }
    return $idUpdate." -> OK ". $err;
  }
  function prosesUpdateTidakAda($idUpdate){
    $getDataBukuInduk = $this->sqlArray($this->sqlQuery("select * from buku_induk where id = '$idUpdate'"));
    $tahun            = "2018";
    $uid              = "BOT CLI";
    //get data -----------------
    $fmST             = $_REQUEST[$this->Prefix . '_fmST'];
    //$idplh = $_REQUEST[$this->Prefix.'_idplh'];
    $c1_lama          = $getDataBukuInduk['c1'];
    $c_lama           = $getDataBukuInduk['c'];
    $d_lama           = $getDataBukuInduk['d'];
    $jmldata          = $_REQUEST['jmldata'];
    $idubah           = $_REQUEST['idubah'];
    $cbid             = $_REQUEST['cidBI'];
    $idubah           = $idUpdate;
    $idplh            = $idUpdate;
    $gen_tgl          = "31-12" . '-' . "2018";
    $tgl_buku         = date('Y-m-d', strtotime($gen_tgl));
    $no_sk            = "CLI DZAKIR";
    $tgl_sk           = date('Y-m-d', strtotime("31-12-2018"));
    $cr_pemusnahan    = "SENSUS";
    $ket              = 'CLI DZAKIR';
    //$err.='tgll='.$tgl_sk;
    $_REQUEST['tgl_sk'] = "31-12-2018";
    $_REQUEST['thn_buku'] = "2018";
    $_REQUEST['tgl_buku'] = "31-12-2018";
    $idPemusnahan = "0";
    $exptglsk = explode('-', $_REQUEST['tgl_sk']);
    $cektglsk = $exptglsk[2] . '-' . $exptglsk[1] . '-' . $exptglsk[0];

    if ($err == '' && $no_sk == '')
        $err = 'NOMOR belum diisi !';
    if ($err == '' && $_REQUEST['tgl_sk'] == '')
        $err = 'TANGGAL belum diisi!';
    if ($err == '' && $_REQUEST['tgl_buku'] == '')
        $err = 'TANGGAL BUKU belum diisi!';
    //if($err=='' && !$this->cektanggal($tgl_buku)) $err = 'TANGGAL BUKU salah!';
    if ($err == '' && !$this->cektanggal($cektglsk))
        $err = 'TANGGAL SK salah!';
    $thn_bast = substr($tgl_sk, 0, 4);
    if ($err == '' && $thn_bast > $_REQUEST['thn_buku'])
        $err = 'TAHUN SK maximal ' . $_REQUEST['thn_buku'] . ' !';
    if ($err == '' && $this->compareTanggal($tgl_buku, date('Y-m-d')) == 2)
        $err = 'TANGGAL BUKU tidak lebih besar dari Hari ini!';
    if ($err == '' && $cr_pemusnahan == '')
        $err = 'CARA PEMUSNAHAN belum diisi !';
    if ($err == '') {

        if ($idPemusnahan == '0') {
            $query        = "INSERT into pemusnahan(uid,tgl_update,sttemp,no_ba,tgl_ba,tgl_buku,cara_pemusnahan,ket,thn_anggaran) " . "values('$uid',NOW(),'0','$no_sk','$tgl_sk','$tgl_buku','$cr_pemusnahan','$ket','$tahun')"; //$err.=$query;
            $result       = $this->sqlQuery($query);
            $getDataPemusnahan = $this->sqlArray($this->sqlQuery("select max(id) from pemusnahan where uid = '$uid'"));
            $idPemusnahan = $getDataPemusnahan['max(id)'];
        }
        $getcnt       = "select * from buku_induk where id = '$idUpdate' and status_barang!=3 and id not in(select id_bukuinduk from pemusnahan_det )";
        $jml          = mysql_num_rows($this->sqlQuery($getcnt));
        $content->jml = $jml;
        $result       = $this->sqlQuery($getcnt);
        while ($old = $this->sqlArray($result)) {
            $idbiawal      = $old['idawal'];
            $idbi          = $old['id'];
            $staset        = $old['staset'];
            $status_barang = $old['status_barang'];
            $a1            = $old['a1'];
            $a             = $old['a'];
            $b             = $old['b'];
            $c1            = $old['c1'];
            $c             = $old['c'];
            $d             = $old['d'];
            $e             = $old['e'];
            $e1            = $old['e1'];
            $f1            = $old['f1'];
            $f2            = $old['f2'];
            $f             = $old['f'];
            $g             = $old['g'];
            $h             = $old['h'];
            $i             = $old['i'];
            $j             = $old['j'];
            $kondisi       = $old['kondisi'];
            $noreg         = $old['noreg'];
            $thn_perolehan = $old['thn_perolehan'];
            $nilai_buku    = $this->getNilaiBuku($idbi, $tgl_buku, 0);
            $nilai_susut   = $this->getAkumPenyusutan($idbi, $tgl_buku);
            $concatkd     = $Main->KD_BARANG_P108 ? "f1,f2,f,g,h,i,j" : "f,g,h,i,j";
            $kdBarang     = $Main->KD_BARANG_P108 ? $f1 . $f2 . $f . $g . $h . $i . $j : $f . $g . $h . $i . $j;
            $query_brg    = "select * from ref_barang where concat($concatkd)='$kdBarang'";
            $brg          = $this->sqlArray($this->sqlQuery($query_brg));
            $query_jurnal = "select thn_akun,nm_account from ref_jurnal where ka='" . $brg['ka'] . "' and kb='" . $brg['kb'] . "'
        and kc='" . $brg['kc'] . "' and kd='" . $brg['kd'] . "'
        and ke='" . $brg['ke'] . "' and kf='" . $brg['kf'] . "'"; //$cek.='jurnal='.$query_jurnal;
            $jurnal       = $this->sqlArray($this->sqlQuery($query_jurnal));
            $ka           = $brg['ka'];
            $kb           = $brg['kb'];
            $kc           = $brg['kc'];
            $kd           = $brg['kd'];
            $ke           = $brg['ke'];
            $kf           = $brg['kf'];
            $thn_akun     = $jurnal['thn_akun'];
            if ($err == '' && $this->compareTanggal($tgl_buku, $old['tgl_buku']) == 0) {
                $err = 'TANGGAL BUKU dengan Id ' . $idbi . ' tidak lebih kecil dari Tanggal Buku Barang!';
            }
            if ($err == '') {
                $ceksusut = $this->sqlArray($this->sqlQuery("select tgl as tgl_penyusutan from penyusutan where idbi='$idbi' and jns_trans2=30 order by Id desc limit 0,1"));
                if ($tgl_buku <= $ceksusut['tgl_penyusutan'])
                    $err = "Gagal penghapusan,Id Barang " . $idbi . "  sudah penyusutan !";
            }
            $hps = $this->table_get_rec("select count(*)as cnt from penghapusan where mutasi=1 and id_bukuinduk='$idbi'");
            if ($err == '' && $status_barang != 1)
                $err = 'Id Barang ' . $idbi . ' Status barang harus Inventaris !';
            if ($err == '' && $status_barang == 5)
                $err = 'Barang sudah di Tuntutan Ganti Rugi!';
            if ($err == '' && $hps['cnt'] > 1)
                $err = 'Barang sudah di Penghapusan!';
            $transaksi = $this->sqlArray($this->sqlQuery("select max(tgl_buku) as maxtgl from t_transaksi where idbi = '$idbi'"));
            if ($err == '' && ($this->compareTanggal($tgl_buku, $transaksi['maxtgl']) == 0))
                $err = 'TANGGAL BUKU harus lebih besar dari Tanggal Transaksi lainnya!';
            $exequery = "INSERT pemusnahan_det (id_bukuinduk,idbi_awal,c1,c,d,e,e1,f1,f2,f,g,h,i,j," . "thn_perolehan,noreg,jumlah_harga,nilai_susut,kondisi,ket," . "k,l,m,n,o,p,thn_akun,tgl_buku,staset,tgl_create,uid_create,tgl_update,sttemp,refid_pemusnahan)" . "values ('$idbi','$idbiawal','$c1','$c','$d','$e','$e1'," . "'$f1','$f2','$f','$g','$h','$i','$j','$thn_perolehan','$noreg','$nilai_buku','$nilai_susut','$kondisi','$ket'," . "'$ka','$kb','$kc','$kd','$ke','$kf','$thn_akun','$tgl_buku','$staset',NOW(),'$uid',NOW(),1,'$idPemusnahan')";
            $cek      = $exequery;
            $qry      = $this->sqlQuery($exequery);
            if ($qry) {
                $updbi    = "UPDATE buku_induk set staset=14,status_barang=6 where id='$idbi'";
                $resultbi = $this->sqlQuery($updbi);
          }
      }
    }

    return $idUpdate." - > OK";
  }
  function getDataTidakAda(){

    $arrayIdTidakAda = array();
    $getDataUPTDisdik =  $this->sqlQuery("select * from ref_skpd where concat(c1,'.',c,'.',d)   = '1.01.01' and e!='00' and e1='000' ");
    while ($dataUPT = $this->sqlArray($getDataUPTDisdik)) {
      $concatUPT = $dataUPT['c1'].".".$dataUPT['c'].".".$dataUPT['d'].".".$dataUPT['e'];
      $getData = $this->sqlQuery("select aa.id as idTidakAda from buku_induk aa inner join inventaris bb on aa.id=bb.idbi   and  concat(c1,'.',c,'.',d,'.',e)   = '$concatUPT' and staset_prev = 3 and status_barang not in(3,4,5)  and bb.ada=2 and aa.id not in(select id_bukuinduk from v_pemusnahan where  1=1  and    concat(c1,'.',c,'.',d,'.',e)   = '$concatUPT')  ");
      while ($dataTidakAda = $this->sqlArray($getData)) {
        $arrayIdTidakAda[] = $dataTidakAda['idTidakAda'];
        echo $dataTidakAda['idTidakAda']."\n";
      }
    }
    // echo json_encode($arrayIdTidakAda,JSON_PRETTY_PRINT);
  }
  function getDataRusakBerat(){
    $arrayIdRusakBerat = array();
    $getDataUPTDisdik =  $this->sqlQuery("select * from ref_skpd where concat(c1,'.',c,'.',d)   = '1.01.01' and e!='00' and e1='000' ");
    while ($dataUPT = $this->sqlArray($getDataUPTDisdik)) {
      $concatUPT = $dataUPT['c1'].".".$dataUPT['c'].".".$dataUPT['d'].".".$dataUPT['e'];
      $getDataSubUnit =  $this->sqlQuery("select * from ref_skpd where concat(c1,'.',c,'.',d,'.',e)   = '$concatUPT' and e1!='000' ");
      while ($dataSubUnit = $this->sqlArray($getDataSubUnit)) {
        $concatSubUnit = $dataSubUnit['c1'].".".$dataSubUnit['c'].".".$dataSubUnit['d'].".".$dataSubUnit['e'].".".$dataSubUnit['e1'];
        $getData = $this->sqlQuery("select aa.id as idRusakBerat from buku_induk aa inner join inventaris bb on aa.id=bb.idbi   and  concat(c1,'.',c,'.',d,'.',e,'.',e1)   = '$concatSubUnit' and status_barang not in(3,4,5) and staset = 3 and bb.kondisi=3");
        while ($dataRusakBerat = $this->sqlArray($getData)) {
          $arrayIdRusakBerat[] = $dataRusakBerat['idRusakBerat'];
          echo $dataRusakBerat['idRusakBerat']."\n";
        }
      }

    }
    // echo json_encode($arrayIdRusakBerat,JSON_PRETTY_PRINT);
  }
  function cektanggal($strTgl)
{
    $arr = split('-', $strTgl); //yyyy-mm-dd

    return checkdate($arr[1], $arr[2], $arr[0]);

}

function compareTanggal($strTgl1, $strTgl2)
{
    // bandingkan 2 tanggal, return 0. lebih kecil, 1.sama dengan, 2.lebih besar
    //format tgl yyyy-mm-dd
    $hsl  = -1;
    $tgl1 = $strTgl1; // strtotime($strTgl1);
    $tgl2 = $strTgl2; //strtotime($strTgl2);
    if ($tgl1 < $tgl2) {
        $hsl = 0; //lebih kecil
    } else if ($tgl1 == $tgl2) {
        $hsl = 1; //sama dengan
    } else {
        $hsl = 2; //lebih besar
    }
    //echo " $tgl1 - $tgl2 = $hsl ";
    return $hsl;
}

function table_get_rec($sqry)
{
    $jml = 0;
    $qry = $this->sqlQuery($sqry);
    $row = $this->sqlArray($qry);
    return $row;
}
function getNilaiBuku($idbi, $tgl, $StSusut){
	//berdasar tgl buku
	global $Main;
	$aqry="select get_nilai_buku($idbi,'$tgl',$StSusut) as NilaiBuku " ;
	$get = $this->sqlArray($this->sqlQuery($aqry));
	return $get['NilaiBuku'];
}
function getAkumPenyusutan($idbi, $tgl ){
	$hrgSusut = 0;
	$aqry = "select sf_getAkumSusut('$idbi', '$tgl') as hrg_susut; ";
	$qry = $this->sqlQuery($aqry);
	while($isi = $this->sqlArray($qry)){
		$hrgSusut = $isi['hrg_susut'];
	}
	return  $hrgSusut;
}
}

$generateJSON = new GenerateJSON();


 ?>
