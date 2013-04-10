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


namespace CentralDesktop\Spl;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\NullLogger;
use SplObjectStorage;

/**
 * Abstract Class Graph
 *
 * Defines a generic graph structure.
 *
 * @package CentralDesktop\Spl
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
        $this->vertices = new SplObjectStorage();
        $this->edges = new SplObjectStorage();
        $this->logger = new NullLogger();
    }

    /**
     * @param Vertex $vertex
     * @return bool
     */
    public function add_vertex(Vertex $vertex) {
        if ($this->vertices->contains($vertex)) {
            return false;
        }

        $this->vertices->attach($vertex);
        return true;
    }

    /**
     * Add an Edge(u, v) to Graph
     *
     * A vertex can only exist once in the graph.
     * If at least one vertex fails to be added this method will return false.
     *
     * @param Edge $edge
     * @return bool
     */
    public function add_edge(Edge $edge) {
        if ($this->edges->contains($edge)) {
            return false;
        }

        $source = $edge->get_source();
        $target = $edge->get_target();

        if($this->add_vertex($source)) {
            if ($this->add_vertex($target)) {
                $this->edges->attach($edge);
                return true;
            } else {
                $this->vertices->detach($source);
            }
        }
        return false;
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