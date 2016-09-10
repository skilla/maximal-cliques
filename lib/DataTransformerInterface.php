<?php
/**
 * Created by PhpStorm.
 * User: Skilla <sergio.zambrano@gmail.com>
 * Date: 8/9/16
 * Time: 23:51
 */

namespace Skilla\MaximalCliques\lib;

interface DataTransformerInterface
{
    /**
     * Transforms input data in a vector of keys, ex:
     *   input -> [23=>'Philip', 56=>'Martha', 17=>'Louis', 107=>'John', 47=>'Agnes', 12=>'James']
     *   output -> [23, 56, 17, 107, 47, 12]
     * @param array $R
     * @return integer[]
     */
    function obtainRVector(array $R);

    /**
     * Transforms input data in a vector of keys, ex:
     *   input -> [23=>'Philip', 56=>'Martha', 17=>'Louis', 107=>'John', 47=>'Agnes', 12=>'James']
     *   output -> [23, 56, 17, 107, 47, 12]
     * @param array $P
     * @return integer[]
     */
    function obtainPVector(array $P);

    /**
     * Transforms input data in a vector of keys, ex:
     *   input -> [23=>'Philip', 56=>'Martha', 17=>'Louis', 107=>'John', 47=>'Agnes', 12=>'James']
     *   output -> [23, 56, 17, 107, 47, 12]
     * @param array $X
     * @return integer[]
     */
    function obtainXVector(array $X);

    /**
     * Transforms input data in a vector of keys, ex:
     *   input -> [23=>[23=>0, 56=>1, 17=>0, 107=>0, 47=>1, 12=>0],
     *             56=>[23=>1, 56=>0, 17=>1, 107=>0, 47=>1, 12=>0],
     *             17=>[23=>0, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0],
     *            107=>[23=>0, 56=>0, 17=>1, 107=>0, 47=>1, 12=>1],
     *             47=>[23=>1, 56=>1, 17=>0, 107=>1, 47=>0, 12=>0],
     *             12=>[23=>0, 56=>0, 17=>0, 107=>1, 47=>0, 12=>0]]
     *   output -> [[1,2],[1,5],[2,3],[2,5],[3,4],[4,5],[4,6]]
     * @param array $N
     * @return integer[]
     */
    function obtainNVector(array $N);
}
