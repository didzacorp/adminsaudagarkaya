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
    $tableName = $this->listTable();
    $explodeTableName = explode(",",$tableName);
    for ($i=0; $i < sizeof($explodeTableName); $i++) {
      if($this->filterExtension($explodeTableName[$i]) == 0 && $this->sqlRowCount($this->sqlQuery("SHOW CREATE VIEW ".$explodeTableName[$i])) == 0){
        echo "TRUNCATE TABLE ".$explodeTableName[$i]."; \n";
      }
    }


  }
  function filterExtension($word){
      $result = 0;
      for ($i=0; $i < sizeof($this->blockListExtension); $i++) {
        if(strpos($word, $this->blockListExtension[$i][0]) !== false){
          $result += 1;
        }
      }
      return $result;
  }

  function listTable(){
		$this->setConfig();
		$getTableName = $this->sqlQuery("show tables");
		while ($dataTable = $this->sqlArray($getTableName)) {
			$arrayTable[] = $dataTable["Tables_in_".$this->databaseName];
		}
		return implode(",",$arrayTable);
	}

}

$generateJSON = new GenerateJSON();


 ?>

