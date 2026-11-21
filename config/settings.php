<?php
include_once("config.php");

Spark::Set(Config::SITE_TITLE, "SparkBox Demo");

Spark::Set(Config::TRANSLATOR_ENABLED, FALSE);
Spark::Set(Config::DB_ENABLED, TRUE);

Spark::Set(Config::DEFAULT_LANGUAGE, "english");
Spark::Set(Config::DEFAULT_LANGUAGE_ISO3, "eng");
Spark::Set(Config::DEFAULT_LOCALE, "en-us");

Spark::Set(Config::IMAGE_UPLOAD_DEFAULT_WIDTH, 1280);
Spark::Set(Config::IMAGE_UPLOAD_DEFAULT_HEIGHT, 960);

Spark::Set(Config::STORAGE_CACHE_ENABLED, true);
Spark::Set(Config::PAGE_CACHE_ENABLED, false);

//the e-mail inputs are not checked for a mail domain (DNS) - nothing is mailed
Spark::Set(Config::EMAIL_DOMAIN_CHECK, true);
Spark::Set(Config::PHPMAILER_ENABLED, true);
Spark::Set(Config::DEFAULT_SERVICE_NAME, "Sparkbox-Demo");
Spark::Set(Config::DEFAULT_SERVICE_EMAIL, "info@saturnosoft.org");