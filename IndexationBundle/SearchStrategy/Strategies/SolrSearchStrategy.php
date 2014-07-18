<?php

namespace PHPOrchestra\IndexationBundle\SearchStrategy\Strategies;

use PHPOrchestra\IndexationBundle\SearchStrategy\SearchInterface;
use Solarium\Client;
use Solarium\QueryType\Select\Query\Component\FacetSet;
use Solarium\QueryType\Select\Query\Query;

class SolrSearchStrategy implements SearchInterface
{
    protected $solarium;
    protected $indexationType;

    /**
     * @param array  $indexationType
     * @param Client $solarium
     */
    public function __construct(
        array $indexationType,
        Client $solarium
    )
    {
        $this->solarium = $solarium;
        $this->indexationType = $indexationType;
    }

    /**
     * Check if the search is supported
     *
     * @return boolean
     */
    public function supportSearch()
    {
        foreach ($this->indexationType as $type) {
            if ('solr' == $type) {
                return true;
            }
        }

        return false;
    }

    /**
     * This allows you to search
     *
     * @param string     $data search words
     * @param Query|null $query
     * @param array      $options
     *
     * @return Query
     */
    public function search($data, $query = null, $options = array())
    {
        if (null === $query) {
            $query = $this->solarium->createSelect();
        }

        $query->setQuery($data);
        if (isset($options)) {
            if (isset($options['start']) && isset($options['rows'])) {
                $query->setStart($options['start'])->setRows($options['rows']);
            }
            if (isset($options['fields'])) {
                $query->Fields($options['fields']);
            }
            if (isset($options['sort']) && isset($options['sortMode'])) {
                $sortMode = 'Solarium\QueryType\Select\Query\Query::'.$options['sortMode'];
                $query->addSort($options['sort'], $sortMode);
            }
        }

        return $query;
    }

    /**
     * @param Query $query
     * @param string|array $fields fields name
     * @param string|array $boost boosts number
     * @param string $mm Minimum Match
     *
     * @return Query
     */
    public function disMax(Query $query, $fields, $boost, $mm = null)
    {
        $dismax = $query->getDisMax();
        $dismax->setQueryParser('edismax');

        if (is_array($fields) && is_array($boost)) {
            $stringField = '';
            $i = 0;
            foreach ($fields as $field) {
                $stringField .= $field.'^'.$boost[$i].' ';
                $i++;
            }
            $dismax->setQueryFields($stringField);
        } else {
            $dismax->setQueryFields($fields.'^'.$boost);
        }

        // Minimum Match
        if (isset($mm)) {
            $dismax->setMinimumMatch($mm);
        }

        return $query;
    }

    /**
     * This allows you to search with approach spell
     *
     * @param Query $query
     * @param string $data search words
     * @param int|null $number number of spellcheck response
     *
     * @return Query
     */
    public function spellCheck(Query $query, $data, $number = null)
    {
        //Spell check setting
        $spellcheck = $query->getSpellcheck();
        $spellcheck->setQuery($data);

        if (isset($number)) {
            $spellcheck->setCount($number);
        }
        //$spellcheck->setCollate(true);
        $spellcheck->setExtendedResults(true);
        $spellcheck->setCollateExtendedResults(true);

        return $query;
    }

    /**
     * This allows you to specify a field which should be treated as a facet
     *
     * @param FacetSet $facetSet
     * @param string $name facet's name
     * @param string $field field where we use facet
     * @param array $options array of facet options
     */
    public function facetField(FacetSet $facetSet, $name, $field, $options = array())
    {
        $facet = $facetSet->createFacetField($name)->setField($field);
        if (isset($options)) {
            if (isset($options['sort'])) {
                $facet->setSort($options['sort']);
            }
            if (isset($options['limit'])) {
                $facet->setLimit($options['limit']);
            }
            if (isset($options['prefix'])) {
                $facet->setPrefix($options['prefix']);
            }
            if (isset($options['offset'])) {
                $facet->setOffset($options['offset']);
            }
            if (isset($options['minCount'])) {
                $facet->setMinCount($options['minCount']);
            }
            if (isset($options['missing'])) {
                $facet->setMissing($options['missing']);
            }
        }
    }

    /**
     * This allows you to specify an arbitrary query to generate a facet count.
     *
     * @param FacetSet $facetSet
     * @param string $field
     * @param string $query
     */
    public function facetQuery(FacetSet $facetSet, $field, $query)
    {
        $facet = $facetSet->createFacetQuery($field)->setQuery($query);
    }

    /**
     * This allows you to specify several arbitrary query to generate a facet count.
     *
     * @param FacetSet $facetSet
     * @param string $field name of field
     * @param array $queries several query
     */
    public function facetmultiQuery(FacetSet $facetSet, $field, $queries)
    {
        $facet = $facetSet->createFacetMultiQuery($field);

        if (is_array($queries)) {
            foreach ($queries as $name => $query) {
                $facet->createQuery($name, $query);
            }
        }
    }

    /**
     * This alloaws you to specify range to generate a facet
     *
     * @param FacetSet $facetSet
     * @param string $name name of this facet
     * @param string $field name of the field for the facet
     * @param int $start starting number
     * @param int $gap gap for the facet
     * @param int $end ending number
     */
    public function facetRange(FacetSet $facetSet, $name, $field, $start, $gap, $end)
    {
        $facet = $facetSet->createFacetRange($name);
        $facet->setField($field);
        $facet->setStart($start);
        $facet->setGap($gap);
        $facet->setEnd($end);
    }

    /**
     * This allows you to create a filter
     *
     * @param Query $query
     * @param string $name name of filter
     * @param string $filter the filter query
     *
     * @return Query
     */
    public function filter(Query $query, $name, $filter)
    {
        $query->createFilterQuery($name)->setQuery($filter);

        return $query;
    }

    /**
     * @param Query $query
     *
     * @return mixed
     */
    public function select(Query $query)
    {
        return $this->solarium->select($query);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'solr';
    }
}