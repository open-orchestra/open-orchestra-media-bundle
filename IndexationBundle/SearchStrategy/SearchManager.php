<?php

namespace PHPOrchestra\IndexationBundle\SearchStrategy;

use PHPOrchestra\IndexationBundle\Exception\SearchStrategyNotFoundException;
use Solarium\QueryType\Select\Query\Component\FacetSet;
use Solarium\QueryType\Select\Query\Query;

class SearchManager
{
    protected $strategies = array();

    public function addStrategy(SearchInterface $strategy)
    {
        $this->strategies[$strategy->getName()] = $strategy;
    }
    /**
     * This allows you to search
     *
     * @param string     $data search words
     * @param Query|null $query
     * @param array      $options
     *
     * @throws SearchStrategyNotFoundException
     * @return Query
     */
    public function search($data, $query = null, $options = array())
    {
        /** @var SearchInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->supportSearch()) {
                return $strategy->search($data, $query, $options);
            }
        }

        throw new SearchStrategyNotFoundException();
    }

    /**
     * @param Query        $query
     * @param string|array $fields fields name
     * @param string|array $boost boosts number
     * @param string       $mm Minimum Match
     *
     * @throws SearchStrategyNotFoundException
     * @return Query
     */
    public function disMax(Query $query, $fields, $boost, $mm = null)
    {
        /** @var SearchInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->supportSearch()) {
                return $strategy->disMax($query, $fields, $boost, $mm);
            }
        }

        throw new SearchStrategyNotFoundException();
    }

    /**
     * This allows you to search with approach spell
     *
     * @param Query    $query
     * @param string   $data search words
     * @param int|null $number number of spellcheck response
     *
     * @throws SearchStrategyNotFoundException
     * @return Query
     */
    public function spellCheck(Query $query, $data, $number = null)
    {
        /** @var SearchInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->supportSearch()) {
                return $strategy->spellCheck($query, $data, $number);
            }
        }

        throw new SearchStrategyNotFoundException();
    }

    /**
     * This allows you to specify a field which should be treated as a facet
     *
     * @param FacetSet $facetSet
     * @param string   $name facet's name
     * @param string   $field field where we use facet
     * @param array    $options array of facet options
     *
     * @throws SearchStrategyNotFoundException
     */
    public function facetField(FacetSet $facetSet, $name, $field, $options = array())
    {
        /** @var SearchInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->supportSearch()) {
                return $strategy->facetField($facetSet, $name, $field, $options);
            }
        }

        throw new SearchStrategyNotFoundException();
    }

    /**
     * This allows you to specify an arbitrary query to generate a facet count.
     *
     * @param FacetSet $facetSet
     * @param string   $field
     * @param string   $query
     *
     * @throws SearchStrategyNotFoundException
     */
    public function facetQuery(FacetSet $facetSet, $field, $query)
    {
        /** @var SearchInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->supportSearch()) {
                return $strategy->facetQuery($facetSet, $field, $query);
            }
        }

        throw new SearchStrategyNotFoundException();
    }

    /**
     * This allows you to specify several arbitrary query to generate a facet count.
     *
     * @param FacetSet $facetSet
     * @param string   $field name of field
     * @param array    $queries several query
     *
     * @throws SearchStrategyNotFoundException
     */
    public function facetmultiQuery(FacetSet $facetSet, $field, $queries)
    {
        /** @var SearchInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->supportSearch()) {
                return $strategy->facetmultiQuery($facetSet, $field, $queries);
            }
        }

        throw new SearchStrategyNotFoundException();
    }

    /**
     * This alloaws you to specify range to generate a facet
     *
     * @param FacetSet $facetSet
     * @param string   $name name of this facet
     * @param string   $field name of the field for the facet
     * @param int      $start starting number
     * @param int      $gap gap for the facet
     * @param int      $end ending number
     *
     * @throws SearchStrategyNotFoundException
     */
    public function facetRange(FacetSet $facetSet, $name, $field, $start, $gap, $end)
    {
        /** @var SearchInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->supportSearch()) {
                return $strategy->facetRange($facetSet, $name, $field, $start, $gap, $end);
            }
        }

        throw new SearchStrategyNotFoundException();
    }

    /**
     * This allows you to create a filter
     *
     * @param Query  $query
     * @param string $name name of filter
     * @param string $filter the filter query
     *
     * @throws SearchStrategyNotFoundException
     * @return Query
     */
    public function filter(Query $query, $name, $filter)
    {
        /** @var SearchInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->supportSearch()) {
                return $strategy->filter($query, $name, $filter);
            }
        }

        throw new SearchStrategyNotFoundException();
    }

    /**
     * @param Query $query
     *
     * @throws SearchStrategyNotFoundException
     * @return mixed
     */
    public function select(Query $query)
    {
        /** @var SearchInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->supportSearch()) {
                return $strategy->select($query);
            }
        }

        throw new SearchStrategyNotFoundException();
    }
}
