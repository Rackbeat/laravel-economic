<?php

namespace LasseRafn\Economic\Services;

use LasseRafn\Economic\FilterOperators\AndOperator;
use LasseRafn\Economic\FilterOperators\EqualsOperator;
use LasseRafn\Economic\FilterOperators\FilterOperatorInterface;
use LasseRafn\Economic\FilterOperators\GreaterThanOperator;
use LasseRafn\Economic\FilterOperators\GreaterThanOrEqualOperator;
use LasseRafn\Economic\FilterOperators\InOperator;
use LasseRafn\Economic\FilterOperators\LessThanOperator;
use LasseRafn\Economic\FilterOperators\LessThanOrEqualOperator;
use LasseRafn\Economic\FilterOperators\LikeOperator;
use LasseRafn\Economic\FilterOperators\NotEqualsOperator;
use LasseRafn\Economic\FilterOperators\NotInOperator;
use LasseRafn\Economic\FilterOperators\NullOperator;
use LasseRafn\Economic\FilterOperators\OperatorNotFound;
use LasseRafn\Economic\FilterOperators\OrOperator;

class QueryGeneratorService
{
	/**
	 * @param bool $connectorType - Reason for this is , if the overall string being built includes the page size and skippages, the filters and sorts will need to be appended with & to the base query, if not with ?
	 * */
	public static function generateQuery(array $filterParameters = [], array $sortingParameters = [], bool $connectorType = false): string
	{
		if (self::checkIfBothArraysAreEmpty($filterParameters, $sortingParameters)) return '';

	    $baseString = ($connectorType ? '&' : '?');

		self::generateFilterString($baseString, $filterParameters);

		self::generateSortQuery($baseString, $sortingParameters);

	    return $baseString;
	}

	private static function checkIfBothArraysAreEmpty(array $filterParameters, array $sortingParameters): bool
	{
		return (\count($filterParameters) === 0 && empty($sortingParameters));
	}

	protected static function generateFilterString(&$baseString, array $filterParameters): void
	{
		if(\count($filterParameters) === 0) return;

		$baseString .= 'filter=';

	    $i = 1;
	    foreach ($filterParameters as $filter) {
	    	// To support passing in 'and' / 'or' as an individual filter rather than ['', 'and', '']
	    	if (!\is_array($filter) && \count($filter) === 1) {
			    $filterOperator = self::getOperator($filter[0] ?? $filter);

			    if (($filterOperator instanceof OrOperator || $filterOperator instanceof AndOperator)) {
			    	$baseString.= $filterOperator->queryString;
			    	$i++;
			    	continue;
			    }
		    }

		    $filterOperator = self::getOperator($filter[1]);
		    $baseString .= $filter[0] . $filterOperator->queryString . self::transformFilterValue($filter[2], $filterOperator);

		    if (!($filterOperator instanceof OrOperator || $filterOperator instanceof AndOperator) && \count($filterParameters) > $i) {
			    $baseString .= (new AndOperator)->queryString;
		    }

		    $i++;
	    }
	}

    protected static function generateSortQuery(&$baseString, array $sortingParameters): void
    {
	    if (\count($sortingParameters) === 0) return;

	    if( str_contains($baseString, 'filter')) $baseString .= '&';

    	$baseString .= 'sort=';

    	foreach($sortingParameters as $sort)
    	{
    		$baseString .= $sort;

    		if(!($sort === end($sortingParameters))) $baseString .= ',';
    	}
    }

    protected static function transformFilterValue($value, FilterOperatorInterface $filterOperator)
    {
    	if($value === null) {
    	    return (new NullOperator)->queryString;
	    }

    	if ($filterOperator instanceof NullOperator || $filterOperator instanceof OrOperator || $filterOperator instanceof AndOperator ) {
    		return '';
	    }

	    if ($filterOperator instanceof InOperator && \is_array($value)) {
		    return '[' . implode(',', $value) . ']';
	    }

	    $escapedStrings = [
		    '$',
		    '(',
		    ')',
		    '*',
		    '[',
		    ']',
		    ',',
	    ];

	    $urlencodedStrings = [
		    '+',
		    ' ',
	    ];

	    foreach ($escapedStrings as $escapedString) {
		    $value = str_replace($escapedString, '$'.$escapedString, $value);
	    }

	    foreach ($urlencodedStrings as $urlencodedString) {
		    $value = str_replace($urlencodedString, urlencode($urlencodedString), $value);
	    }

	    return $value;
    }

	/**
	 * @param string $operator
	 *
	 * @return FilterOperatorInterface
	 *
	 * @throws OperatorNotFound
	 */
    protected static function getOperator($operator)
    {
	    switch (\mb_strtolower($operator)) {
		    case '=':
		    case '==':
		    case '===':
		     return new EqualsOperator;
		    case '!=':
		    case '!==':
		        return new NotEqualsOperator;
		    case '>':
			    return new GreaterThanOperator;
		    case '>=':
			    return new GreaterThanOrEqualOperator;
		    case '<':
			    return new LessThanOperator;
		    case '<=':
			    return new LessThanOrEqualOperator;
		    case 'like':
			    return new LikeOperator;
		    case 'in':
			    return new InOperator;
		    case '!in':
		    case 'not in':
			    return new NotInOperator;
		    case 'or':
		    case 'or else':
				return new OrOperator;
		    case 'and':
			    return new AndOperator;
		    case 'null':
			    return new NullOperator;
		    default:
			    throw new OperatorNotFound($operator);
	    }
    }

}