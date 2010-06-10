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

/*----------------------*
 | Library/Registry.php |
 *----------------------*/

namespace yFramework ; 

/**
 * Stores all variables for a Yocto-Framework application. 
 */

class Registry {

    protected static $_registry = array() ; 

    // Fonctions nécessaire pour le singleton
    protected function __construct () {}
    protected function __clone () {}

    /**
     * public static mixed get ( string pName, mixed pDefault ) 
     *   Retrieve a config parameter.
     *
     * Params : 
     *      string  pName       A config parameter name
     *      mixed   pDefault    A default config parameter value
     */
    public static function get ($pName, $pDefault = null) {

        return isset(self::$_registry[$pName]) ?
                    self::$_registry[$pName] : $pDefault ; 
    }

    /**
     * public static boll has ( string pName ) 
     */
    public static function has ($pName) {

        return array_key_exists($pName, self::$_registry) ; 
    }

    /**
     * delete an entry
     *
     * @param string pName
     */
    public static function delete ($pName) {
        
        if (self::has($pName))
            unset(self::_$registry[$pName]) ; 
    }

    /**
     * public static void set ( string pName, mixed pValue )
     *   Sets a config parameter.
     *
     * If a config parameter with the name already exists the value will 
     * be overridden.
     *
     * Params : 
     *      string  pName   A config parameter name
     *      mixed   pValue  A config parameter value
     */
    public static function set ($pName, $pValue) {

        self::$_registry[$pName] = $pValue ;
    }

    /**
     * public static array getAll ( void ) 
     *   Retrieves all configuration parameters.
     */
    public static function getAll () {

        return self::$_registry ;
    }

    /**
     * public static void clear ( void ) 
     *   Clears all current config parameters.
     */
    public static function clear () {

        self::$_registry = array() ;
    }
}
