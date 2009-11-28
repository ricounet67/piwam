<?php
include(dirname(__FILE__).'/../bootstrap/unit.php');

$t      = new lime_test(4, new lime_output_color());

$t->is(StringTools::to7bit('easy test'),            'easy test',        'No modification');
$t->is(StringTools::to7bit('test accentué'),        'test accentue',    'With basic accent');
$t->is(StringTools::to7bit('àéêÔÊÂÇòè'),            'aeeOEACoe',        'Complex acents and cedilla');
$t->is(StringTools::to7bit('||πñàéêÔÊÂÇòèø'),       'pnaeeOEACoeo',     'Complex acents, cedilla and special chars');
?>