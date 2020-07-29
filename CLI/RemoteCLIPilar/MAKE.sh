php5.6 setup.php --type=showStruktur --tableName=* --dirName=DATABASE-UPDATE-2019-12
php5.6 setup.php --type=showTrigger --triggerName=* --dirName=DATABASE-UPDATE-2019-12
php5.6 setup.php --type=showView --viewName=* --dirName=DATABASE-UPDATE-2019-12
php5.6 setup.php --type=showRoutine --routineName=* --dirName=DATABASE-UPDATE-2019-12
#php referensi.php --type=dump --tableName=referensi_global.txt --dirName=MASTER_2019
php5.6 generateJSON.php --tableName=* --viewName=* --triggerName=* --routineName=* --databaseName=saudagar_kaya --dirName=DATABASE-UPDATE-2019-12 > DATABASE-UPDATE-2019-12.json
#php fileInstall.php --type=compressFile --dumpDir=SOURCE-CODE-UPDATE-2019-12 --projectLocation=/var/www/html/atisisbada_demo_v2
