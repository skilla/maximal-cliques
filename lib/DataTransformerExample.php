<?php
/**
 * Created by PhpStorm.
 * User: Skilla <sergio.zambrano@gmail.com>
 * Date: 9/9/16
 * Time: 0:40
 */

namespace Skilla\MaximalCliques\lib;

use Skilla\MaximalCliques\lib\DataTransformerInterface;

class DataTransformerExample implements DataTransformerInterface
{
    function obtainRVector(array $R)
    {
        return array_keys($R);
    }

    function obtainPVector(array $P)
    {
        return array_keys($P);
    }

    function obtainXVector(array $X)
    {
        return array_keys($X);
    }

    function obtainNVector(array $N)
    {
        $nVector = [];
        foreach ($N as $x => $values) {
            foreach ($values as $y => $value) {
                if ($value==1) {
                    if ($x>$y) {
                        $nVector["$y#$x"] = [$y, $x];
                    } else {
                        $nVector["$x#$y"] = [$x, $y];
                    }
                }
            }
        }
        return array_values($nVector);
    }
}
