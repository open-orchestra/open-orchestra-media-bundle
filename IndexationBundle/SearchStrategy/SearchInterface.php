<?php

namespace PHPOrchestra\IndexationBundle\SearchStrategy;

use Solarium\QueryType\Select\Query\Component\FacetSet;
use Solarium\QueryType\Select\Query\Query;

/**
 * Interface SearchInterface
 */
interface SearchInterface
{
    /**
     * Check if the search is supported
     *
     * @return boolean
     */
    public function supportSearch();

    /**
     * @return string
     */
    public function getName();

    /**
     * This allows you to search
     *
     * @param string     $data search words
     * @param Query|null $query
     * @param array      $options
     *
     * @return Query
     */
    public function search($data, $query = null, $options = array());

    /**
     * @param Query        $query  query
     * @param string|array $fields fields name
     * @param string|array $boost  boosts number
     * @param string       $mm     Minimum Match
     *
     * @return Query
     */
    public function disMax(Query $query, $fields, $boost, $mm = null);

    /**
     * This allows you to search with approach spell
     *
     * @param Query    $query  query
     * @param string   $data   search words
     * @param int|null $number number of spellcheck response
     *
     * @return Query
     */
    public function spellCheck(Query $query, $data, $number = null);

    /**
     * This allows you to specify a field which should be treated as a facet
     *
     * @param FacetSet $facetSet facet object
     * @param string   $name     facet's name
     * @param string   $field    field where we use facet
     * @param array    $options  array of facet options
     */
    public function facetField(FacetSet $facetSet, $name, $field, $options = array());

    /**
     * This allows you to specify an arbitrary query to generate a facet count.
     *
     * @param FacetSet $facetSet
     * @param string   $field
     * @param string   $query
     */
    public function facetQuery(FacetSet $facetSet, $field, $query);

    /**
     * This allows you to specify several arbitrary query to generate a facet count.
     *
     * @param FacetSet $facetSet facet object
     * @param string   $field    name of field
     * @param array    $queries  several query
     */
    public function facetmultiQuery(FacetSet $facetSet, $field, $queries);

    /**
     * This alloaws you to specify range to generate a facet
     *
     * @param FacetSet $facetSet facet object
     * @param string   $name     name of this facet
     * @param string   $field    name of the field for the facet
     * @param int      $start    starting number
     * @param int      $gap      gap for the facet
     * @param int      $end      ending number
     */
    public function facetRange(FacetSet $facetSet, $name, $field, $start, $gap, $end);

    /**
     * This allows you to create a filter
     *
     * @param Query  $query  query
     * @param string $name   name of filter
     * @param string $filter the filter query
     *
     * @return Query
     */
    public function filter(Query $query, $name, $filter);

    /**
     * @param Query $query
     *
     * @return mixed
     */
    public function select(Query $query);
}
