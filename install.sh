set -e
SERVER_NAME=example.com
apt install -y php-mbstring
apt install -y zip unzip
apt install -y composer
apt install -y php-dev
apt install -y php-yaml
pecl install mongodb
echo "extension=mongodb.so" >> /etc/php/7.0/cli/php.ini
echo "extension=mongodb.so" >> /etc/php/7.0/apache2/php.ini
cd /var/www/${SERVER_NAME}
composer require mongodb/mongodb
composer require facebook/graph-sdk
composer require phpmailer/phpmailer
cat >> /etc/apache2/sites-available/${SERVER_NAME}.conf <<END
<Directory /var/www/${SERVER_NAME}/public>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^.*$ /index.php [L,QSA]
    Options -Indexes
</Directory>
END
service apache2 restart