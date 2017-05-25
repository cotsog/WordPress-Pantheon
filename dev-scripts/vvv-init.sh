#!/usr/bin/env bash
# Author merenuou@gmail.com

set -e

# Add the site name to the hosts file
#already done by custom config yml file
#echo "192.168.50.4 ${VVV_SITE_NAME}.dev # vvv-auto" >> "/etc/hosts"

#VVV_SITE_NAME='otestsite'
#VVV_PATH_TO_SITE='/vagrant/www/otestsite'


echo "This is your site_name: '${VVV_SITE_NAME}'"


# Export required PHP constants into Bash.
eval $(php -r '
  require_once __DIR__.'/wp-config-local.php';

	foreach( explode( " ", "DB_NAME DB_HOST DB_USER DB_PASSWORD DB_CHARSET" ) as $key ) {
		echo $key . "=" . constant( $key ) . PHP_EOL;
	}
')

# Make a database, if we don't already have one
echo -e "\nCreating database '${VVV_SITE_NAME}' (if it's not already there)"

if [ ! -e wp-config-local.php ]; then
    mysql -u root --password=root -e "CREATE DATABASE IF NOT EXISTS ${VVV_SITE_NAME}"
    mysql -u root --password=root -e "GRANT ALL PRIVILEGES ON ${VVV_SITE_NAME}.* TO wp@localhost IDENTIFIED BY 'wp';"
  else
    mysql -u root --password=root -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET $DB_CHARSET"
    mysql -u root --password=root -e "GRANT ALL PRIVILEGES ON $DB_NAME.* TO $DB_USER@localhost IDENTIFIED BY '$DB_PASSWORD';"
fi

echo -e "\n DB operations done.\n\n"

# Create Nginx Logs
mkdir -p ${VVV_PATH_TO_SITE}/log
touch ${VVV_PATH_TO_SITE}/log/error.log
touch ${VVV_PATH_TO_SITE}/log/access.log

# Install and configure the latest stable version of WordPress
cd ${VVV_PATH_TO_SITE}
if ! $(wp core is-installed --allow-root); then
  wp core download --path="${VVV_PATH_TO_SITE}" --allow-root
  wp core config --dbname="${VVV_SITE_NAME}" --dbuser=wp --dbpass=wp --quiet --allow-root
  wp core multisite-install --url="${VVV_SITE_NAME}.dev" --quiet --title="${VVV_SITE_NAME}" --admin_name=admin --admin_email="admin@${VVV_SITE_NAME}.dev" --admin_password="password" --allow-root
else
  wp core update --allow-root
fi
