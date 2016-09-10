<?php
/**
 * Created by PhpStorm.
 * User: Skilla <sergio.zambrano@gmail.com>
 * Date: 8/9/16
 * Time: 20:16
 */

namespace Skilla\MaximalCliques\lib;

class BronKerboschAlgorithms
{
    /**
     * @var array $r
     */
    private $r;

    /**
     * @var array $p
     */
    private $p;

    /**
     * @var array $x
     */
    private $x;

    /**
     * @var array $n
     */
    private $n;

    /**
     * @var array $g
     */
    private $g;

    /**
     * @var array $completeGraphs
     */
    private $completeGraphs;

    /**
     * @var DataTransformerInterface $dataTransformer
     */
    private $dataTransformer;

    /**
     * @param DataTransformerInterface $dataTransformer
     */
    public function setDataTransformer(DataTransformerInterface $dataTransformer)
    {
        $this->dataTransformer = $dataTransformer;
    }

    /**
     * @param $rawData
     */
    public function setRVector($rawData)
    {
        $this->r = $this->dataTransformer->obtainRVector($rawData);
    }

    /**
     * @param $rawData
     */
    public function setPVector($rawData)
    {
        $this->p = $this->dataTransformer->obtainPVector($rawData);
    }

    /**
     * @param $rawData
     */
    public function setXVector($rawData)
    {
        $this->x = $this->dataTransformer->obtainXVector($rawData);
    }

    /**
     * @param $rawData
     */
    public function setNVector($rawData)
    {
        $this->n = $this->dataTransformer->obtainNVector($rawData);
    }

    /**
     * return array
     */
    public function obtainCompleteGraphsWithoutPivoting()
    {
        $this->completeGraphs = [];
        $this->extractCompleteGraphsWithoutPivoting($this->r, $this->p, $this->x);
        return $this->completeGraphs;
    }

    /**
     * return array
     */
    public function obtainCompleteGraphsWithPivoting()
    {
        return [];
    }

    /**
     * return array
     */
    public function obtainCompleteGraphsWithVertexOrdering()
    {
        return [];
    }

    private function generateGVector()
    {
        $this->g = [];
    }

    private function extractCompleteGraphsWithoutPivoting($r, $p, $x)
    {
        if (empty($p) && empty($x)) {
            $this->completeGraphs[] = $r;
        }
       foreach ($p as $v) {
           $relatedVertex = $this->extractRelatedVertex($v);
           $this->extractCompleteGraphsWithoutPivoting(
               array_merge($r, [$v]),
               array_intersect($p, $relatedVertex),
               array_intersect($x, $relatedVertex)
            );
           unset($p[array_search($v, $p)]);
            $x = array_values(array_merge($x, [$v]));
       }
    }

    private function extractRelatedVertex($needle)
    {
        $related = [];
        foreach ($this->n as $edge) {
            if ($edge[0] == $needle) {
                $related[$edge[1]] = $edge[1];
            }
            if ($edge[1] == $needle) {
                $related[$edge[0]] = $edge[0];
            }
        }
        return array_values($related);
    }
}