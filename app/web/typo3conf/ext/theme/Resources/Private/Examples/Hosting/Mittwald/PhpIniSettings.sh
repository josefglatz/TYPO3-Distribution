#!/bin/bash
echo " "
echo "Set common php.ini settings via sed."
sed -i "s|max_execution_time = 30|max_execution_time = 240|g" /etc/php/php.ini
sed -i "s|max_input_time = 60|max_input_time = 120|g" /etc/php/php.ini
sed -i "s|; max_input_vars = 1000|max_input_vars = 1500|g" /etc/php/php.ini
sed -i "s|post_max_size = 32M|post_max_size = 100M|g" /etc/php/php.ini
sed -i "s|upload_max_filesize = 32M|upload_max_filesize = 100M|g" /etc/php/php.ini
echo " "
echo "Check if all \"max_\" php settings are set correctly:"
echo " "
