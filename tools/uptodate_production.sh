#!/bin/bash

type=$1;
domain=$2;
dbName=$3;
dbConfigPath="/home/staging/projects/admin4biz/tools";
echo '---- MIGRATING';
filePackages="/home/staging/projects/admin4biz/tools/constant/packages.ini";

if [ "$type" == "pos" ]; then
        domainDir=/home/production/projects/pos.vn;
else
        domainDir=/home/production/projects/4biz.vn;
fi
if [ -d $domainDir ]; then
	echo '+++';
	cd $domainDir;
	git clean -df
	git checkout -- .
	git pull
	if [ -d $domainDir/migration/ ]; then
			for file in $domainDir/migration/*
			do
				if [ -f $file ]; then
					mysql -uroot -p4biz#2016 $dbName < $file
				fi
			done;
	fi
else
	echo '---- DOMAIN is not exist!'
fi

echo '---- DONE!'
