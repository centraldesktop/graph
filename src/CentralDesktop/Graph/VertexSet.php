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

use SplObjectStorage;
use ArrayObject;

/**
 * Class VertexSet
 *
 *
 *
 * @package CentralDesktop\Graph
 */
class VertexSet extends SplObjectStorage {

    /**
     * @var ArrayObject
     */
    private $storage;

    public
    function __construct() {
        if (version_compare(PHP_VERSION, '5.4', '<')) {
            $this->storage = new ArrayObject;
        }
    }

    /**
     * PHP 5>=5.4.0 Implementation
     * @param Vertex $vertex
     *
     * @return mixed|string
     */
    public
    function getHash(Vertex $vertex) {
        $hash = $vertex->get_data();
        if (is_null($hash)) {
            $hash = "";
        }
        return $hash;
    }

    /**
     * @param object $vertex
     *
     * @return bool
     */
    public
    function contains($vertex) {
        if ($this->storage instanceof ArrayObject) {
            return $this->storage->offsetExists($this->getHash($vertex));
        } else {
            return parent::contains($vertex);
        }
    }

    /**
     * @param object $vertex
     *
     * @return bool
     */
    public
    function offsetExists($vertex) {
        return $this->contains($vertex);
    }

    /**
     * @param object $vertex
     *
     * @return mixed
     */
    public
    function offsetGet($vertex) {
        if ($this->storage instanceof ArrayObject) {
            return $this->storage->offsetGet($this->getHash($vertex));
        } else {
            return parent::offsetGet($vertex);
        }
    }

    /**
     * @param object $vertex
     */
    public
    function attach($vertex, $data = null) {
        if ($this->storage instanceof ArrayObject) {
            if (is_null($data)) {
                $data = $vertex;
            }
            $this->storage->offsetSet($this->getHash($vertex), $data);
        } else {
            parent::attach($vertex, $data);
        }
    }

    /**
     * @param object $vertex
     * @param null   $data
     */
    public
    function offsetSet($vertex, $data = null) {
        $this->attach($vertex, $data);
    }

    /**
     * @param object $vertex
     */
    public
    function detach($vertex) {
        if ($this->storage instanceof ArrayObject) {
            $this->storage->offsetUnset($this->getHash($vertex));
        } else {
            parent::detach($vertex);
        }
    }

    /**
     * @param object $vertex
     */
    public
    function offsetUnset($vertex) {
        $this->detach($vertex);
    }
}
