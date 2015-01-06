Slim-PHP-MVC-Framework-Like-Magento-MVC-architecture
====================================================

	PHP MVC Framework Like magento MVC architecture.
	
How to use Slim-PHP-MVC
=======================
	Download and extract the code into webserver path and Make sure you have write permission for var directory.
	Check in your browser with the web server Path - the app will ask you to install - setup a db and finish installation.

Features of Slim-PHP-MVC
=======================
	MVC Pattern
	Page wise CSS,JS,HTML minify and combine
	XML layout based templating
	Multi theming Support
	Separate Admin Handler
	SEO Friendly URL's/URL rewrite Support
	
	Installer script to setup in less than a min. - In progress
	Admin CMS Management/CMS page support - In progress
	Admin Management for Site settings - In progress
	Contact page built in - In progress
	User Location Finder built in - In progress
	Cache generated for xml layouts,css,js - In progress
	
TODO
====
	Workout XML[local.xml,config.xml,layout.xml] based structure -  Have to be optimized
	getChildHtml based rendering  -  Have to be optimized
	Installer and check install status on every run -  Have to be optimized
	Add URL rewrite  -  Have to be optimized
	setData,getData to sent data to template  -  Have to be optimized


	Install in separate file -> install.php with upgrade links -> Check for db upgrade
	Admin System config - enable/disable [cache, compress js, css, html], site settings
	Admin My account page
	Separate Cache and workout fully functional caching solution
	Admin User Grid with paginations
	Admin CMS tables/pages with block/phtml file,variables including
	Add commenting, documentation
	Add Location Based messaging
    Find way for collection, delete, update conditions with and , or combination


	Doc:

	$qry = "SELECT * FROM `{$this->getTable("cms_pages")}` where page_id = '$id'";

	getCollection
	insert
	update
	delete