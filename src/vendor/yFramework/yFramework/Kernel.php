<?php

/*
  This file is part of Yocto-Framework package. 

  Copyright (C) 2010 Grégoire OLIVEIRA SILVA <os.gregoire@laposte.net>

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License along
  with this program; if not, write to the Free Software Foundation, Inc.,
  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

/*--------------------*
 | Library/Kernel.php |
 *--------------------*/

namespace yFramework ; 

use \yFramework\Registry as Registry ; 

/**
 * Manages an environment that can host bundles
 */
abstract class Kernel {

    protected $_bundles ; 
    protected $_bundleDirs ; 
    protected $_container ; 
    protected $_rootDir ; 
    protected $_environment ; 
    protected $_debug ; 
    protected $_booted ; 
    protected $_name ; 
    protected $_parameters ; 
    protected $_startTime ; 
    protected $_root ; 

    const VERSION = '0.1.0-DEV' ; 

    /**
     * Constructor
     *
     * @param string  pEnvironment The environment
     * @param boolean pDebug       Whether to enable debugging or not
     * @param array   pParameters  An array of parameters to customize the
     *                             DI container
     */
    public function __construct ($pEnvironment, $pDebug, 
                                                    $pParameters = array()) {

        $this->_debug = (Boolean) $pDebug ; 
        if ($this->_debug) {

            ini_set('display_errors', 1) ; 
            error_reporting(-1) ; 
            $this->_startTime = microtime(true) ; 
        }
        else
            ini_set('display_errors', 0) ;

        $this->_booted      = false ; 
        $this->_environment = $pEnvironment ; 
        $this->_parameters  = $pParameters ; 
        $this->_bundles     = $this->registerBundles() ; 
        $this->bundlesDirs  = $this->registerBundleDirs() ; 
        $this->_rootDir     = realpath($this->registerRootDir()) ; 
        $this->_name        = basename($this->_rootDir) ;
        $this->_root        = new \yFramework\Protocol\Root() ; 

        $this->saveRegistry() ; 
    }

    /**
     * save all attributes in Registry
     */
    public function saveRegistry () {

        Registry::set('environment',  $this->_environment) ; 
        Registry::set('rootDir',      $this->_rootDir) ;
        Registry::set('debug',        $this->_debug) ; 
        Registry::set('name',         $this->_name) ; 
        Registry::set('protocolRoot', $this->_root) ; 
    }

    abstract public function registerRootDir () ; 
    abstract public function registerBundles () ; 
    abstract public function registerBundleDirs () ; 
    abstract public function registerContainerConfiguration () ; 
    abstract public function registerRoutes () ; 
    abstract public function registerProtocol () ; 

    /**
     * Set protocol
     */
    public function setProtocol () {

        $protocol = $this->registerProtocol()->unlinearizeBranche('protocol') ;

        foreach ($protocol as $path => $reach)
            $this->_root->addComponentHelper($path, $reach, true) ; 
    }
}
