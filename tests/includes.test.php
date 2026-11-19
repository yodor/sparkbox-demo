<?php
/**
 * Strict includes of the site classes (class/): every class a file uses is reachable through its own include_once
 * chain - the core and store libs as the site loads them (harness/includes.php of the sparkbox tests)
 */
include_once(TESTS_PATH . "/harness/includes.php");

test("strict includes: every class a site file uses is reachable through its own include_once chain", function () {
    $core = realpath((string)(getenv("SPARK_SITE_INCLUDE_PATH") ?: TESTS_PATH . "/../lib"));
    $store = realpath($core . "/../../sparkstore/lib");
    if (!$core || !$store) skip("core or store lib not found");
    $site = realpath(__DIR__ . "/..");
    $missing = includesMissing(array($core, $store, $site), "$site/class");
    assertSame(array(), $missing, "classes used without their include_once");
});
