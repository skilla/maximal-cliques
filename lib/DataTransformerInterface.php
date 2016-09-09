<?php
/**
 * Created by PhpStorm.
 * User: Skilla <sergio.zambrano@gmail.com>
 * Date: 8/9/16
 * Time: 23:51
 */

namespace Skilla\MaximaCliques\Lib;

interface DataTransformerInterface
{
    function obtainR(array $R);

    function ontainP(array $P);

    function obtainX(array $X);
}