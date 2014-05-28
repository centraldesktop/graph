<?php

namespace CentralDesktop\Graph\Test;
use CentralDesktop\Graph\Graph\DirectedGraph;
use CentralDesktop\Graph\Graph;
use CentralDesktop\Graph\Edge;
use CentralDesktop\Graph\Vertex;

class GraphTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider add_vertex_provider
     *
     * @param Graph $graph
     * @param Vertex $vertex
     * @param bool $expected_return
     * @param array $expected_vertices
     * @param string $message
     */
    public function testAddVertex(Graph $graph, Vertex $vertex, $expected_return, $expected_vertices, $message) {
        $this->assertEquals($expected_return, $graph->add_vertex($vertex), $message);
        foreach ($expected_vertices as $vertex) {
            $this->assertTrue($graph->get_vertices()->contains($vertex), $message);
        }
    }

    public function add_vertex_provider() {
        $vertex = new Vertex("A");

        $contains_graph = new Graph\DirectedGraph();
        $contains_graph->add_vertex($vertex);

        $does_not_contain_graph = new Graph\DirectedGraph();

        return array(
            array(
                $contains_graph,
                $vertex,
                false,
                array($vertex),
                "Expects Vertex($vertex) to not be added twice."
            ),
            array(
                $does_not_contain_graph,
                $vertex,
                true,
                array($vertex),
                "Expects Vertex($vertex) to be added."
            )
        );
    }

    /**
     * @dataProvider add_edge_provider
     *
     * @param Graph $graph
     * @param Vertex $source
     * @param Vertex $target
     * @param bool $expected_return
     * @param array $expected_vertices
     */
    public function testAddEdge(Graph $graph, Vertex $source, Vertex $target, $expected_return, $expected_vertices) {
        $this->assertEquals($expected_return, $graph->add_edge($source, $target));
        foreach ($expected_vertices as $vertex) {
            $this->assertTrue($graph->get_vertices()->contains($vertex));
            $this->assertTrue($source->outgoing_edges->contains($graph->get_edge($source, $target)));
            $this->assertTrue($target->incoming_edges->contains($graph->get_edge($source, $target)));
        }

        $this->assertTrue($graph->has_edge($source, $target));
    }

    public function add_edge_provider() {
        $source_a = new Vertex('a');
        $target_a = new Vertex('b');

        $source_b = new Vertex('c');
        $target_b = new Vertex('d');

        $source_c = new Vertex('e');
        $target_c = new Vertex('f');

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

    /**
     * @dataProvider get_vertex_provider
     *
     * @param Graph  $graph
     * @param              $vertex
     * @param              $expected
     * @param              $msg
     */
    public
    function testGetVertex(Graph $graph, $vertex, $expected, $msg) {
        $this->assertEquals($expected, $graph->get_vertex($vertex), $msg);
    }

    public
    function get_vertex_provider() {
        $graph = new Graph\DirectedGraph();
        $vertex_a = new Vertex('A');
        $vertex_b = new Vertex('B');
        $vertex_c = new Vertex('C');

        $graph->add_vertex($vertex_a);
        $graph->add_vertex($vertex_b);
        $graph->add_vertex($vertex_c);

        return array(
            array(
                $graph,
                'A',
                $vertex_a,
                "Expects to have vertex 'A'"
            ),
            array(
                $graph,
                'B',
                $vertex_b,
                "Expects to have vertex 'B'"
            ),
            array(
                $graph,
                'C',
                $vertex_c,
                "Expects to have vertex 'C'"
            ),
            array(
                $graph,
                'D',
                null,
                "Does not expect to have vertex 'D'"
            )
        );
    }
}