Swift Panel v1.6.1
===========

Requirements
===========

Web Server
===========

Linux Operating System (CentOS 6 Recommended)

PHP 5 (PHP 5.2+ Recommended)

MySQL Database

Curl Support

FTP Extension

SSH2 Extension (Instructions Included)

We recommend using a Virtual Private Server (VPS) for your web server.
If you don't want to manage your own VPS, we can host your SWIFT Panel for you completely FREE! Open a support ticket to request free web hosting.

Game Server Boxes
===========

Linux Operating System

Root Access

SCREEN (Just run "yum install screen")

Thats it! No addition files or requirements!

Licensing
==========
There is no licensing needed as of now.

SSH2 Install
============

SSH2 Install 
 
yum install gcc php-devel php-pear libssh2 libssh2-devel
 
pecl install -f ssh2
After running that command, it should stop at a line just press ENTER to continue.
 
All you have to do is hit Enter and it should detect the proper path. Once the install is completed, you just have to tell PHP to load the extension when it boots.

touch /etc/php.d/ssh2.ini

echo extension=ssh2.so > /etc/php.d/ssh2.ini
