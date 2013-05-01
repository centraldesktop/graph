<?php

namespace CentralDesktop\Graph\Test;
use CentralDesktop\Graph;
use CentralDesktop\Graph\Edge;

class GraphTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider add_vertex_provider
     *
     * @param Graph\Graph $graph
     * @param Graph\Vertex $vertex
     * @param bool $has_vertex
     * @param bool $expected_return
     * @param array $expected_vertices
     */
    public function testAddVertex(Graph\Graph $graph, Graph\Vertex $vertex, $has_vertex, $expected_return, $expected_vertices) {
        $graph->expects($this->any())
            ->method('has_vertex')
            ->will($this->returnValue($has_vertex));

        $this->assertEquals($expected_return, $graph->add_vertex($vertex));
        foreach ($expected_vertices as $vertex) {
            $this->assertTrue($graph->get_vertices()->contains($vertex));
        }
    }

    public function add_vertex_provider() {
        $vertex = new Graph\Vertex(null);

        $contains_graph = $this->getMockBuilder('\CentralDesktop\Graph\Graph')
            ->setMethods(array('__construct', 'has_vertex'))
            ->getMockForAbstractClass();

        $contains_graph->add_vertex($vertex);

        $does_not_contain_graph = $this->getMockBuilder('\CentralDesktop\Graph\Graph')
            ->setMethods(array('__construct', 'has_vertex'))
            ->getMockForAbstractClass();

        return array(
            array(
                $contains_graph,
                $vertex,
                true,
                false,
                array()
            ),
            array(
                $does_not_contain_graph,
                $vertex,
                false,
                true,
                array($vertex)
            ),
            array(
                clone($contains_graph),
                $vertex,
                false,
                true,
                array($vertex)
            ),
            array(
                clone($does_not_contain_graph),
                $vertex,
                true,
                false,
                array()
            )
        );
    }

    /**
     * @dataProvider add_edge_provider
     *
     * @param Graph\Graph $graph
     * @param Graph\Vertex $source
     * @param Graph\Vertex $target
     * @param bool $expected_return
     * @param array $expected_vertices
     */
    public function testAddEdge(Graph\Graph $graph, Graph\Vertex $source, Graph\Vertex $target, $expected_return, $expected_vertices) {
        $this->assertEquals($expected_return, $graph->add_edge($source, $target));
        foreach ($expected_vertices as $vertex) {
            $this->assertTrue($graph->get_vertices()->contains($vertex));
            $this->assertTrue($source->outgoing_edges->contains($graph->get_edge($source, $target)));
            $this->assertTrue($target->incoming_edges->contains($graph->get_edge($source, $target)));
        }

        $this->assertTrue($graph->has_edge($source, $target));
    }

    public function add_edge_provider() {
        $source_a = new Graph\Vertex('a');
        $target_a = new Graph\Vertex('b');

        $source_b = new Graph\Vertex('c');
        $target_b = new Graph\Vertex('d');

        $source_c = new Graph\Vertex('e');
        $target_c = new Graph\Vertex('f');

        $contains_both_graph = $this->getMock('\CentralDesktop\Graph\Graph\DirectedGraph', null);

        $contains_source_graph = $this->getMock('\CentralDesktop\Graph\Graph\DirectedGraph', null);

        $contains_target_graph = $this->getMock('\CentralDesktop\Graph\Graph\DirectedGraph', null);
        $contains_target_graph->add_vertex($target_c);

        return array(
            array(
                $contains_both_graph,
                $source_a,
                $target_a,
                true,
                array($source_a, $target_a)
            ),
            array(
                $contains_both_graph,  // second time false
                $source_a,
                $target_a,
                false,
                array($source_a, $target_a)
            ),
            array(
                $contains_source_graph,
                $source_b,
                $target_b,
                true,
                array($source_b, $target_b)
            ),
            array(
                $contains_target_graph,
                $source_c,
                $target_c,
                true,
                array($source_c, $target_c)
            )
        );
    }
}