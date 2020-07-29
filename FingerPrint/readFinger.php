<?php
include "config.php";
class ReadFinger extends Config
{
  function __construct()
  {
    for ($i=1; $i > 0 ; $i++) {
      echo $this->monitorLog()."\n";
      sleep(1);
      $i = $i+1;
    }
  }
  function monitorLog(){
    $response = $this->dropTrashString($this->getLog());
    $contents = $response;
    $DOM = new DOMDocument;
    $DOM->loadHTML($contents);
    $items = $DOM->getElementsByTagName('tr');
    $no = 1;
    $arrayData = array();
    foreach ($items as $node) {
      if($no != 1 && $no !=2){
        $explodeString = explode(";",$this->tdrows($node->childNodes));
        $arrayData[] = array(
          "id" => $explodeString[0],
          "namaPegawai" => $explodeString[1],
          "tanggal" => $explodeString[2],
          "jam" => $explodeString[3],
          "identify" => $explodeString[4],
          "status" => $explodeString[5],
        );
      }
      $no+=1;
    }
    $lastLog = file_get_contents("logAbsen");
    if(json_encode($arrayData,JSON_PRETTY_PRINT) != $lastLog){
      file_put_contents("LOG/".md5(date("Y-m-d")).md5(date("H:i:s")),json_encode($arrayData,JSON_PRETTY_PRINT));

      $logCat = "LOG CHANGED : => ".$arrayData[0]['id']." ".$arrayData[0]['namaPegawai']." ".$arrayData[0]['status']." pada ".$arrayData[0]['status']." jam ".$arrayData[0]['jam'];
    }else{
      $logCat = "IDLE";
    }
    file_put_contents("logAbsen",json_encode($arrayData,JSON_PRETTY_PRINT));
    return $logCat;
  }



  function dropTrashString($string){
    $string = str_replace("\r","",$string);
    $string = str_replace("//","/",$string);
    $string = str_replace("\t","",$string);
    $string = str_replace("<HTML>","",$string);
    $string = str_replace("<HEAD>","",$string);
    $string = str_replace("<TITLE>","",$string);
    $string = str_replace("</TITLE>","",$string);
    $string = str_replace("<meta http-equiv='Content-Type' content='text/html;'>","",$string);
    $string = str_replace("<LINK href='../css/Secutime.css' type=text/css rel=stylesheet>","",$string);
    $string = str_replace("<LINK href='../css/list.css' type=text/css rel=stylesheet>","",$string);
    $string = str_replace("</SCRIPT>","",$string);
    $string = str_replace("<SCRIPT language=javascript src='../js/list.js'>","",$string);
    $string = str_replace("</HEAD>","",$string);
    $string = str_replace("<BODY bgcolor=#ffffff>","",$string);
    $string = str_replace("</body>","",$string);
    $string = str_replace("</html>","",$string);
    $string = str_replace("</html>","",$string);
    $string = str_replace("&nbsp","",$string);
    $string = str_replace(";","",$string);
    // $string = str_replace("<table width=100% border=0 cellpadding=0 cellspacing=2 valign=top align=center>","",$string);
    return $string;
  }
  function tdrows($elements){
      $str = "";
      foreach ($elements as $element) {
          $str .= $element->nodeValue . ";";
      }
      return $str;
  }
  function getLog(){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
        'Upgrade-Insecure-Requests: 1',
        'Connection: keep-alive',
        'Cookie: SessionID=1537949217',
        'Host: 192.168.65.11',
        'Cache-Control: no-cache',

    ));
    curl_setopt($curl,CURLOPT_URL, "http://192.168.65.11/form/RTData");
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.108 Safari/537.36");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);

    return $result;

  }
}

$asu = new ReadFinger();


 ?>
