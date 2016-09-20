<?php
/**
 * Created by PhpStorm.
 * User: Skilla <sergio.zambrano@gmail.com>
 * Date: 9/9/16
 * Time: 0:40
 */

namespace Skilla\MaximalCliques\lib;

class DataTransformerExample implements DataTransformerInterface
{
    function obtainRVector(array $rVector)
    {
        return array_keys($rVector);
    }

    function obtainPVector(array $pVector)
    {
        return array_keys($pVector);
    }

    function obtainXVector(array $xVector)
    {
        return array_keys($xVector);
    }

    function obtainNVector(array $nVector)
    {
        $cleanNVector = array();
        foreach ($nVector as $x => $values) {
            foreach ($values as $y => $value) {
                if ($value==1) {
                    if ($x>$y) {
                        $cleanNVector["$y#$x"] = array($y, $x);
                    } else {
                        $cleanNVector["$x#$y"] = array($x, $y);
                    }
                }
            }
        }
        return array_values($cleanNVector);
    }
}
