<?php

require __DIR__ . '/../myApp/MyAppKernel.php' ; 

$kernel = new MyAppKernel('dev', true) ;
$kernel->run() ; 
