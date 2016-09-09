<?php
/**
 * Created by PhpStorm.
 * User: Skilla <sergio.zambrano@gmail.com>
 * Date: 8/9/16
 * Time: 20:29
 */

namespace Skilla\MaximalCliques\Test;

use Skilla\MaximalCliques\Lib\BronKerboschAlgorithms;

include_once "lib/BronKerboschAlgorithms.php";

class BronKerboschAlgorithmsTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiation()
    {
        $instance = new BronKerboschAlgorithms();
    }

    public function testNodeData()
    {
        $instance = new BronKerboschAlgorithms();
        $this->assertEquals([1,2,3,4,5,6], $instance->obtainRawNodes());

    }
}
