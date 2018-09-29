#!/bin/bash

type=$1;
domain=$2;
dbConfigPath="/home/staging/projects/admin4biz/tools";
echo '---- MIGRATING';

if [ "$type" == "pos" ]; then
        domainDir=/home/production/projects/pos.vn;
	fullDomain=$domain".pos.vn";
else
        domainDir=/home/production/projects/4biz.vn;
	fullDomain=$domain".4biz.vn";
fi
if [ -d $domainDir ]; then
	# git checkout application/config/database.php
	# git clean -df
	# git checkout -- .
	# git pull
	# rm application/config/database.php
	# cp application/config/database.php.bak application/config/database.php

	if [ -d $domainDir/migration/ ]; then
		for file in $domainDir/migration/*
		do
			if [ -f $file ]; then
				mysql -uroot -p4biz#2016 $domain < $file
			fi
		done
	fi
else
	echo '---- DOMAIN is not exist!'
fi

echo '---- DONE!'
