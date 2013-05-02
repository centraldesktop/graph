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


namespace CentralDesktop\Graph;
use CentralDesktop\Graph\Graph\DirectedGraph;
use InvalidArgumentException;

/**
 * @package CentralDesktop\Graph
 */
class DirectedGraphTraverser {

    /**
     * @var DirectedGraph
     */
    protected $digraph;

    /**
     * @var array
     */
    protected $simple_paths;

    /**
     * @var array
     */
    protected $current_path;

    /**
     * @param DirectedGraph $graph
     * @throws InvalidArgumentException
     */
    public function __construct(DirectedGraph $graph) {
        if (!$graph instanceof DirectedGraph) {
            throw new \InvalidArgumentException("Must use a directed graph.");
        }

        $this->digraph = $graph;
    }

    /**
     * @param Vertex $start_vertex
     * @return array
     */
    public function simple_paths(Vertex $start_vertex) {
        $this->simple_paths = array();
        /**
         * @var $edge Edge\DirectedEdge
         */
        foreach($this->digraph->get_outgoing_edges_of($start_vertex) as $edge) {
            $this->current_path = array();
            $this->simple_path_recursive($edge->get_target(), $edge);
        }
        return $this->simple_paths;
    }

    /**
     * @param Vertex $start
     * @param Edge\DirectedEdge $edge
     */
    protected function simple_path_recursive(Vertex $start, Edge\DirectedEdge $edge) {
        /**
         * We don't want to visit the same edge twice within a single path.
         * I.E. No loops in a single simple path.
         */
        if (in_array($edge, $this->current_path)) {
            return;
        } else {
            $this->current_path[] = $edge;
        }

        if ($start->outgoing_edges->count() == 0) {
            $this->simple_paths[] = $this->current_path;
            return;
        }

        /**
         * @var $edge Edge\DirectedEdge
         */
        foreach ($this->digraph->get_outgoing_edges_of($start) as $edge) {
            $this->simple_path_recursive($edge->get_target(), $edge);
            array_pop($this->current_path);
        }
    }
}
