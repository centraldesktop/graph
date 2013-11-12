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
 * Class Vertex
 *
 *
 *
 * @package CentralDesktop\Graph
 */
class Vertex {

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Consumer defined data for this vertex
     *
     * @var mixed
     */
    protected $data;

    /**
     * @var VertexSet
     */
    public $predecessors;

    /**
     * @var VertexSet
     */
    public $successors;

    /**
     * @var SplObjectStorage
     */
    public $outgoing_edges;

    /**
     * @var SplObjectStorage
     */
    public $incoming_edges;

    /**
     * @param $data
     */
    public function __construct($data) {
        $this->data = $data;
        $this->predecessors = new VertexSet();
        $this->successors= new VertexSet();
        $this->outgoing_edges = new SplObjectStorage();
        $this->incoming_edges = new SplObjectStorage();
        $this->logger = new NullLogger();
    }

    /**
     * @return mixed
     */
    public function get_data() {
        return $this->data;
    }

    /**
     * @param Vertex $vertex
     * @return $this
     * @throws Exception\DuplicateVertexException
     */
    public function add_predecessor(Vertex $vertex) {
        if ($this->predecessors->contains($vertex)) {
            throw new Exception\DuplicateVertexException($vertex);
        }

        $this->predecessors->attach($vertex);
        return $this;
    }

    /**
     * @param Vertex $vertex
     * @return $this
     * @throws Exception\DuplicateVertexException
     */
    public function add_successor(Vertex $vertex) {
        if ($this->successors->contains($vertex)) {
            throw new Exception\DuplicateVertexException($vertex);
        }

        $this->successors->attach($vertex);
        return $this;
    }

    /**
     * @param Edge $edge
     * @return $this
     */
    public function add_outgoing_edge(Edge $edge) {
        $this->outgoing_edges->attach($edge);
        return $this;
    }

    /**
     * @param Edge $edge
     * @return $this
     */
    public function add_incoming_edge(Edge $edge) {
        $this->incoming_edges->attach($edge);
        return $this;
    }

    /**
     * @return string
     */
    public
    function get_label() {
        return $this->__toString();
    }

    /**
     * @return string
     */
    public function __toString() {
        return "";
    }
}
