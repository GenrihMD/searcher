<?php
include( "vendor/autoload.php");
$lineSearcher = new \Awork\Searcher\SubstringLineSearcher();
$lineSearcher->openFile('LICENSE');
echo '<pre>';
var_dump($lineSearcher->find('source code'));
echo '</pre>';