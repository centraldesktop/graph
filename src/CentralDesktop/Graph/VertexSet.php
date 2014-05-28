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
     * @param object $vertex
     * @param null   $data
     */
    public
    function attach($vertex, $data = null) {
        if (is_null($data)) {
            $data = $vertex;
        }

        parent::attach($vertex, $data);
    }

    /**
     * PHP 5>=5.4.0 Implementation
     * @param Vertex $object
     *
     * @return mixed|string
     */
    public
    function getHash($object) {
        return $object->__toString();
    }
}
