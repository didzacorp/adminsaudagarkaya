<?php
include 'config.php';
include 'excel_reader.php';
class deleteDuplicate extends Config{
  function __construct(){
    $options = getopt(null, ["fileName:"]);
    $namaFile =$options['fileName'];
    $nameFileExcel = $namaFile;
    $excel = new PhpExcelReader;
    $excel->read("$namaFile");
    $sheet = $excel->sheets[0];
       $x = 2;
       $jumlahData = $sheet['numRows'] - 1;
       while($x <= $sheet['numRows']) {
        $kodeRekening1=  $sheet['cells'][$x][1];
        $kodeRekening2=  $sheet['cells'][$x][2];
        $kodeRekening3=  $sheet['cells'][$x][3];
        $kodeRekening4=  $sheet['cells'][$x][4];
        if($kodeRekening4 < 10){
          $kodeRekening4 = "0".$kodeRekening4;
        }
        $namaRekening = $sheet['cells'][$x][5];
        $dataRekening = array(
          "kode_rekening_1" => $kodeRekening1,
          "kode_rekening_2" => $kodeRekening2,
          "kode_rekening_3" => $kodeRekening3,
          "kode_rekening_4" => $kodeRekening4,
          "nama_rekening" => $namaRekening,
        );
        $queryInsert = $this->sqlInsert("ref_rekening",$dataRekening);
        $this->sqlQuery($queryInsert);
        echo $queryInsert." \n";
        $x++;
      }
  }

  function stringDetector($string){
      $string = str_replace("`","",$string);
      $string = str_replace("'","",$string);
      $string = str_replace(" ","",$string);
      return $string;
  }

}

$wakwaw = new deleteDuplicate();







 ?>
