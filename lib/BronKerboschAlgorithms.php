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
     * @var integer $selectedVertex
     */
    private $selectedVertex;

    /**
     * @var integer $selectedDegree
     */
    private $selectedDegree;

    /**
     * @var string $filterWeightsVersion
     */
    private $filterWeightsVersion;

    /**
     * @var array $filterWeights
     */
    private $filterWeights;

    /**
     * @var array $filterWeights
     */
    private $filteredN;

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
        $this->filterWeights = null;
    }

    /**
     * return array
     */
    public function obtainCompleteGraphsWithoutPivoting()
    {
        $this->completeGraphs = array();
        $this->selectedVertex = null;
        $this->selectedDegree = null;
        $this->filterInputData();
        $this->extractCompleteGraphsWithoutPivoting($this->r, $this->p, $this->x);
        return $this->completeGraphs;
    }

    /**
     * return array
     */
    public function obtainCompleteGraphsWithPivoting()
    {
        $this->completeGraphs = array();
        $this->selectedVertex = null;
        $this->selectedDegree = null;
        $this->filterInputData();
        $this->extractCompleteGraphsWithPivoting($this->r, $this->p, $this->x);
        return $this->completeGraphs;
    }

    /**
     * return array
     */
    public function obtainCompleteGraphsWithVertexOrdering()
    {
        $this->completeGraphs = array();
        $this->selectedVertex = null;
        $this->selectedDegree = null;
        $this->filterInputData();
        $this->extractCompleteGraphsWithVertexOrdering($this->r, $this->p, $this->x);
        return $this->completeGraphs;
    }

    /**
     * @param integer $vertex
     * @return array
     */
    public function obtainCompleteGraphsWithVertexOrderingForVertex($vertex)
    {
        $this->completeGraphs = array();
        $this->selectedVertex = $vertex;
        $this->selectedDegree = null;
        $this->filterInputData();
        $this->extractCompleteGraphsWithVertexOrderingOptimized($this->r, $this->p, $this->x);
        return $this->completeGraphs;
    }

    /**
     * @param integer $minimumDegree
     * @return array
     */
    public function obtainCompleteGraphsWithVertexOrderingWithMinimumDegree($minimumDegree)
    {
        $this->completeGraphs = array();
        $this->selectedVertex = null;
        $this->selectedDegree = $minimumDegree;
        $this->filterInputData();
        $this->extractCompleteGraphsWithVertexOrderingOptimized($this->r, $this->p, $this->x);
        return $this->completeGraphs;
    }

    /**
     * @param integer $vertex
     * @param integer $minimumDegree
     * @return array
     */
    public function obtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree($vertex, $minimumDegree)
    {
        $this->completeGraphs = array();
        $this->selectedVertex = $vertex;
        $this->selectedDegree = $minimumDegree;
        $this->filterInputData();
        $this->extractCompleteGraphsWithVertexOrderingOptimized($this->r, $this->p, $this->x);
        return $this->completeGraphs;
    }

    /**
     * @return array
     */
    public function retrieveMaximalClique()
    {
        usort($this->completeGraphs, array($this, 'sizeCompare'));
        return $this->completeGraphs[0];
    }

    private function sizeCompare($a, $b)
    {
        if (count($a) == count($b)) {
            return 0;
        }
        return (count($a) > count($b)) ? -1 : 1;
    }

    private function filterInputData()
    {
        if ($this->filterWeightsVersion !== "$this->selectedVertex#$this->selectedDegree") {
            $this->filterWeightsVersion = "$this->selectedVertex#$this->selectedDegree";
            $this->generateFilteredN();
            $this->generateFilteredWeights();
        }
    }

    private function generateFilteredN()
    {
        if (is_null($this->selectedVertex)) {
            $this->filteredN = &$this->n;
        } else {
            $n = array_merge(
                array($this->selectedVertex),
                $this->extractRelatedVertexFromN(array($this->selectedVertex))
            );
            foreach ($this->n as $edge) {
                if (in_array($edge[0], $n) && in_array($edge[1], $n)) {
                    $this->filteredN[] = $edge;
                }
            }
        }
    }

    private function extractRelatedVertexFromN(array $needle)
    {
        $related = array();
        foreach ($this->n as $edge) {
            if (in_array($edge[0], $needle)) {
                $related[$edge[1]] = $edge[1];
            } else {
                if (in_array($edge[1], $needle)) {
                    $related[$edge[0]] = $edge[0];
                }
            }
        }
        return array_values($related);
    }

    private function checkVertex($related)
    {
        return
            $this->selectedVertex == null ||
            in_array(
                $related,
                array_merge(
                    array($this->selectedVertex),
                    $this->extractRelatedVertex($this->selectedVertex)
                )
            );
    }

    private function generateFilteredWeights()
    {
        $weights = array();
        foreach ($this->filteredN as $related) {
            if ( $this->checkVertex($related[0]) || $this->checkVertex($related[1])) {
                $weights[$related[0]] = ((int)@$weights[$related[0]]) + 1;
                $weights[$related[1]] = ((int)@$weights[$related[1]]) + 1;
            }
        }
        if (!is_null($this->selectedDegree)) {
            foreach ($weights as $key => $value) {
                if ($value < $this->selectedDegree) {
                    if ($this->selectedVertex==$key) {
                        $weights = array();
                        break;
                    }
                    unset($weights[$key]);
                }
            }
        }
        asort($weights);
        $this->filterWeights = $weights;
    }

    private function extractRelatedVertex($needle)
    {
        $related = array();
        foreach ($this->filteredN as $edge) {
            if ($edge[0] == $needle) {
                $related[$edge[1]] = $edge[1];
            }
            if ($edge[1] == $needle) {
                $related[$edge[0]] = $edge[0];
            }
        }
        return array_values($related);
    }

    private function choosePivot(array $vertex)
    {
        foreach ($this->filterWeights as $key => $value) {
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
               array_merge($r, array($v)),
               array_intersect($p, $relatedVertex),
               array_intersect($x, $relatedVertex)
            );
           unset($p[array_search($v, $p)]);
            $x = array_values(array_merge($x, array($v)));
       }
    }

    private function extractCompleteGraphsWithPivoting($r, $p, $x)
    {
        if (empty($p) && empty($x)) {
            if ($this->containsVertex($r) && $this->isDegreeCompliant($r)) {
                $this->completeGraphs[] = $r;
            }
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
                array_merge($r, array($v)),
                array_intersect($p, $relatedVertex),
                array_intersect($x, $relatedVertex)
            );
            unset($p[array_search($v, $p)]);
            $x = array_values(array_merge($x, array($v)));
        }
    }

    private function containsVertex($graph)
    {
        return is_null($this->selectedVertex) || in_array($this->selectedVertex, $graph);
    }

    private function isDegreeCompliant($graph)
    {
        return is_null($this->selectedDegree) || count($graph) >= $this->selectedDegree+1;
    }

    private function extractCompleteGraphsWithVertexOrdering($r, $p, $x)
    {
        $p = array_intersect(array_keys($this->filterWeights), $p);
        foreach ($p as $v) {
            $relatedVertex = $this->extractRelatedVertex($v);
            $this->extractCompleteGraphsWithPivoting(
                array_merge($r, array($v)),
                array_intersect($p, $relatedVertex),
                array_intersect($x, $relatedVertex)
            );
            unset($p[array_search($v, $p)]);
            $x = array_values(array_merge($x, array($v)));
        }
    }

    private function extractCompleteGraphsWithVertexOrderingOptimized($r, $p, $x)
    {
        $p = array_intersect(array_keys($this->filterWeights), $p);
        foreach ($p as $v) {
            $relatedVertex = $this->extractRelatedVertex($v);
            $this->extractCompleteGraphsWithPivoting(
                array_merge($r, array($v)),
                array_intersect($p, $relatedVertex),
                array_intersect($x, $relatedVertex)
            );
            unset($p[array_search($v, $p)]);
            $x = array_values(array_merge($x, array($v)));
        }
    }
}