<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Route{
    
     public static $validRoutes=array();
    
    public static function set($route,$function){
        self::$validRoutes[]=$route;
        if ((isset($_GET['url'])? $_GET['url']:'') == $route) {
            $function->__invoke();
        }
    }
    
}