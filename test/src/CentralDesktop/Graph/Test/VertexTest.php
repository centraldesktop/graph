<?php

namespace CentralDesktop\Graph\Test;
use CentralDesktop\Graph;

class VertexTest extends \PHPUnit_Framework_TestCase {


    /**
     * @expectedException \CentralDesktop\Graph\Exception\DuplicateVertexException
     */
    public function testAddPredecessorDuplcateVertexException() {
        $predecessor = new Graph\Vertex(null);

        $vertex = new Graph\Vertex(null);
        $vertex->add_predecessor($predecessor);
        $vertex->add_predecessor($predecessor);
    }

    public function testAddPredecessor() {
        $predecessor = new Graph\Vertex(null);

        $vertex = new Graph\Vertex(null);
        $vertex->add_predecessor($predecessor);

        $this->assertTrue($vertex->predecessors->contains($predecessor));
    }

    /**
     * @expectedException \CentralDesktop\Graph\Exception\DuplicateVertexException
     */
    public function testAddSuccessorDuplcateVertexException() {
        $successor = new Graph\Vertex(null);

        $vertex = new Graph\Vertex(null);
        $vertex->add_successor($successor);
        $vertex->add_successor($successor);
    }

    public function testAddSuccessor() {
        $successor = new Graph\Vertex(null);

        $vertex = new Graph\Vertex(null);
        $vertex->add_successor($successor);

        $this->assertTrue($vertex->successors->contains($successor));
    }
}