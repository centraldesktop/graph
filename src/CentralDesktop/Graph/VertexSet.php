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
use ArrayIterator;

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

    /**
     * @var ArrayIterator
     */
    private $iterator;

    public
    function __construct() {
        if (version_compare(PHP_VERSION, '5.4', '<')) {
            $this->storage = new ArrayObject;
        }
    }

    /**
     * @param object $vertex
     * @param null   $data
     */
    public
    function attach($vertex, $data = null) {
        if ($this->storage instanceof ArrayObject) {
            if (is_null($data)) {
                $data = $vertex;
            }
            $offset = $this->getHash($vertex);
            if (!$this->storage->offsetExists($offset)) {
                $this->storage->offsetSet($offset, $data);
            }
        } else {
            parent::attach($vertex, $data);
        return $vertex->__toString();
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
     * @return int
     */
    public
    function count() {
        if ($this->storage instanceof ArrayObject) {
            return $this->storage->count();
        } else {
            return parent::count();
        }
    }

    /**
     * @return mixed|object
     */
    public
    function current() {
        if ($this->storage instanceof ArrayObject) {
            if (!$this->iterator instanceof ArrayIterator) {
                $this->iterator = $this->storage->getIterator();
            }
            return $this->iterator->current();
        } else {
            return parent::current();
        }
    }

    /**
     * @param object $vertex
     */
    public
    function detach($vertex) {
        if ($this->storage instanceof ArrayObject) {
            $offset = $this->getHash($vertex);
            if ($this->storage->offsetExists($offset)) {
                $this->storage->offsetUnset($offset);
            }
        } else {
            parent::detach($vertex);
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
        return $vertex->__toString();
    }

    /**
     * @return int
     */
    public
    function key() {
        if ($this->storage instanceof ArrayObject) {
            if (!$this->iterator instanceof ArrayIterator) {
                $this->iterator = $this->storage->getIterator();
            }
            return $this->iterator->key();
        } else {
            return parent::key();
        }
    }

    public
    function next() {
        if ($this->storage instanceof ArrayObject) {
            if (!$this->iterator instanceof ArrayIterator) {
                $this->iterator = $this->storage->getIterator();
            }
            $this->iterator->next();
        } else {
            parent::next();
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
    function offsetUnset($vertex) {
        $this->detach($vertex);
    }

    public
    function rewind() {
        if ($this->storage instanceof ArrayObject) {
            if (!$this->iterator instanceof ArrayIterator) {
                $this->iterator = $this->storage->getIterator();
            }
            $this->iterator->rewind();
        } else {
            parent::rewind();
        }
    }

    /**
     * @return string
     */
    public
    function serialize() {
        if ($this->storage instanceof ArrayObject) {
            /**
             * This is actually not a void function
             */
            return $this->storage->serialize();
        } else {
            return parent::serialize();
        }
    }

    /**
     * @param string $serialized
     */
    public
    function unserialize($serialized) {
        if ($this->storage instanceof ArrayObject) {
            $this->storage->unserialize($serialized);
        } else {
            parent::unserialize($serialized);
        }
    }

    /**
     * @return bool
     */
    public
    function valid() {
        if ($this->storage instanceof ArrayObject) {
            if (!$this->iterator instanceof ArrayIterator) {
                $this->iterator = $this->storage->getIterator();
            }
            return $this->iterator->valid();
        } else {
            return parent::valid();
        }
    }
}
