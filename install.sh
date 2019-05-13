#!/bin/bash

################
if hash composer; then
  echo "Composer Already Installed"
  echo "You can find it at $(type -p composer)"
  composer install
  php -S localhost:8000
  exit
fi

# Update package index
sudo apt update

# Make sure php is installed
sudo apt install php php-cli

# Download latest composer snapshot and run it by php
sudo wget https://getcomposer.org/composer.phar

# Move composer to /bin/composer
sudo mv composer.phar /bin/composer

echo "Composer Installed Globally Successfully"
echo "Composer Installed at $(type -p composer)"
echo "You can always find it by calling `type -p composer`"
php composer install
