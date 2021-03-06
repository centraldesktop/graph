<?php

/**
 *
 * Copyright 2005-2006 The Apache Software Foundation
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */


namespace CentralDesktop\Graph\Graph;

use CentralDesktop\Graph;
use CentralDesktop\Graph\DirectedGraphTraverser;

/**
 * Class DirectedGraph
 *
 * Order of Edge vertices DOES matter.
 *
 * @package CentralDesktop\Graph\Graph
 */
class DirectedGraph extends Graph\Graph {

    /**
     * @var DirectedGraphTraverser
     */
    protected $traverser;

    public function __construct() {
        parent::__construct();

        $this->traverser = new DirectedGraphTraverser($this);
    }

    /**
     * @param Graph\Vertex $source
     * @param Graph\Vertex $target
     * @return Graph\Edge|null
     */
    public function get_edge(Graph\Vertex $source, Graph\Vertex $target) {
        $edges = $this->get_outgoing_edges_of($source);
        /**
         * @var $edge Graph\Edge
         */
        foreach ($edges as $edge) {
            if ($edge->get_source() === $source && $edge->get_target() === $target) {
                return $edge;
            }
        }

        return null;
    }

    /**
     * @param Graph\Vertex $source
     * @param Graph\Vertex $target
     * @return Graph\Edge
     */
    public function create_edge(Graph\Vertex $source, Graph\Vertex $target) {
        $edge = new Graph\Edge\DirectedEdge($source, $target);
        $source->add_outgoing_edge($edge);
        $target->add_incoming_edge($edge);
        return $edge;
    }

    /**
     * @param Graph\Vertex $vertex
     * @return \SplObjectStorage
     */
    public function get_outgoing_edges_of(Graph\Vertex $vertex) {
        return $vertex->outgoing_edges;
    }

    /**
     * @param Graph\Vertex $vertex
     * @return int
     */
    public function in_degree_of(Graph\Vertex $vertex) {
        return $vertex->predecessors->count();
    }

    /**
     * @param Graph\Vertex $vertex
     * @return int
     */
    public function out_degree_of(Graph\Vertex $vertex) {
        return $vertex->successors->count();
    }

    /**
     * @param Graph\Vertex $start_vertex
     * @return array
     */
    public function simple_paths(Graph\Vertex $start_vertex) {
        return $this->traverser->simple_paths($start_vertex);
    }

    public
    function get_start_vertex() {
        $this->vertices->rewind();
        return $this->vertices->current();
    }
}
