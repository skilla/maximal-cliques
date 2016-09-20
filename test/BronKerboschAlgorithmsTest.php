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

        $algorithm->setRVector([]);
        $algorithm->setPVector(
            [
                23=>'Philip',
                56=>'Martha',
                17=>'Louis',
                107=>'John',
                47=>'Agnes',
                12=>'James'
            ]
        );
        $algorithm->setXVector([]);
        $algorithm->setNVector(
            [
                23=>[23=>0, 56=>1, 17=>0, 107=>0, 47=>1, 12=>0],
                56=>[23=>1, 56=>0, 17=>1, 107=>0, 47=>1, 12=>0],
                17=>[23=>0, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0],
                107=>[23=>0, 56=>0, 17=>1, 107=>0, 47=>1, 12=>1],
                47=>[23=>1, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0],
                12=>[23=>0, 56=>0, 17=>0, 107=>1, 47=>0, 12=>0]
            ]
        );
        $this->assertEquals(
            [[23,56,47],[56,17],[17,107],[107,47],[107,12]],
            $algorithm->obtainCompleteGraphsWithoutPivoting()
        );
    }

    public function testObtainCompleteGraphsWithPivoting()
    {
        $algorithm = new BronKerboschAlgorithms();
        $algorithm->setDataTransformer(new DataTransformerExample());

        $algorithm->setRVector([]);
        $algorithm->setPVector(
            [
                23=>'Philip',
                56=>'Martha',
                17=>'Louis',
                107=>'John',
                47=>'Agnes',
                12=>'James'
            ]
        );
        $algorithm->setXVector([]);
        $algorithm->setNVector(
            [
                23=>[23=>0, 56=>1, 17=>0, 107=>0, 47=>1, 12=>0],
                56=>[23=>1, 56=>0, 17=>1, 107=>0, 47=>1, 12=>0],
                17=>[23=>0, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0],
                107=>[23=>0, 56=>0, 17=>1, 107=>0, 47=>1, 12=>1],
                47=>[23=>1, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0],
                12=>[23=>0, 56=>0, 17=>0, 107=>1, 47=>0, 12=>0]
            ]
        );
        $this->assertEquals(
            [[23,47,56],[56,17],[17,107],[47,107],[12,107]],
            $algorithm->obtainCompleteGraphsWithPivoting()
        );
        $this->assertEquals(
            [23,47,56],
            $algorithm->retrieveMaximalClique()
        );
    }

    public function testObtainCompleteGraphsWithVertexOrdering()
    {
        $algorithm = new BronKerboschAlgorithms();
        $algorithm->setDataTransformer(new DataTransformerExample());

        $algorithm->setRVector([]);
        $algorithm->setPVector(
            [
                23=>'Philip',
                56=>'Martha',
                17=>'Louis',
                107=>'John',
                47=>'Agnes',
                12=>'James'
            ]
        );
        $algorithm->setXVector([]);
        $algorithm->setNVector(
            [
                23=>[23=>0, 56=>1, 17=>0, 107=>0, 47=>1, 12=>0],
                56=>[23=>1, 56=>0, 17=>1, 107=>0, 47=>1, 12=>0],
                17=>[23=>0, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0],
                107=>[23=>0, 56=>0, 17=>1, 107=>0, 47=>1, 12=>1],
                47=>[23=>1, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0],
                12=>[23=>0, 56=>0, 17=>0, 107=>1, 47=>0, 12=>0]
            ]
        );
        $this->assertEquals(
            [[12,107],[17,107],[17,56],[23,47,56],[107,47]],
            $algorithm->obtainCompleteGraphsWithVertexOrdering()
        );
    }

    public function testObtainCompleteGraphsWithVertexOrderingForVertex()
    {
        $algorithm = new BronKerboschAlgorithms();
        $algorithm->setDataTransformer(new DataTransformerExample());

        $algorithm->setRVector([]);
        $algorithm->setPVector(
            [
                23=>'Philip',
                56=>'Martha',
                17=>'Louis',
                107=>'John',
                47=>'Agnes',
                12=>'James'
            ]
        );
        $algorithm->setXVector([]);
        $algorithm->setNVector(
            [
                23=>[23=>0, 56=>1, 17=>0, 107=>0, 47=>1, 12=>0],
                56=>[23=>1, 56=>0, 17=>1, 107=>0, 47=>1, 12=>0],
                17=>[23=>0, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0],
                107=>[23=>0, 56=>0, 17=>1, 107=>0, 47=>1, 12=>1],
                47=>[23=>1, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0],
                12=>[23=>0, 56=>0, 17=>0, 107=>1, 47=>0, 12=>0]
            ]
        );
        $this->assertEquals(
            [[47,56,23]],
            $algorithm->obtainCompleteGraphsWithVertexOrderingForVertex(23)
        );
        $this->assertEquals(
            [[107,12]],
            $algorithm->obtainCompleteGraphsWithVertexOrderingForVertex(12)
        );
        $this->assertEquals(
            [],
            $algorithm->obtainCompleteGraphsWithVertexOrderingForVertex(1)
        );
    }

    public function testObtainCompleteGraphsWithVertexOrderingWithMinimumDegree()
    {
        $algorithm = new BronKerboschAlgorithms();
        $algorithm->setDataTransformer(new DataTransformerExample());

        $algorithm->setRVector([]);
        $algorithm->setPVector(
            [
                23=>'Philip',
                56=>'Martha',
                17=>'Louis',
                107=>'John',
                47=>'Agnes',
                12=>'James'
            ]
        );
        $algorithm->setXVector([]);
        $algorithm->setNVector(
            [
                23=>[23=>0, 56=>1, 17=>0, 107=>0, 47=>1, 12=>0],
                56=>[23=>1, 56=>0, 17=>1, 107=>0, 47=>1, 12=>0],
                17=>[23=>0, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0],
                107=>[23=>0, 56=>0, 17=>1, 107=>0, 47=>1, 12=>1],
                47=>[23=>1, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0],
                12=>[23=>0, 56=>0, 17=>0, 107=>1, 47=>0, 12=>0]
            ]
        );
        $this->assertEquals(
            [[23,47,56]],
            $algorithm->obtainCompleteGraphsWithVertexOrderingWithMinimumDegree(2)
        );
        $this->assertEquals(
            [[12,107],[17,107],[17,56],[23,47,56],[107,47]],
            $algorithm->obtainCompleteGraphsWithVertexOrderingWithMinimumDegree(1)
        );
        $this->assertEquals(
            [],
            $algorithm->obtainCompleteGraphsWithVertexOrderingWithMinimumDegree(3)
        );
    }

    public function testObtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree()
    {
        $algorithm = new BronKerboschAlgorithms();
        $algorithm->setDataTransformer(new DataTransformerExample());

        $algorithm->setRVector([]);
        $algorithm->setPVector(
            [
                23=>'Philip',
                56=>'Martha',
                17=>'Louis',
                107=>'John',
                47=>'Agnes',
                12=>'James'
            ]
        );
        $algorithm->setXVector([]);
        $algorithm->setNVector(
            [
                23=>[23=>0, 56=>1, 17=>0, 107=>0, 47=>1, 12=>0],
                56=>[23=>1, 56=>0, 17=>1, 107=>0, 47=>1, 12=>0],
                17=>[23=>0, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0],
                107=>[23=>0, 56=>0, 17=>1, 107=>0, 47=>1, 12=>1],
                47=>[23=>1, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0],
                12=>[23=>0, 56=>0, 17=>0, 107=>1, 47=>0, 12=>0]
            ]
        );
        $this->assertEquals(
            [[47,56,23]],
            $algorithm->obtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree(23, 2)
        );
        $this->assertEquals(
            [],
            $algorithm->obtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree(12, 2)
        );
        $this->assertEquals(
            [[17,107],[12,107],[47,107]],
            $algorithm->obtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree(107, 1)
        );
    }

    public function testVectorNEmpty()
    {
        $algorithm = new BronKerboschAlgorithms();
        $algorithm->setDataTransformer(new DataTransformerExample());

        $algorithm->setRVector([]);
        $algorithm->setPVector(
            [
                23=>'Philip',
                56=>'Martha',
                17=>'Louis',
                107=>'John',
                47=>'Agnes',
                12=>'James'
            ]
        );
        $algorithm->setXVector([]);
        $algorithm->setNVector(
            [
                 23=>[23=>0, 56=>0, 17=>0, 107=>0, 47=>0, 12=>0],
                 56=>[23=>0, 56=>0, 17=>0, 107=>0, 47=>0, 12=>0],
                 17=>[23=>0, 56=>0, 17=>0, 107=>0, 47=>0, 12=>0],
                107=>[23=>0, 56=>0, 17=>0, 107=>0, 47=>0, 12=>0],
                 47=>[23=>0, 56=>0, 17=>0, 107=>0, 47=>0, 12=>0],
                 12=>[23=>0, 56=>0, 17=>0, 107=>0, 47=>0, 12=>0]
            ]
        );
        $this->assertEquals(
            [[23], [56], [17], [107], [47], [12]],
            $algorithm->obtainCompleteGraphsWithoutPivoting()
        );
        $this->assertEquals(
            [],
            $algorithm->obtainCompleteGraphsWithPivoting()
        );
        $this->assertEquals(
            [],
            $algorithm->obtainCompleteGraphsWithVertexOrdering()
        );
    }
}
