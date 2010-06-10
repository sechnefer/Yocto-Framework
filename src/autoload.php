<?php

require __DIR__ . '/vendor/yFramework/yFramework/UniversalClassLoader.php' ; 

use yFramework\UniversalClassLoader ; 

$loader = new UniversalClassLoader() ;
$loader->registerNamespaces(array(
    'yFramework'    => __DIR__ . '/vendor/yFramework', 
    'Application'   => __DIR__,
    'Bundle'        => __DIR__
)) ; 
$loader->registerPrefixes(array()) ; 
$loader->register() ; 
