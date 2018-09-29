#!/bin/bash

type=$1;
domain=$2;
dbName=$3;
echo '---- MIGRATING';
domainDir=/home/production/projects/customs/$domain;

if [ "$type" == "pos" ]; then
        sourceDir=/home/production/projects/pos.vn;
else
        sourceDir=/home/production/projects/4biz.vn;
fi

if [ -d $domainDir ]; then
	echo '+++';
	cd $domainDir;
	git clean -df
	git checkout -- .
	git pull
	# git fetch -v --progress "origin"
	# git checkout -f -b custom/$domain remotes/origin/custom/$domain --

	if [ -d $domainDir/migration/ ]; then
			for file in $domainDir/migration/*
			do
				if [ -f $file ]; then
					mysql -uroot -p4biz#2016 $dbName < $file
				fi
			done;
	fi
else
	sed "s/___DOMAIN___/$domain/g" /home/staging/projects/admin4biz/tools/pro.conf.example > /home/staging/projects/admin4biz/tools/pro.conf.tmp01
	cat /home/staging/projects/admin4biz/tools/pro.conf.tmp01 >> /home/production/nginx/conf/$domain.conf
	unlink /home/staging/projects/admin4biz/tools/pro.conf.tmp01

	cd /home/production/projects/customs;
	git clone /opt/repos/4biz2016.git -b custom/$domain $domain;
	
	sudo service nginx restart
	
	cp $sourceDir/application/config/production/$domain/database.php $domainDir/application/config/production/database.php
fi

echo '---- DONE!'
