#!/bin/bash

type=$1;
domain=$2;
dbName=$3;

echo '---- MIGRATING';
domainDir=/home/staging/projects/$domain;

if [ -d $domainDir ]; then
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
		done
	fi
else
	echo '---- DOMAIN is not exist!'
fi
echo '---- DONE!'
