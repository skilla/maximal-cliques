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
            [[23,47,56],[56,17],[17,107],[47,107],[12,107]],
            $algorithm->obtainCompleteGraphsWithVertexOrdering()
        );
    }
}
