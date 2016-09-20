<?php
/**
 * Created by PhpStorm.
 * User: Skilla <sergio.zambrano@gmail.com>
 * Date: 8/9/16
 * Time: 20:29
 */

namespace Skilla\MaximalCliques\test;

use Skilla\MaximalCliques\lib\BronKerboschAlgorithms;
use Skilla\MaximalCliques\lib\DataTransformerExample;

class BronKerboschAlgorithmsTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiation()
    {
        $algorithm = new BronKerboschAlgorithms();
        $this->assertInstanceOf('Skilla\MaximalCliques\lib\BronKerboschAlgorithms', $algorithm);
    }

    public function testObtainCompleteGraphsWithoutPivoting()
    {
        $algorithm = new BronKerboschAlgorithms();
        $algorithm->setDataTransformer(new DataTransformerExample());

        $algorithm->setRVector(array());
        $algorithm->setPVector(
            array(
                23=>'Philip',
                56=>'Martha',
                17=>'Louis',
                107=>'John',
                47=>'Agnes',
                12=>'James'
            )
        );
        $algorithm->setXVector(array());
        $algorithm->setNVector(
            array(
                23=>array(23=>0, 56=>1, 17=>0, 107=>0, 47=>1, 12=>0),
                56=>array(23=>1, 56=>0, 17=>1, 107=>0, 47=>1, 12=>0),
                17=>array(23=>0, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0),
                107=>array(23=>0, 56=>0, 17=>1, 107=>0, 47=>1, 12=>1),
                47=>array(23=>1, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0),
                12=>array(23=>0, 56=>0, 17=>0, 107=>1, 47=>0, 12=>0)
            )
        );
        $this->assertEquals(
            array(array(23,56,47),array(56,17),array(17,107),array(107,47),array(107,12)),
            $algorithm->obtainCompleteGraphsWithoutPivoting()
        );
    }

    public function testObtainCompleteGraphsWithPivoting()
    {
        $algorithm = new BronKerboschAlgorithms();
        $algorithm->setDataTransformer(new DataTransformerExample());

        $algorithm->setRVector(array());
        $algorithm->setPVector(
            array(
                23=>'Philip',
                56=>'Martha',
                17=>'Louis',
                107=>'John',
                47=>'Agnes',
                12=>'James'
            )
        );
        $algorithm->setXVector(array());
        $algorithm->setNVector(
            array(
                23=>array(23=>0, 56=>1, 17=>0, 107=>0, 47=>1, 12=>0),
                56=>array(23=>1, 56=>0, 17=>1, 107=>0, 47=>1, 12=>0),
                17=>array(23=>0, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0),
                107=>array(23=>0, 56=>0, 17=>1, 107=>0, 47=>1, 12=>1),
                47=>array(23=>1, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0),
                12=>array(23=>0, 56=>0, 17=>0, 107=>1, 47=>0, 12=>0)
            )
        );
        $this->assertEquals(
            array(array(23,47,56),array(56,17),array(17,107),array(47,107),array(12,107)),
            $algorithm->obtainCompleteGraphsWithPivoting()
        );
        $this->assertEquals(
            array(23,47,56),
            $algorithm->retrieveMaximalClique()
        );
    }

    public function testObtainCompleteGraphsWithVertexOrdering()
    {
        $algorithm = new BronKerboschAlgorithms();
        $algorithm->setDataTransformer(new DataTransformerExample());

        $algorithm->setRVector(array());
        $algorithm->setPVector(
            array(
                23=>'Philip',
                56=>'Martha',
                17=>'Louis',
                107=>'John',
                47=>'Agnes',
                12=>'James'
            )
        );
        $algorithm->setXVector(array());
        $algorithm->setNVector(
            array(
                23=>array(23=>0, 56=>1, 17=>0, 107=>0, 47=>1, 12=>0),
                56=>array(23=>1, 56=>0, 17=>1, 107=>0, 47=>1, 12=>0),
                17=>array(23=>0, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0),
                107=>array(23=>0, 56=>0, 17=>1, 107=>0, 47=>1, 12=>1),
                47=>array(23=>1, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0),
                12=>array(23=>0, 56=>0, 17=>0, 107=>1, 47=>0, 12=>0)
            )
        );
        $this->assertEquals(
            array(array(12,107),array(17,107),array(17,56),array(23,47,56),array(107,47)),
            $algorithm->obtainCompleteGraphsWithVertexOrdering()
        );
    }

    public function testObtainCompleteGraphsWithVertexOrderingForVertex()
    {
        $algorithm = new BronKerboschAlgorithms();
        $algorithm->setDataTransformer(new DataTransformerExample());

        $algorithm->setRVector(array());
        $algorithm->setPVector(
            array(
                23=>'Philip',
                56=>'Martha',
                17=>'Louis',
                107=>'John',
                47=>'Agnes',
                12=>'James'
            )
        );
        $algorithm->setXVector(array());
        $algorithm->setNVector(
            array(
                23=>array(23=>0, 56=>1, 17=>0, 107=>0, 47=>1, 12=>0),
                56=>array(23=>1, 56=>0, 17=>1, 107=>0, 47=>1, 12=>0),
                17=>array(23=>0, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0),
                107=>array(23=>0, 56=>0, 17=>1, 107=>0, 47=>1, 12=>1),
                47=>array(23=>1, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0),
                12=>array(23=>0, 56=>0, 17=>0, 107=>1, 47=>0, 12=>0)
            )
        );
        $this->assertEquals(
            array(array(47,56,23)),
            $algorithm->obtainCompleteGraphsWithVertexOrderingForVertex(23)
        );
        $this->assertEquals(
            array(array(107,12)),
            $algorithm->obtainCompleteGraphsWithVertexOrderingForVertex(12)
        );
        $this->assertEquals(
            array(),
            $algorithm->obtainCompleteGraphsWithVertexOrderingForVertex(1)
        );
    }

    public function testObtainCompleteGraphsWithVertexOrderingWithMinimumDegree()
    {
        $algorithm = new BronKerboschAlgorithms();
        $algorithm->setDataTransformer(new DataTransformerExample());

        $algorithm->setRVector(array());
        $algorithm->setPVector(
            array(
                23=>'Philip',
                56=>'Martha',
                17=>'Louis',
                107=>'John',
                47=>'Agnes',
                12=>'James'
            )
        );
        $algorithm->setXVector(array());
        $algorithm->setNVector(
            array(
                23=>array(23=>0, 56=>1, 17=>0, 107=>0, 47=>1, 12=>0),
                56=>array(23=>1, 56=>0, 17=>1, 107=>0, 47=>1, 12=>0),
                17=>array(23=>0, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0),
                107=>array(23=>0, 56=>0, 17=>1, 107=>0, 47=>1, 12=>1),
                47=>array(23=>1, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0),
                12=>array(23=>0, 56=>0, 17=>0, 107=>1, 47=>0, 12=>0)
            )
        );
        $this->assertEquals(
            array(array(23,47,56)),
            $algorithm->obtainCompleteGraphsWithVertexOrderingWithMinimumDegree(2)
        );
        $this->assertEquals(
            array(array(12,107),array(17,107),array(17,56),array(23,47,56),array(107,47)),
            $algorithm->obtainCompleteGraphsWithVertexOrderingWithMinimumDegree(1)
        );
        $this->assertEquals(
            array(),
            $algorithm->obtainCompleteGraphsWithVertexOrderingWithMinimumDegree(3)
        );
    }

    public function testObtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree()
    {
        $algorithm = new BronKerboschAlgorithms();
        $algorithm->setDataTransformer(new DataTransformerExample());

        $algorithm->setRVector(array());
        $algorithm->setPVector(
            array(
                23=>'Philip',
                56=>'Martha',
                17=>'Louis',
                107=>'John',
                47=>'Agnes',
                12=>'James'
            )
        );
        $algorithm->setXVector(array());
        $algorithm->setNVector(
            array(
                23=>array(23=>0, 56=>1, 17=>0, 107=>0, 47=>1, 12=>0),
                56=>array(23=>1, 56=>0, 17=>1, 107=>0, 47=>1, 12=>0),
                17=>array(23=>0, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0),
                107=>array(23=>0, 56=>0, 17=>1, 107=>0, 47=>1, 12=>1),
                47=>array(23=>1, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0),
                12=>array(23=>0, 56=>0, 17=>0, 107=>1, 47=>0, 12=>0)
            )
        );
        $this->assertEquals(
            array(array(47,56,23)),
            $algorithm->obtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree(23, 2)
        );
        $this->assertEquals(
            array(),
            $algorithm->obtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree(12, 2)
        );
        $this->assertEquals(
            array(array(47,107),array(17,107),array(12,107)),
            $algorithm->obtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree(107, 1)
        );
    }

    public function testVectorNEmpty()
    {
        $algorithm = new BronKerboschAlgorithms();
        $algorithm->setDataTransformer(new DataTransformerExample());
        $algorithm->setRVector(array());
        $algorithm->setPVector(
            array(
                23=>'Philip',
                56=>'Martha',
                17=>'Louis',
                107=>'John',
                47=>'Agnes',
                12=>'James'
            )
        );
        $algorithm->setXVector(array());
        $algorithm->setNVector(
            array(
                 23=>array(23=>0, 56=>0, 17=>0, 107=>0, 47=>0, 12=>0),
                 56=>array(23=>0, 56=>0, 17=>0, 107=>0, 47=>0, 12=>0),
                 17=>array(23=>0, 56=>0, 17=>0, 107=>0, 47=>0, 12=>0),
                107=>array(23=>0, 56=>0, 17=>0, 107=>0, 47=>0, 12=>0),
                 47=>array(23=>0, 56=>0, 17=>0, 107=>0, 47=>0, 12=>0),
                 12=>array(23=>0, 56=>0, 17=>0, 107=>0, 47=>0, 12=>0)
            )
        );
        $this->assertEquals(
            array(array(23), array(56), array(17), array(107), array(47), array(12)),
            $algorithm->obtainCompleteGraphsWithoutPivoting()
        );
        $this->assertEquals(
            array(),
            $algorithm->obtainCompleteGraphsWithPivoting()
        );
        $this->assertEquals(
            array(),
            $algorithm->obtainCompleteGraphsWithVertexOrdering()
        );

        $algorithm = new BronKerboschAlgorithms();
        $algorithm->setDataTransformer(new DataTransformerExample());
        $algorithm->setRVector(array());
        $algorithm->setPVector(
            array(
                23=>'Philip',
            )
        );
        $algorithm->setXVector(array());
        $algorithm->setNVector(
            array(
                23 => array(23 => 0)
            )
        );
        $this->assertEquals(
            array(),
            $algorithm->obtainCompleteGraphsWithVertexOrderingForVertex(23)
        );
    }
}
