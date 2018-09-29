#!/bin/bash

dbName=$1
dbCore=biz2018_empty

mysql -uroot -p4biz#2016 -e "CREATE DATABASE IF NOT EXISTS "$dbName;
mysqldump -uroot -p4biz#2016 $dbCore | mysql -uroot -p4biz#2016 $dbName;
mysql -uroot -p4biz#2016 $dbName < /var/www/projects/tool/bizmanage/tools/addUser.sql;

