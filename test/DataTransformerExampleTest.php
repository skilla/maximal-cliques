<?php
/**
 * Created by PhpStorm.
 * User: Skilla <sergio.zambrano@gmail.com>
 * Date: 10/9/16
 * Time: 8:04
 */

namespace Skilla\MaximalCliques\test;

use Skilla\MaximalCliques\lib\DataTransformerExample;

class DataTransformerExampleTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiation()
    {
        $dataTransformer = new DataTransformerExample();
        $this->assertInstanceOf(
            'Skilla\MaximalCliques\lib\DataTransformerInterface',
            $dataTransformer
        );
    }

    public function testObtainRVector()
    {
        $data = array(23=>'Philip', 56=>'Martha', 17=>'Louis', 107=>'John', 47=>'Agnes', 12=>'James');
        $dataTransformer = new DataTransformerExample();
        $r = $dataTransformer->obtainRVector($data);
        $this->assertEquals(array(23, 56, 17, 107, 47, 12), $r);
    }

    public function testObtainPVector()
    {
        $data = array(23=>'Philip', 56=>'Martha', 17=>'Louis', 107=>'John', 47=>'Agnes', 12=>'James');
        $dataTransformer = new DataTransformerExample();
        $p = $dataTransformer->obtainPVector($data);
        $this->assertEquals(array(23, 56, 17, 107, 47, 12), $p);
    }

    public function testObtainXVector()
    {
        $data = array(23=>'Philip', 56=>'Martha', 17=>'Louis', 107=>'John', 47=>'Agnes', 12=>'James');
        $dataTransformer = new DataTransformerExample();
        $x = $dataTransformer->obtainXVector($data);
        $this->assertEquals(array(23, 56, 17, 107, 47, 12), $x);
    }

    public function testObtainNVector()
    {
        $data = array(
            23=>array(23=>0, 56=>1, 17=>0, 107=>0, 47=>1, 12=>0),
            56=>array(23=>1, 56=>0, 17=>1, 107=>0, 47=>1, 12=>0),
            17=>array(23=>0, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0),
           107=>array(23=>0, 56=>0, 17=>1, 107=>0, 47=>1, 12=>1),
            47=>array(23=>1, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0),
            12=>array(23=>0, 56=>0, 17=>0, 107=>1, 47=>0, 12=>0)
        );
        $dataTransformer = new DataTransformerExample();
        $n = $dataTransformer->obtainNVector($data);

        $this->assertEquals(
            array(
                array(23,56),
                array(23,47),
                array(17,56),
                array(47,56),
                array(17,107),
                array(47,107),
                array(12,107)
            ),
            $n
        );
    }
}
