<?php

namespace EmbyPlaylistApp\Models\Base;

use \Exception;
use \PDO;
use EmbyPlaylistApp\Models\ListFile as ChildListFile;
use EmbyPlaylistApp\Models\ListFileQuery as ChildListFileQuery;
use EmbyPlaylistApp\Models\Map\ListFileTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'list_file' table.
 *
 *
 *
 * @method     ChildListFileQuery orderByListId($order = Criteria::ASC) Order by the list_id column
 * @method     ChildListFileQuery orderByFileId($order = Criteria::ASC) Order by the file_id column
 *
 * @method     ChildListFileQuery groupByListId() Group by the list_id column
 * @method     ChildListFileQuery groupByFileId() Group by the file_id column
 *
 * @method     ChildListFileQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildListFileQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildListFileQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildListFileQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildListFileQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildListFileQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildListFileQuery leftJoinList($relationAlias = null) Adds a LEFT JOIN clause to the query using the List relation
 * @method     ChildListFileQuery rightJoinList($relationAlias = null) Adds a RIGHT JOIN clause to the query using the List relation
 * @method     ChildListFileQuery innerJoinList($relationAlias = null) Adds a INNER JOIN clause to the query using the List relation
 *
 * @method     ChildListFileQuery joinWithList($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the List relation
 *
 * @method     ChildListFileQuery leftJoinWithList() Adds a LEFT JOIN clause and with to the query using the List relation
 * @method     ChildListFileQuery rightJoinWithList() Adds a RIGHT JOIN clause and with to the query using the List relation
 * @method     ChildListFileQuery innerJoinWithList() Adds a INNER JOIN clause and with to the query using the List relation
 *
 * @method     ChildListFileQuery leftJoinFile($relationAlias = null) Adds a LEFT JOIN clause to the query using the File relation
 * @method     ChildListFileQuery rightJoinFile($relationAlias = null) Adds a RIGHT JOIN clause to the query using the File relation
 * @method     ChildListFileQuery innerJoinFile($relationAlias = null) Adds a INNER JOIN clause to the query using the File relation
 *
 * @method     ChildListFileQuery joinWithFile($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the File relation
 *
 * @method     ChildListFileQuery leftJoinWithFile() Adds a LEFT JOIN clause and with to the query using the File relation
 * @method     ChildListFileQuery rightJoinWithFile() Adds a RIGHT JOIN clause and with to the query using the File relation
 * @method     ChildListFileQuery innerJoinWithFile() Adds a INNER JOIN clause and with to the query using the File relation
 *
 * @method     \EmbyPlaylistApp\Models\PlaylistQuery|\EmbyPlaylistApp\Models\FileQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildListFile findOne(ConnectionInterface $con = null) Return the first ChildListFile matching the query
 * @method     ChildListFile findOneOrCreate(ConnectionInterface $con = null) Return the first ChildListFile matching the query, or a new ChildListFile object populated from the query conditions when no match is found
 *
 * @method     ChildListFile findOneByListId(int $list_id) Return the first ChildListFile filtered by the list_id column
 * @method     ChildListFile findOneByFileId(int $file_id) Return the first ChildListFile filtered by the file_id column *

 * @method     ChildListFile requirePk($key, ConnectionInterface $con = null) Return the ChildListFile by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildListFile requireOne(ConnectionInterface $con = null) Return the first ChildListFile matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildListFile requireOneByListId(int $list_id) Return the first ChildListFile filtered by the list_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildListFile requireOneByFileId(int $file_id) Return the first ChildListFile filtered by the file_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildListFile[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildListFile objects based on current ModelCriteria
 * @method     ChildListFile[]|ObjectCollection findByListId(int $list_id) Return ChildListFile objects filtered by the list_id column
 * @method     ChildListFile[]|ObjectCollection findByFileId(int $file_id) Return ChildListFile objects filtered by the file_id column
 * @method     ChildListFile[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ListFileQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \EmbyPlaylistApp\Models\Base\ListFileQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\EmbyPlaylistApp\\Models\\ListFile', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildListFileQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildListFileQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildListFileQuery) {
            return $criteria;
        }
        $query = new ChildListFileQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$list_id, $file_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildListFile|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ListFileTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ListFileTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildListFile A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT list_id, file_id FROM list_file WHERE list_id = :p0 AND file_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildListFile $obj */
            $obj = new ChildListFile();
            $obj->hydrate($row);
            ListFileTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildListFile|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildListFileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ListFileTableMap::COL_LIST_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ListFileTableMap::COL_FILE_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildListFileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ListFileTableMap::COL_LIST_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ListFileTableMap::COL_FILE_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the list_id column
     *
     * Example usage:
     * <code>
     * $query->filterByListId(1234); // WHERE list_id = 1234
     * $query->filterByListId(array(12, 34)); // WHERE list_id IN (12, 34)
     * $query->filterByListId(array('min' => 12)); // WHERE list_id > 12
     * </code>
     *
     * @see       filterByList()
     *
     * @param     mixed $listId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildListFileQuery The current query, for fluid interface
     */
    public function filterByListId($listId = null, $comparison = null)
    {
        if (is_array($listId)) {
            $useMinMax = false;
            if (isset($listId['min'])) {
                $this->addUsingAlias(ListFileTableMap::COL_LIST_ID, $listId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($listId['max'])) {
                $this->addUsingAlias(ListFileTableMap::COL_LIST_ID, $listId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ListFileTableMap::COL_LIST_ID, $listId, $comparison);
    }

    /**
     * Filter the query on the file_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFileId(1234); // WHERE file_id = 1234
     * $query->filterByFileId(array(12, 34)); // WHERE file_id IN (12, 34)
     * $query->filterByFileId(array('min' => 12)); // WHERE file_id > 12
     * </code>
     *
     * @see       filterByFile()
     *
     * @param     mixed $fileId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildListFileQuery The current query, for fluid interface
     */
    public function filterByFileId($fileId = null, $comparison = null)
    {
        if (is_array($fileId)) {
            $useMinMax = false;
            if (isset($fileId['min'])) {
                $this->addUsingAlias(ListFileTableMap::COL_FILE_ID, $fileId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fileId['max'])) {
                $this->addUsingAlias(ListFileTableMap::COL_FILE_ID, $fileId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ListFileTableMap::COL_FILE_ID, $fileId, $comparison);
    }

    /**
     * Filter the query by a related \EmbyPlaylistApp\Models\Playlist object
     *
     * @param \EmbyPlaylistApp\Models\Playlist|ObjectCollection $playlist The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildListFileQuery The current query, for fluid interface
     */
    public function filterByList($playlist, $comparison = null)
    {
        if ($playlist instanceof \EmbyPlaylistApp\Models\Playlist) {
            return $this
                ->addUsingAlias(ListFileTableMap::COL_LIST_ID, $playlist->getId(), $comparison);
        } elseif ($playlist instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ListFileTableMap::COL_LIST_ID, $playlist->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByList() only accepts arguments of type \EmbyPlaylistApp\Models\Playlist or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the List relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildListFileQuery The current query, for fluid interface
     */
    public function joinList($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('List');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'List');
        }

        return $this;
    }

    /**
     * Use the List relation Playlist object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EmbyPlaylistApp\Models\PlaylistQuery A secondary query class using the current class as primary query
     */
    public function useListQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinList($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'List', '\EmbyPlaylistApp\Models\PlaylistQuery');
    }

    /**
     * Filter the query by a related \EmbyPlaylistApp\Models\File object
     *
     * @param \EmbyPlaylistApp\Models\File|ObjectCollection $file The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildListFileQuery The current query, for fluid interface
     */
    public function filterByFile($file, $comparison = null)
    {
        if ($file instanceof \EmbyPlaylistApp\Models\File) {
            return $this
                ->addUsingAlias(ListFileTableMap::COL_FILE_ID, $file->getId(), $comparison);
        } elseif ($file instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ListFileTableMap::COL_FILE_ID, $file->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFile() only accepts arguments of type \EmbyPlaylistApp\Models\File or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the File relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildListFileQuery The current query, for fluid interface
     */
    public function joinFile($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('File');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'File');
        }

        return $this;
    }

    /**
     * Use the File relation File object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EmbyPlaylistApp\Models\FileQuery A secondary query class using the current class as primary query
     */
    public function useFileQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFile($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'File', '\EmbyPlaylistApp\Models\FileQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildListFile $listFile Object to remove from the list of results
     *
     * @return $this|ChildListFileQuery The current query, for fluid interface
     */
    public function prune($listFile = null)
    {
        if ($listFile) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ListFileTableMap::COL_LIST_ID), $listFile->getListId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ListFileTableMap::COL_FILE_ID), $listFile->getFileId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the list_file table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ListFileTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ListFileTableMap::clearInstancePool();
            ListFileTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ListFileTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ListFileTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ListFileTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ListFileTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ListFileQuery
