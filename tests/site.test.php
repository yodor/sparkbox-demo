<?php
/**
 * sparkbox demo: the core front files are linked, every demo page renders, the old scripts answer 301, a form is
 * validated, the admin of the demo gallery. Needs SPARK_ADMIN_EMAIL / SPARK_ADMIN_PASSWORD for the admin test.
 */
include_once(TESTS_PATH . "/harness/http.php");

if (!defined("SITE_ROOT")) define("SITE_ROOT", __DIR__ . "/..");

function siteOptions(array $extra = array()) : array
{
    $options = array("root" => realpath(SITE_ROOT));
    if (getenv("SPARK_SITE_INCLUDE_PATH")) $options["include_path"] = getenv("SPARK_SITE_INCLUDE_PATH");
    if (getenv("SPARK_SITE_PREPEND")) $options["prepend"] = getenv("SPARK_SITE_PREPEND");
    return array_merge($options, $extra);
}

function demoPage(string $path, array $params = array(), ?array $post = null) : array
{
    $query = http_build_query(array_merge(array("path" => $path), $params));
    $extra = is_null($post) ? array() : array("post" => $post);
    return httpRequest("index.php", $query, array(), $path . (count($params) ? "?" . http_build_query($params) : ""), siteOptions($extra));
}

function assertCleanPage(array $response, string $label, int $status = 200) : void
{
    assertSame($status, $response[0], "$label status");
    foreach (array("SQLSTATE", "Fatal error", "<b>Warning</b>", "<b>Deprecated</b>", "Uncaught", "RenderError", "<title>Error:") as $marker) {
        assertTrue(!str_contains($response[2], $marker), "$label contains '$marker'");
    }
}

test("the core front files are linked in the document root (sparkfront)", function () {
    foreach (array("css/theme.css", "css/MenuBar.css", "css/SparkSitePage.css", "js/ContentFragment.js") as $file) {
        assertTrue(is_file(SITE_ROOT . "/sparkfront/" . $file), "sparkfront/$file missing - link sparkbox/sparkfront into the document root");
    }
});

test("every demo page renders in the demo frame", function () {
    foreach (array("/" => "SparkBox Demo", "/controls" => "Input Controls", "/controls/arrays" => "Array Controls",
                 "/controls/uploads" => "Uploads", "/controls/editor" => "Text Editor", "/dialogs" => "Dialogs",
                 "/gallery" => "Image Gallery", "/tree" => "Tree View", "/menus" => "Menus", "/fragments" => "Fragments") as $path => $title) {
        $response = demoPage($path);
        assertCleanPage($response, $path);
        assertTrue(str_contains($response[2], "<title>$title"), "$path title");
        assertTrue(str_contains($response[2], "class='site_menu'"), "$path frame");
    }
    assertCleanPage(demoPage("/nosuch"), "unknown path", 404);
});

test("the old scripts answer 301 to their paths", function () {
    foreach (array("/controls.php" => "/controls", "/array_controls.php" => "/controls/arrays", "/gallery.php" => "/gallery",
                 "/news.php" => "/news/") as $old => $target) {
        [$status, $headers] = demoPage($old);
        assertSame(301, $status, $old);
        assertTrue(str_ends_with($headers["location"] ?? "", $target), "$old -> " . ($headers["location"] ?? ""));
    }
});

test("the input controls: a submit without the required values shows the errors, a valid one the alert", function () {
    [, , $body] = demoPage("/controls", array(), array("SubmitForm" => "InputForm"));
    assertTrue(str_contains($body, "error"), "the errors of the required inputs");
    [, , $body] = demoPage("/controls", array(), array("SubmitForm" => "InputForm", "text" => "a", "email" => "demo@example.com",
        "select" => "1", "accept" => "1", "radio" => "Radio 1"));
    assertTrue(str_contains($body, "The form is valid"), "the alert of a valid form");
});

test("the tree view has its sample nodes; a fragment of a demo page answers JSON", function () {
    [, , $body] = demoPage("/tree");
    assertTrue(str_contains($body, "Computer") && str_contains($body, "Bluetooth"), "the sample tree");
    $query = "path=%2Ftree&JSONRequest=1&responder=ContentFragmentResponder&function=render";
    [$status, , $body] = httpRequest("index.php", $query, array(), "/tree?" . $query, siteOptions());
    $json = json_decode($body, true);
    assertSame("OK", $json["status"] ?? "", substr($body, 0, 200));
    assertTrue(str_contains((string)$json["contents"], "Computer") && !str_contains((string)$json["contents"], "site_menu"), "the content alone");
});

test("the admin of the demo gallery", function () {
    $email = getenv("SPARK_ADMIN_EMAIL");
    $password = getenv("SPARK_ADMIN_PASSWORD");
    if (!$email || !$password) skip("SPARK_ADMIN_EMAIL / SPARK_ADMIN_PASSWORD not set");
    [, $headers, $body] = httpRequest("admin_login.php", http_build_query(array("email" => $email, "password" => $password)),
        array(), "", siteOptions(array("script_file" => realpath(TESTS_PATH . "/harness/admin_login.php"))));
    assertTrue(str_contains($body, "LOGGED_IN"), "admin login failed");
    $cookies = implode("; ", $headers["set-cookie"]);
    foreach (array("path=%2Fdemo%2Fgallery", "path=%2Fdemo%2Fgallery&editID=-1") as $query) {
        $response = httpRequest("admin/index.php", $query, array("Cookie" => $cookies), "", siteOptions());
        assertCleanPage($response, $query);
    }
});
