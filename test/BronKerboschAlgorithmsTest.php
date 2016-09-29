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
            $this->recurviveSort([[23,56,47],[56,17],[17,107],[107,47],[107,12]]),
            $this->recurviveSort($algorithm->obtainCompleteGraphsWithoutPivoting())
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
            $this->recurviveSort([[23,47,56],[56,17],[17,107],[47,107],[12,107]]),
            $this->recurviveSort($algorithm->obtainCompleteGraphsWithPivoting())
        );
        $this->assertEquals(
            $this->recurviveSort([23,47,56]),
            $this->recurviveSort($algorithm->retrieveMaximalClique())
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
            $this->recurviveSort([[12,107],[17,107],[17,56],[23,47,56],[107,47]]),
            $this->recurviveSort($algorithm->obtainCompleteGraphsWithVertexOrdering())
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
            $this->recurviveSort([[47,56,23]]),
            $this->recurviveSort($algorithm->obtainCompleteGraphsWithVertexOrderingForVertex(23))
        );
        $this->assertEquals(
            $this->recurviveSort([[107,12]]),
            $this->recurviveSort($algorithm->obtainCompleteGraphsWithVertexOrderingForVertex(12))
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
            $this->recurviveSort([[23,47,56]]),
            $this->recurviveSort($algorithm->obtainCompleteGraphsWithVertexOrderingWithMinimumDegree(2))
        );
        $this->assertEquals(
            $this->recurviveSort([[12,107],[17,107],[17,56],[23,47,56],[107,47]]),
            $this->recurviveSort($algorithm->obtainCompleteGraphsWithVertexOrderingWithMinimumDegree(1))
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
            $this->recurviveSort([[47,56,23]]),
            $this->recurviveSort($algorithm->obtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree(23, 2))
        );
        $this->assertEquals(
            [],
            $algorithm->obtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree(12, 2)
        );
        $this->assertEquals(
            $this->recurviveSort([[47,107],[17,107],[12,107]]),
            $this->recurviveSort($algorithm->obtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree(107, 1))
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
            $this->recurviveSort([[23], [56], [17], [107], [47], [12]]),
            $this->recurviveSort($algorithm->obtainCompleteGraphsWithoutPivoting())
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

    private function recurviveSort(array $source)
    {
        if (empty($source)) {
            return $source;
        }
        $keys = array_keys($source);
        $key = $keys[0];
        if (is_array($source[$key])) {
            foreach ($keys as $key) {
                $source[$key] = $this->recurviveSort($source[$key]);
            }
            usort($source, array($this, 'sizeCompare'));
        } else {
            sort($source);
        }
        return $source;
    }

    private function sizeCompare($first, $second)
    {
        if (count($first) == count($second)) {
            $sumFirst = is_array($first) ? array_sum($first) : (int)$first;
            $sumSecond = is_array($second) ? array_sum($second) : (int)$second;
            if ($sumFirst == $sumSecond) {
                return 0;
            }
            return $sumFirst > $sumSecond ? -1 : 1;
        }
        return (count($first) > count($second)) ? -1 : 1;
    }
}
