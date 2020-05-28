<?php
include_once("session.php");

$defines->dump();

test("test1", "test2");

function test(string ...$columns) {
    echo "Test Count: ".count($columns);
    test2(...$columns);
}
function test2(string ...$columns)
{
    echo "Test2 Count: ".count($columns);
}
?>
