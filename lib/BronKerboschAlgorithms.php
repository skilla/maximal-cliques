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
     * @var array $weights
     */
    private $weights;

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
        $this->weights = null;
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
        $this->completeGraphs = [];
        $this->extractCompleteGraphsWithPivoting($this->r, $this->p, $this->x);
        return $this->completeGraphs;
    }

    /**
     * return array
     */
    public function obtainCompleteGraphsWithVertexOrdering()
    {
        $this->completeGraphs = [];
        $this->extractCompleteGraphsWithVertexOrdering($this->r, $this->p, $this->x);
        return $this->completeGraphs;
    }

    private function generateGVector()
    {
        $this->g = [];
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

    private function generateWeights()
    {
        if (is_null($this->weights)) {
            $weights = [];
            foreach ($this->n as $related) {
                $weights[$related[0]] = ((int)@$weights[$related[0]]) + 1;
                $weights[$related[1]] = ((int)@$weights[$related[1]]) + 1;
            }
            asort($weights);
            $this->weights = $weights;
        }
    }

    private function choosePivot(array $vertex)
    {
        $this->generateWeights();
        foreach ($this->weights as $key => $value) {
            if (in_array($key, $vertex)) {
                return $key;
            }
        }
        throw new \Exception('No matches between the weight vector and vertex provided');
    }

    private function extractCompleteGraphsWithoutPivoting($r, $p, $x)
    {
        if (empty($p) && empty($x)) {
            $this->completeGraphs[] = $r;
            return;
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

    private function extractCompleteGraphsWithPivoting($r, $p, $x)
    {
        if (empty($p) && empty($x)) {
            $this->completeGraphs[] = $r;
            return;
        }
        $pivot = $this->choosePivot(array_merge($p, $x));
        $pivotRelated = $this->extractRelatedVertex($pivot);
        $reducedP = $p;
        foreach ($pivotRelated as $related) {
            unset($reducedP[array_search($related, $reducedP)]);
        }
        foreach ($reducedP as $v) {
            $relatedVertex = $this->extractRelatedVertex($v);
            $this->extractCompleteGraphsWithPivoting(
                array_merge($r, [$v]),
                array_intersect($p, $relatedVertex),
                array_intersect($x, $relatedVertex)
            );
            unset($p[array_search($v, $p)]);
            $x = array_values(array_merge($x, [$v]));
        }
    }

    private function extractCompleteGraphsWithVertexOrdering($r, $p, $x)
    {
        $this->generateWeights();
        $p = array_keys(array_intersect($this->weights, $p));
        foreach ($p as $v) {
            $relatedVertex = $this->extractRelatedVertex($v);
            $this->extractCompleteGraphsWithPivoting(
                array_merge($r, [$v]),
                array_intersect($p, $relatedVertex),
                array_intersect($x, $relatedVertex)
            );
            unset($p[array_search($v, $p)]);
            $x = array_values(array_merge($x, [$v]));
        }
    }
}