<?php
include(dirname(__FILE__).'/../bootstrap/unit.php');

$t      = new lime_test(3, new lime_output_color());
$date1  = new DateTools('2008-12-30', 'Y-m-d');

$t->is($date1->add('mo', '1', true),    '2009-01-30',              'Add 1 month, only returning value');
$t->is($date1->add('d', '1', false),    '2008-12-31',              'Add 1 day');
$t->is($date1->add('mo', '1', false),   '2009-01-30',              'Add 1 month, dealing with 30/31 issue');
?>