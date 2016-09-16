<?php
/**
 * Created by PhpStorm.
 * User: Skilla <sergio.zambrano@gmail.com>
 * Date: 11/9/16
 * Time: 10:06
 */

namespace Skilla\MaximalCliques\test;

require_once __DIR__ . '/../vendor/autoload.php';

use Skilla\MaximalCliques\lib\BronKerboschAlgorithms;
use Skilla\MaximalCliques\lib\DataTransformerExample;

$pVector = array();
$nVector = array();

function obtainCompleteGraphsWithoutPivoting($p, $n)
{
    $algorithm = new BronKerboschAlgorithms();
    $algorithm->setDataTransformer(new DataTransformerExample());

    $algorithm->setRVector(array());
    $algorithm->setPVector($p);
    $algorithm->setXVector(array());
    $algorithm->setNVector($n);

    return $algorithm->obtainCompleteGraphsWithoutPivoting();
}

function obtainCompleteGraphsWithPivoting($p, $n)
{
    $algorithm = new BronKerboschAlgorithms();
    $algorithm->setDataTransformer(new DataTransformerExample());

    $algorithm->setRVector(array());
    $algorithm->setPVector($p);
    $algorithm->setXVector(array());
    $algorithm->setNVector($n);

    return $algorithm->obtainCompleteGraphsWithPivoting();
}

function obtainCompleteGraphsWithVertexOrdering($p, $n)
{
    $algorithm = new BronKerboschAlgorithms();
    $algorithm->setDataTransformer(new DataTransformerExample());

    $algorithm->setRVector(array());
    $algorithm->setPVector($p);
    $algorithm->setXVector(array());
    $algorithm->setNVector($n);

    return $algorithm->obtainCompleteGraphsWithVertexOrdering();
}

function obtainCompleteGraphsWithVertexOrderingForVertex($p, $n, $vertex)
{
    $algorithm = new BronKerboschAlgorithms();
    $algorithm->setDataTransformer(new DataTransformerExample());

    $algorithm->setRVector(array());
    $algorithm->setPVector($p);
    $algorithm->setXVector(array());
    $algorithm->setNVector($n);

    return $algorithm->obtainCompleteGraphsWithVertexOrderingForVertex($vertex);
}

function obtainCompleteGraphsWithVertexOrderingWithMinimumDegree($p, $n, $minimumDegree)
{
    $algorithm = new BronKerboschAlgorithms();
    $algorithm->setDataTransformer(new DataTransformerExample());

    $algorithm->setRVector(array());
    $algorithm->setPVector($p);
    $algorithm->setXVector(array());
    $algorithm->setNVector($n);

    return $algorithm->obtainCompleteGraphsWithVertexOrderingWithMinimumDegree($minimumDegree);
}

function obtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree($p, $n, $vertex, $minimumDegree)
{
    $algorithm = new BronKerboschAlgorithms();
    $algorithm->setDataTransformer(new DataTransformerExample());

    $algorithm->setRVector(array());
    $algorithm->setPVector($p);
    $algorithm->setXVector(array());
    $algorithm->setNVector($n);

    return $algorithm->obtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree($vertex, $minimumDegree);
}

if (sizeof($argv)<2 || 9<(int)$argv[1] || 1>(int)$argv[1]) {
    echo "\nUsage:\n";
    echo "  php test/Performance.php x\n";
    echo "    where x is a number from 1 to 3 for performance with little data or 4 to 6 with big data\n\n";
    die();
}

$cycles = $argv[1]<'4' ? 1000 : 1;
$cliques = 0;

$time = microtime(true);

for ($a=1; $a<=$cycles; $a++) {
    switch ($argv[1]) {
        case '1':
            require_once __DIR__ . '/little_data.php';
            $result = obtainCompleteGraphsWithoutPivoting($pVector, $nVector);
            $cliques = count($result);
            break;
        case '2':
            require_once __DIR__ . '/little_data.php';
            $result = obtainCompleteGraphsWithPivoting($pVector, $nVector);
            $cliques = count($result);
            break;
        case '3':
            require_once __DIR__ . '/little_data.php';
            $result = obtainCompleteGraphsWithVertexOrdering($pVector, $nVector);
            $cliques = count($result);
            break;
        case '4':
            require_once __DIR__ . '/big_data.php';
            $result = obtainCompleteGraphsWithoutPivoting($pVector, $nVector);
            $cliques = count($result);
            break;
        case '5':
            require_once __DIR__ . '/big_data.php';
            $result = obtainCompleteGraphsWithPivoting($pVector, $nVector);
            $cliques = count($result);
            break;
        case '6':
            require_once __DIR__ . '/big_data.php';
            $result = obtainCompleteGraphsWithVertexOrdering($pVector, $nVector);
            $cliques = count($result);
            break;
        case '7':
            require_once __DIR__ . '/big_data.php';
            $result = obtainCompleteGraphsWithVertexOrderingForVertex($pVector, $nVector, 23);
            $cliques = count($result);
            break;
        case '8':
            require_once __DIR__ . '/big_data.php';
            $result = obtainCompleteGraphsWithVertexOrderingWithMinimumDegree($pVector, $nVector, 5);
            $cliques = count($result);
            break;
        case '9':
            require_once __DIR__ . '/big_data.php';
            $result = obtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree($pVector, $nVector, 23, 5);
            $cliques = count($result);
            break;
    }
}

echo sprintf("Cliques: %s\n", $cliques);
echo sprintf("Time: %1.3F seconds\n", microtime(true)-$time);
echo sprintf("Memory: %s bytes\n", memory_get_peak_usage(true));
