php7.0 setup.php --type=fixStruktur --fileName=DATABASE-UPDATE-2019-12.json
php7.0 setup.php --type=fixView --fileName=DATABASE-UPDATE-2019-12.json
#php setup.php --type=fixTrigger --fileName=DATABASE-UPDATE-2019-12.json
#php setup.php --type=fixRoutine --fileName=DATABASE-UPDATE-2019-12.json
#php fileInstall.php --type=extractFile --projectLocation=/var/www/html/development108.atisisbada.id --sourceFile=SOURCE-CODE-UPDATE-2019-12
#php referensi.php --type=restore --fileName=MASTER_2019.json
#php referensi.php --type=replace --fileName=SETTING_REPLACE.sql
#chmod -R 777 /var/www/html/atisisbada_2019
