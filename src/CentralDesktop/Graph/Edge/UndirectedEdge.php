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


namespace CentralDesktop\Graph\Edge;

use CentralDesktop\Graph;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\NullLogger;
use SplObjectStorage;

/**
 * Class Edge
 *
 *
 *
 * @package CentralDesktop\Graph\Edge
 */
class UndirectedEdge extends Graph\Edge {

    /**
     * @param Graph\Vertex $source
     * @param Graph\Vertex $target
     */
    public function __construct(Graph\Vertex $source, Graph\Vertex $target) {
        $this->vertices = new Graph\VertexSet();
        $this->source = $source;
        $this->target = $target;

        $this->source->add_successor($target);
        $this->source->add_predecessor($target);
        $this->target->add_successor($source);
        $this->target->add_predecessor($source);

        $this->vertices->attach($source);
        $this->vertices->attach($target);

        $this->logger = new NullLogger();
    }
}
