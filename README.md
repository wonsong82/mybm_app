<VirtualHost *:80>

	Header set Access-Control-Allow-Origin "*"
	ServerName mybm.local
	
	DocumentRoot "/var/www/mybm/app/public"
	Alias /admin "/var/www/mybm/admin/public"
	Alias /live "/var/www/mybm/live"
	
	<Directory "/var/www/mybm" >
		Options Indexes FollowSymLinks
		AllowOverride All
		Order allow,deny
		allow from all
	</Directory>
	
	ErrorLog ${APACHE_LOG_DIR}/mybm.error.log
	CustomLog ${APACHE_LOG_DIR}/mybm.access.log combined

</VirtualHost>
 



# README #

This README would normally document whatever steps are necessary to get your application up and running.

### What is this repository for? ###

* Quick summary
* Version
* [Learn Markdown](https://bitbucket.org/tutorials/markdowndemo)

### How do I get set up? ###

* Summary of set up
* Configuration
* Dependencies
* Database configuration
* How to run tests
* Deployment instructions

### Contribution guidelines ###

* Writing tests
* Code review
* Other guidelines

### Who do I talk to? ###

* Repo owner or admin
* Other community or team contact