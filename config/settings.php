<?php
include_once("config.php");

Spark::Set(Config::SITE_TITLE, "SparkBox Demo");

Spark::Set(Config::TRANSLATOR_ENABLED, TRUE);
Spark::Set(Config::DB_ENABLED, TRUE);
Spark::Set(Config::DEFAULT_LANGUAGE, "bulgarian");
Spark::Set(Config::DEFAULT_LANGUAGE_ISO3, "bgn");
Spark::Set(Config::DEFAULT_LOCALE, "bg-bg");
Spark::Set(Config::PAGE_CACHE_ENABLED, FALSE);