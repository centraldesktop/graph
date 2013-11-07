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

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\NullLogger;
use SplObjectStorage;

/**
 * Abstract Class Graph
 *
 * Defines a generic graph structure.
 *
 * @package CentralDesktop\Graph
 */
abstract class Graph {

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var SplObjectStorage
     */
    protected $vertices;

    /**
     * @var SplObjectStorage
     */
    protected $edges;


    /**
     * default constructor
     */
    public function __construct() {
        $this->vertices = new VertexSet();
        $this->edges = new SplObjectStorage();
        $this->logger = new NullLogger();
    }

    /**
     * @param Vertex $vertex
     * @return bool
     */
    public function add_vertex(Vertex $vertex) {
        if (!$this->has_vertex($vertex)) {
            $this->vertices->attach($vertex);
            return true;
        }
        return false;
    }

    /**
     * @param Vertex $vertex
     * @return bool
     */
    public function has_vertex(Vertex $vertex) {
        return $this->vertices->contains($vertex);
    }

    /**
     * @param $data
     *
     * @return Vertex|null
     */
    public
    function get_vertex($data) {
        $vertex = $this->create_vertex($data);
        if ($this->has_vertex($vertex)) {
            return $this->vertices->offsetGet($vertex);
        }

        return null;
    }

    /**
     * @param  $data
     * @return Vertex
     */
    public
    function create_vertex($data) {
        return new Vertex($data);
    }

    /**
     * @param Vertex $source
     * @param Vertex $target
     * @return Edge|null
     */
    abstract public function get_edge(Vertex $source, Vertex $target);

    /**
     * @param Vertex $source
     * @param Vertex $target
     * @return Edge
     */
    abstract public function create_edge(Vertex $source, Vertex $target);

    /**
     * Add an Edge(u, v) to Graph
     *
     * A vertex can only exist once in the graph.
     * If at least one vertex fails to be added this method will return false.
     *
     * @param Vertex $source
     * @param Vertex $target
     * @return bool
     */
    public function add_edge(Vertex $source, Vertex $target) {
        if ($this->has_edge($source, $target)) {
            return false;
        }

        /**
         * Update vertices if needed.
         */
        $this->add_vertex($source);
        $this->add_vertex($target);

        $edge = $this->create_edge($source, $target);
        $this->edges->attach($edge);
        return true;
    }

    /**
     * @param Edge $edge
     * @return bool
     */
    public function has_edge(Vertex $source, Vertex $target) {
        if ($this->has_vertex($source) && $this->has_vertex($target)) {
            /**
             * @var $edge Edge
             */
            foreach ($source->outgoing_edges as $edge) {
                if ($edge->get_source() === $source && $edge->get_target() === $target) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param Edge $edge
     * @return bool
     */
    public function remove_edge(Edge $edge) {
        $source = $edge->get_source();
        $target = $edge->get_target();

        $source->successors->detach($target);
        $target->successors->detach($source);

        $source->predecessors->detach($target);
        $target->predecessors->detach($source);

        $source->outgoing_edges->detach($edge);
        $target->outgoing_edges->detach($edge);

        $source->incoming_edges->detach($edge);
        $target->incoming_edges->detach($edge);

        $this->get_edges()->detach($edge);
        return true;
    }

    /**
     * @return SplObjectStorage
     */
    public function get_vertices() {
        return $this->vertices;
    }

    /**
     * @return SplObjectStorage
     */
    public function get_edges() {
        return $this->edges;
    }
}