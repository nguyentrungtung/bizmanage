#!/bin/bash

type=$1
domain=$2
dbUserName=$3
dbPassword=$4
dbName=$5
dbCore=biz_empty

if [ "$type" == "pos" ]; then
	sourceDir=/home/production/projects/pos.vn;
	dbCore=pos_empty;
else
	sourceDir=/home/production/projects/4biz.vn;
fi

mysql -uroot -p4biz#2016 -e "CREATE DATABASE IF NOT EXISTS "$dbName;
mysql -uroot -p4biz#2016 -e "CREATE USER '"$dbUserName"'@'localhost' IDENTIFIED BY '"$dbPassword"'";
mysql -uroot -p4biz#2016 -e "GRANT ALL PRIVILEGES ON "$dbName".* TO '"$dbUserName"'@'localhost'";
mysql -uroot -p4biz#2016 -e "FLUSH PRIVILEGES";
mysqldump -uroot -p4biz#2016 $dbCore | mysql -uroot -p4biz#2016 $dbName;

mysql -uroot -p4biz#2016 $dbName < /home/staging/projects/admin4biz/tools/addUser.sql

sed "s/___USERNAME___/$dbUserName/g" /home/staging/projects/admin4biz/tools/database.php.example > /home/staging/projects/admin4biz/tools/database.php.tmp01
sed "s/___PASSWORD___/$dbPassword/g" /home/staging/projects/admin4biz/tools/database.php.tmp01 > /home/staging/projects/admin4biz/tools/database.php.tmp02
sed "s/___DBNAME___/$dbName/g" /home/staging/projects/admin4biz/tools/database.php.tmp02 > /home/staging/projects/admin4biz/tools/database.php.$domain

mkdir $sourceDir/application/config/production/$domain
touch $sourceDir/application/config/production/$domain/database.php

cat /home/staging/projects/admin4biz/tools/database.php.$domain > $sourceDir/application/config/production/$domain/database.php
unlink /home/staging/projects/admin4biz/tools/database.php.tmp01
unlink /home/staging/projects/admin4biz/tools/database.php.tmp02
