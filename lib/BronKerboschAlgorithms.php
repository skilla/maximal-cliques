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
     * @var array $rVector
     */
    private $rVector;

    /**
     * @var array $pVector
     */
    private $pVector;

    /**
     * @var array $xVector
     */
    private $xVector;

    /**
     * @var array $nVector
     */
    private $nVector;

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
        $this->rVector = $this->dataTransformer->obtainRVector($rawData);
    }

    /**
     * @param $rawData
     */
    public function setPVector($rawData)
    {
        $this->pVector = $this->dataTransformer->obtainPVector($rawData);
    }

    /**
     * @param $rawData
     */
    public function setXVector($rawData)
    {
        $this->xVector = $this->dataTransformer->obtainXVector($rawData);
    }

    /**
     * @param $rawData
     */
    public function setNVector($rawData)
    {
        $this->nVector = $this->dataTransformer->obtainNVector($rawData);
        $this->filterWeights = null;
    }

    /**
     * return array
     */
    public function obtainCompleteGraphsWithoutPivoting()
    {
        $this->completeGraphs = [];
        $this->selectedVertex = null;
        $this->selectedDegree = null;
        $this->filterInputData();
        $this->extractCompleteGraphsWithoutPivoting($this->rVector, $this->pVector, $this->xVector);
        return $this->completeGraphs;
    }

    /**
     * return array
     */
    public function obtainCompleteGraphsWithPivoting()
    {
        $this->completeGraphs = [];
        $this->selectedVertex = null;
        $this->selectedDegree = null;
        $this->filterInputData();
        $this->extractCompleteGraphsWithPivoting($this->rVector, $this->pVector, $this->xVector);
        return $this->completeGraphs;
    }

    /**
     * return array
     */
    public function obtainCompleteGraphsWithVertexOrdering()
    {
        $this->completeGraphs = [];
        $this->selectedVertex = null;
        $this->selectedDegree = null;
        $this->filterInputData();
        $this->extractCompleteGraphsWithVertexOrdering($this->rVector, $this->pVector, $this->xVector);
        return $this->completeGraphs;
    }

    /**
     * @param integer $vertex
     * @return array
     */
    public function obtainCompleteGraphsWithVertexOrderingForVertex($vertex)
    {
        $this->completeGraphs = [];
        $this->selectedVertex = $vertex;
        $this->selectedDegree = null;
        $this->filterInputData();
        $this->extractCompleteGraphsWithVertexOrdering($this->rVector, $this->pVector, $this->xVector);
        return $this->completeGraphs;
    }

    /**
     * @param integer $minimumDegree
     * @return array
     */
    public function obtainCompleteGraphsWithVertexOrderingWithMinimumDegree($minimumDegree)
    {
        $this->completeGraphs = [];
        $this->selectedVertex = null;
        $this->selectedDegree = $minimumDegree;
        $this->filterInputData();
        $this->extractCompleteGraphsWithVertexOrdering($this->rVector, $this->pVector, $this->xVector);
        return $this->completeGraphs;
    }

    /**
     * @param integer $vertex
     * @param integer $minimumDegree
     * @return array
     */
    public function obtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree($vertex, $minimumDegree)
    {
        $this->completeGraphs = [];
        $this->selectedVertex = $vertex;
        $this->selectedDegree = $minimumDegree;
        $this->filterInputData();
        $this->extractCompleteGraphsWithVertexOrdering($this->rVector, $this->pVector, $this->xVector);
        return $this->completeGraphs;
    }

    /**
     * @return array
     */
    public function retrieveMaximalClique()
    {
        $this->sizeCompare(null, null);
        usort($this->completeGraphs, array($this, 'sizeCompare'));
        return $this->completeGraphs[0];
    }

    private function sizeCompare($first, $second)
    {
        if (count($first) == count($second)) {
            return 0;
        }
        return (count($first) > count($second)) ? -1 : 1;
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
            $this->filteredN = &$this->nVector;
        } else {
            $this->filteredN = [];
            $nVector = array_merge(
                [$this->selectedVertex],
                $this->extractRelatedVertexFromN([$this->selectedVertex])
            );
            foreach ($this->nVector as $edge) {
                if (in_array($edge[0], $nVector) && in_array($edge[1], $nVector)) {
                    $this->filteredN[] = $edge;
                }
            }
        }
    }

    private function extractRelatedVertexFromN(array $needle)
    {
        $related = [];
        foreach ($this->nVector as $edge) {
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

    private function generateFilteredWeights()
    {
        $weights = [];
        $relatedVertex = array_merge([$this->selectedVertex], $this->extractRelatedVertex($this->selectedVertex));
        foreach ($this->filteredN as $related) {
            if ($this->selectedVertex == null || in_array($related[0], $relatedVertex) || in_array($related[1], $relatedVertex)) {
                $weights[$related[0]] = ((int)@$weights[$related[0]]) + 1;
                $weights[$related[1]] = ((int)@$weights[$related[1]]) + 1;
            }
        }
        if (!is_null($this->selectedDegree)) {
            foreach ($weights as $key => $value) {
                if ($value < $this->selectedDegree) {
                    if ($this->selectedVertex==$key) {
                        $weights = [];
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
        $related = [];
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
        foreach (array_keys($this->filterWeights) as $key) {
            if (in_array($key, $vertex)) {
                return $key;
            }
        }
        return null;
    }

    private function extractCompleteGraphsWithoutPivoting($rVector, $pVector, $xVector)
    {
        if (empty($pVector) && empty($xVector)) {
            $this->completeGraphs[] = $rVector;
            return;
        }
        foreach ($pVector as $v) {
            $relatedVertex = $this->extractRelatedVertex($v);
            $this->extractCompleteGraphsWithoutPivoting(
                array_merge($rVector, [$v]),
                array_intersect($pVector, $relatedVertex),
                array_intersect($xVector, $relatedVertex)
            );
            $pVector = array_diff($pVector, [$v]);
            $xVector = array_values(array_merge($xVector, [$v]));
        }
    }

    private function extractCompleteGraphsWithPivoting($rVector, $pVector, $xVector)
    {
        if (empty($pVector) && empty($xVector)) {
            if ($this->containsVertex($rVector) && $this->isDegreeCompliant($rVector)) {
                $this->completeGraphs[] = $rVector;
            }
            return;
        }
        $pivot = $this->choosePivot(array_merge($pVector, $xVector));
        if (is_null($pivot)) {
            return;
        }
        $pivotRelated = $this->extractRelatedVertex($pivot);
        $reducedP = array_diff($pVector, $pivotRelated);
        foreach ($reducedP as $v) {
            $relatedVertex = $this->extractRelatedVertex($v);
            $this->extractCompleteGraphsWithPivoting(
                array_merge($rVector, [$v]),
                array_intersect($pVector, $relatedVertex),
                array_intersect($xVector, $relatedVertex)
            );
            $pVector = array_diff($pVector, [$v]);
            $xVector = array_values(array_merge($xVector, [$v]));
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

    private function extractCompleteGraphsWithVertexOrdering($rVector, $pVector, $xVector)
    {
        $pVector = array_intersect(array_keys($this->filterWeights), $pVector);
        foreach ($pVector as $v) {
            $relatedVertex = $this->extractRelatedVertex($v);
            $this->extractCompleteGraphsWithPivoting(
                array_merge($rVector, [$v]),
                array_intersect($pVector, $relatedVertex),
                array_intersect($xVector, $relatedVertex)
            );
            $pVector = array_diff($pVector, [$v]);
            $xVector = array_values(array_merge($xVector, [$v]));
        }
    }
}