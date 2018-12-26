<?php
include( "vendor/autoload.php");
$lineSearcher = new \Awork\Searcher\SubstringLineSearcher();
$lineSearcher->openFile('LICENSE');
echo '<pre>';

foreach ($lineSearcher->find('source code') as $result) {
    var_dump($result);
}

echo '</pre>';