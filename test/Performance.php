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

$pVectorLittle = [];
$nVectorLittle = [];
$pVectorBig = [];
$nVectorBig = [];

function obtainCompleteGraphsWithoutPivoting($p, $n)
{
    $algorithm = new BronKerboschAlgorithms();
    $algorithm->setDataTransformer(new DataTransformerExample());

    $algorithm->setRVector([]);
    $algorithm->setPVector($p);
    $algorithm->setXVector([]);
    $algorithm->setNVector($n);

    return $algorithm->obtainCompleteGraphsWithoutPivoting();
}

function obtainCompleteGraphsWithPivoting($p, $n)
{
    $algorithm = new BronKerboschAlgorithms();
    $algorithm->setDataTransformer(new DataTransformerExample());

    $algorithm->setRVector([]);
    $algorithm->setPVector($p);
    $algorithm->setXVector([]);
    $algorithm->setNVector($n);

    return $algorithm->obtainCompleteGraphsWithPivoting();
}

function obtainCompleteGraphsWithVertexOrdering($p, $n)
{
    $algorithm = new BronKerboschAlgorithms();
    $algorithm->setDataTransformer(new DataTransformerExample());

    $algorithm->setRVector([]);
    $algorithm->setPVector($p);
    $algorithm->setXVector([]);
    $algorithm->setNVector($n);

    return $algorithm->obtainCompleteGraphsWithVertexOrdering();
}

if (sizeof($argv)<2 || 6<(int)$argv[1] || 1>(int)$argv[1]) {
    echo "\nUsage:\n";
    echo "  php test/Performance.php x\n";
    echo "    where x is a number from 1 to 3 for performance with little data or 4 to 6 with big data\n\n";
    die();
}

$cycles = $argv[1]<'4' ? 1000 : 1;

$time = microtime(true);

for ($a=1; $a<=$cycles; $a++) {
    switch ($argv[1]) {
        case '1':
            require_once __DIR__ . '/little_data.php';
            $cliques = count(obtainCompleteGraphsWithoutPivoting($pVectorLittle, $nVectorLittle));
            break;
        case '2':
            require_once __DIR__ . '/little_data.php';
            $cliques = count(obtainCompleteGraphsWithPivoting($pVectorLittle, $nVectorLittle));
            break;
        case '3':
            require_once __DIR__ . '/little_data.php';
            $cliques = count(obtainCompleteGraphsWithVertexOrdering($pVectorLittle, $nVectorLittle));
            break;
        case '4':
            require_once __DIR__ . '/big_data.php';
            $cliques = count(obtainCompleteGraphsWithoutPivoting($pVectorBig, $nVectorBig));
            break;
        case '5':
            require_once __DIR__ . '/big_data.php';
            $cliques = count(obtainCompleteGraphsWithPivoting($pVectorBig, $nVectorBig));
            break;
        case '6':
            require_once __DIR__ . '/big_data.php';
            $cliques = count(obtainCompleteGraphsWithVertexOrdering($pVectorBig, $nVectorBig));
            break;
    }
}

echo sprintf("Cliques: %s\n", $cliques);
echo sprintf("Time: %1.3F seconds\n", microtime(true)-$time);
echo sprintf("Memory: %s bytes\n", memory_get_peak_usage(true));
