<?php

namespace yFramework ; 

/**
  Copyright (c) 2004-2010 Fabien Potencier
 
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicence, and/or sell
  copies of the Software, and to permit persons to whom the Software is 
  furnished to do so, subject to the following conditions : 

  The above copyright notice and this permission notice shall be included in 
  all copies or substancial portions of the Software. 

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, 
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.
 */

/*----------------------------------*
 | Library/UniversalClassLoader.php |
 *----------------------------------*/

/**
 * UniversalClassLoader implements a "universal" autoloader for PHP 5.3.
 *
 * @package yFramework
 * @author  Fabien Potencier <fabien.potencier@symfony-project.org>
 */
class UniversalClassLoader { 

    protected $_namespaces  = array() ; 
    protected $_prefixes    = array() ; 

    /**
     * Registers an array of namespaces
     *
     * @param array $pNamespces An array of namespaces (namespaces as keys and
     *                          and locations as values)
     */
    public function registerNamespaces (array $pNamespaces) { 

        $this->_namespaces = array_merge($this->_namespaces, $pNamespaces) ; 
    }
    
    /**
     * Registers a namespace
     *
     * @param string $pNamespace The namespace
     * @param string $pPath      The location of the namespace
     */
    public function registerNamespace ($pNamespace, $pPath) {

        $this->_namespaces[$pNamespace] = $pPath ; 
    }

    /**
     * Registers an array of classes using the PEAR naming convention. 
     *
     * @param array $pPrefixes An array of classes prefixes as keys and 
     *                         locations as values)
     */
    public function registerPrefixes (array $pPrefixes) {

        $this->_prefixes = array_merge($this->_prefixes, $pPrefixes) ; 
    }

    /**
     * Registers a set of classes using the PEAR naming convention. 
     *
     * @param string $pPrefix The classes prefix
     * @param string $pPath   The location of the classes
     */ 
    public function registerPrefix ($pPrefix, $pPath) {

        $this->_prefixes[$pPrefix] = $pPath ; 
    }

    /**
     * Registers this instance as an autoloader. 
     */ 
    public function register () {

        spl_autoload_register(array($this, 'loadClass')) ; 
    }

    /**
     * Loads the given class or interface
     *
     * @param string $pClass The name of the class
     */
    public function loadClass ($pClass) {
 
        if (false !== ($pos = strripos($pClass, '\\'))) {

            // namespaced class name
            $namespace = substr($pClass, 0, $pos) ; 
 
            foreach ($this->_namespaces as $ns => $dir) {

                if (0 === strpos($namespace, $ns)) {
                    
                    $pClass = substr($pClass, $pos + 1) ; 
                    $file = $dir . DIRECTORY_SEPARATOR 
                           . str_replace('\\', DIRECTORY_SEPARATOR, $namespace)
                           . DIRECTORY_SEPARATOR 
                           . str_replace('_', DIRECTORY_SEPARATOR, $pClass) 
                           . '.php' ;
 
                    if (file_exists($file))
                        require $file ; 

                    return ; 
                }
            }
        }
        else {

            // PEAR-like class name
            foreach ($this->_prefixes as $prefix => $dir) {

                if (0 === strpos($pClass, $prefix)) {
                    
                    $file = $dir . DIRECTORY_SEPARATOR
                           . str_replace('_', DIRECTORY_SEPRATOR, $pClass)
                           . '.php' ; 

                    if (file_exists($file))
                        require $file ; 

                    return ; 
                }
            }
        }
    }
}
