<?php

namespace PHPOrchestra\IndexationBundle\Test\SearchStrategy\Strategies;

use Phake;
use PHPOrchestra\IndexationBundle\SearchStrategy\Strategies\SolrSearchStrategy;

class SolrSearchStrategyTest extends \PHPUnit_Framework_TestCase
{
    protected $query;
    protected $solarium;
    protected $indexationType;
    protected $solrSearchCommand;

    /**
     * Set up unit test
     *
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
        $this->query = Phake::mock('Solarium\QueryType\Select\Query\Query');

        $this->indexationType = array('solr');
        $this->solarium = Phake::mock('Solarium\Client');

        $this->solrSearchCommand = new SolrSearchStrategy($this->indexationType, $this->solarium);
    }

    /**
     * Test search()
     */
    public function testSearch()
    {
        $result = $this->solrSearchCommand->search('Bienvenue', $this->query);

        $this->assertEquals($this->query, $result);
    }

    /**
     * Test disMax()
     */
    public function testDisMax()
    {
        $dismax = Phake::mock('Solarium\QueryType\Select\Query\Component\DisMax');
        Phake::when($this->query)->getDisMax(Phake::anyParameters())->thenReturn($dismax);

        $result = $this->solrSearchCommand->disMax($this->query, 'title', '2');

        $this->assertEquals($this->query, $result);
        Phake::verify($this->query)->getDisMax();
    }

    /**
     * Test spellCheck()
     */
    public function testSpellCheck()
    {
        $spellcheck = Phake::mock('Solarium\QueryType\Select\Query\Component\Spellcheck');
        Phake::when($this->query)->getSpellcheck()->thenReturn($spellcheck);

        $result = $this->solrSearchCommand->spellCheck($this->query, 'title');

        $this->assertEquals($this->query, $result);
        Phake::verify($this->query)->getSpellcheck();
    }

    /**
     * Test facetField()
     */
    public function testFacetField()
    {
        $name = 'parent';
        $field = 'parentId';
        $facetSet = Phake::mock('Solarium\QueryType\Select\Query\Component\FacetSet');
        $facetField = Phake::mock('Solarium\QueryType\Select\Query\Component\Facet\Field');
        Phake::when($facetSet)->createFacetField(Phake::anyParameters())->thenReturn($facetField);

        $this->solrSearchCommand->facetField($facetSet, $name, $field);

        Phake::verify($facetSet)->createFacetField($name);
        Phake::verify($facetField)->setField($field);
    }

    /**
     * Test facetQuery()
     */
    public function testFacetQuery()
    {
        $field = 'root';
        $query = 'id:root';
        $facetSet = Phake::mock('Solarium\QueryType\Select\Query\Component\FacetSet');
        $facetQuery = Phake::mock('Solarium\QueryType\Select\Query\Component\Facet\Query');
        Phake::when($facetSet)->createFacetQuery(Phake::anyParameters())->thenReturn($facetQuery);

        $this->solrSearchCommand->facetQuery($facetSet, $field, $query);

        Phake::verify($facetSet)->createFacetQuery($field);
        Phake::verify($facetQuery)->setQuery($query);
    }

    /**
     * Test facetmultiQuery()
     */
    public function testFacetmultiQuery()
    {
        $facetSet = Phake::mock('Solarium\QueryType\Select\Query\Component\FacetSet');
        $facetMulti = Phake::mock('Solarium\QueryType\Select\Query\Component\Facet\MultiQuery');
        Phake::when($facetSet)->createFacetMultiQuery(Phake::anyParameters())->thenReturn($facetMulti);

        $field = 'identifiant';
        $queries = array('root' => 'id: root', 'full' => 'id: fixture_full');
        $this->solrSearchCommand->facetmultiQuery($facetSet, $field, $queries);

        Phake::verify($facetSet)->createFacetMultiQuery($field);
        foreach ($queries as $id => $query) {
            Phake::verify($facetMulti)->createQuery($id, $query);
        }
    }

    /**
     * Test facetRange()
     */
    public function testFacetRange()
    {
        $facetSet = Phake::mock('Solarium\QueryType\Select\Query\Component\FacetSet');
        $facetRange = Phake::mock('Solarium\QueryType\Select\Query\Component\Facet\Range');
        Phake::when($facetSet)->createFacetRange(Phake::anyParameters())->thenReturn($facetRange);

        $name = 'root';
        $field = 'prix';
        $start = 0;
        $gap = 1;
        $end = 10;
        $this->solrSearchCommand->facetRange($facetSet, $name, $field, $start, $gap, $end);

        Phake::verify($facetSet)->createFacetRange($name);
        Phake::verify($facetRange)->setField($field);
        Phake::verify($facetRange)->setStart($start);
        Phake::verify($facetRange)->setGap($gap);
        Phake::verify($facetRange)->setEnd($end);
    }

    /**
     * Test filter()
     */
    public function testFilter()
    {
        $filter = Phake::mock('Solarium\QueryType\Select\Query\FilterQuery');
        Phake::when($this->query)->createFilterQuery(Phake::anyParameters())->thenReturn($filter);

        $name = 'parent';
        $filterName = 'parentId:root';
        $result = $this->solrSearchCommand->filter($this->query, $name, $filterName);

        $this->assertEquals($this->query, $result);
        Phake::verify($this->query)->createFilterQuery($name);
        Phake::verify($filter)->setQuery($filterName);
    }
}
