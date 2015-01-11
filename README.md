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
	Admin CMS Management/CMS page support
	Admin Management for Site settings
	Contact page built in
	Cache generated for xml layouts,css,js

	Installer script to setup in less than a min. - In progress

TODO
====
	Workout XML[local.xml,config.xml,layout.xml] based structure -  Have to be optimized
	getChildHtml based rendering  -  Have to be optimized
	Installer and check install status on every run -  Have to be optimized
	Add URL rewrite  -  Have to be optimized
	setData,getData to sent data to template  -  Have to be optimized
    Admin System config - enable/disable [cache, compress js, css, html], smtp site settings  -  Have to be optimized
    Admin My account page  -  Have to be optimized
    Admin User Grid with paginations  -  Have to be optimized
    Add block, getmodel logics. -  Have to be optimized
    Admin CMS tables/pages with block/phtml file,variables including  -  Have to be optimized

    Getters, Setters for Model files
    Install in separate file -> install.php with upgrade links -> Check for db upgrade

    Add commenting, documentation
    Separate Cache and workout fully functional caching solution

	Doc:
	    Mysql:
        Instead of this way
            $qry = "SELECT * FROM `{$this->getTable("cms_pages")}` where page_id = '$id'";
        We can use
            $model->getCollection() -> $this->getCms_nameValue_string(), $this->getCmsNameValueString()
            $model->insert()
            $model->update()
            $model->delete()

        CMS:
        We can use like the following in editor to call php and variables from Helper

            {{block type="block/template"  template="page/cms_dyanamic.phtml" name="cms_dyanamic"}}

            Welcome to {{var site_title}}