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

/**
 * Class UndirectedGraph
 *
 * Order of Edge vertices DOES NOT matter.
 *
 * @package CentralDesktop\Graph\Graph
 */
class UndirectedGraph extends Graph\Graph {

    /**
     * @param Graph\Vertex $source
     * @param Graph\Vertex $target
     * @return Graph\Edge|null
     */
    public function get_edge(Graph\Vertex $source, Graph\Vertex $target) {
        if ($this->vertices->contains($source) &&
            $this->vertices->contains($target)) {

            $edges = $this->get_edges_of($source);
            /**
             * @var $edge Graph\Edge
             */
            foreach ($edges as $edge) {
                if ($edge->get_vertices()->contains($source) &&
                    $edge->get_vertices()->contains($target)) {
                    return $edge;
                }
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
        return new Graph\Edge\UndirectedEdge($source, $target);
    }

    public function get_edges_of(Graph\Vertex $vertex) {
        $edges = new \SplObjectStorage();

        // @TODO track this somewhere

        return $this->get_edges();
    }

    public function degree_of(Graph\Vertex $vertex) {
        $degree = 0;
        /**
         * @var Graph\Edge $edge
         */
        foreach ($this->get_edges() as $edge) {
            if ($edge->get_vertices()->contains($vertex)) {
                $degree++;
            }
        }

        return $degree;
    }
}
