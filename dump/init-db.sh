#/bin/bash

cd /docker-entrypoint-initdb.d/
mysql --default-character-set=utf8 -u root zamowienia < ./INIT.sql