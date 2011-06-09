<?php

/*
 * (c) 2010 - Cooperativa de Trabajo Alyssa Limitada
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfGridAlyssaJqGridRoute represents a route that is bound to an GridAlyssaJqGrid-class.
 *
 * @package    lib
 * @subpackage routing
 * @author     Sergio Fabian Vier <sergio.vier@alyssa-it.com>
 * @version    SVN: $Id$
 */
class sfGridAlyssaJqGridRoute extends sfGridRoute
{
  public function __construct($pattern, array $defaults = array(), array $requirements = array(), array $options = array())
  {

    if (strpos($pattern,':sf_format') === false)
    {
      $pattern .= '.:sf_format';
    }

    $defaults = array_merge(
      array(
        'module' => 'alyssaJqGrid',
        'action' => 'index',
        'sf_format' => 'html',
      ),
      $defaults
    );

    if (!isset($requirements['sf_method']))
    {
      $requirements['sf_method'] = array('get', 'head', 'post');
    }
    else
    {
      $requirements['sf_method'] = array_map('strtolower', (array) $requirements['sf_method']);
    }

    parent::__construct($pattern, $defaults, $requirements, $options);
  }


  protected function getObjectForParameters($parameters)
  {
    $request = sfContext::getInstance()->getRequest();
    $getParameters = $request->getGetParameters();

    // we need to set page only when there isn't a "max per page" value to set!
    if (isset($getParameters['page']))  $parameters['page'] = $getParameters['page'];

    // if has set up a value (clicked a column to define order)
    if (isset($getParameters['sidx']) && $getParameters['sidx'] != '')
    {
      $parameters['sort'] = $getParameters['sidx'];

      if (isset($getParameters['sord']))  $parameters['type'] = $getParameters['sord'];
    }

    if (isset($getParameters['rows']))  $parameters['rows'] = $getParameters['rows'];

    if (isset($getParameters['_search']) && $getParameters['_search'] == 'true')
    {
      // we can have a single search or advanced search
      if (isset($getParameters['searchField']))
      {
        /*$search = array(array(
          'column'     => $getParameters['searchField'],
          'comparison' => $this->convertComparison($getParameters['searchOper']),
          'value'      => $getParameters['searchString']
        ));*/

      }
      elseif (isset($getParameters['filters']))
      {
        $filters = json_decode($getParameters['filters'], true);

        $search = array(
          'fields'         => array(),
          'group_operator' => $filters['groupOp']
        );

        foreach($filters['rules'] as $rule)
        {
          // convert operations to given implementation of DataSource
          $comparison = $this->convertOperator($rule['op']);
          $value      = $this->convertData($rule['data'], $rule['op']);

          $search['fields'][$rule['field']][] = array(
            'comparison' => $comparison,
            'value'      => $value,
          );
        }
      }

      $parameters['search'] = $search;
    }

    return parent::getObjectForParameters($parameters);
  }

  private function convertOperator($value)
  {
    switch ($value) {
      case 'AND':  // group operator
        $result = sfDataSource::GROUP_AND;
        break;
      case 'OR':   // group operator
        $result = sfDataSource::GROUP_OR;
        break;
      case 'eq':
        $result = sfDataSource::EQUAL;
        break;
      case 'ne':
        $result = sfDataSource::NOT_EQUAL;
        break;
      case 'lt':
        $result = sfDataSource::LESS_THAN;
        break;
      case 'le':
        $result = sfDataSource::LESS_EQUAL;
        break;
      case 'gt':
        $result = sfDataSource::GREATER_THAN;
        break;
      case 'ge':
        $result = sfDataSource::GREATER_EQUAL;
        break;
      case 'in':  // in
        $result = sfDataSource::IN;
        break;
      case 'ni':  // not in
        $result = sfDataSource::NOT_IN;
        break;
      case 'bw':  // begin with
      case 'ew':  // end with
      case 'cn':  // contains
        $result = sfDataSource::LIKE;
        break;
      case 'bn':  // not begin with
      case 'en':  // not end with
      case 'nc':  // not contains
        $result = sfDataSource::NOT_LIKE;
        break;
      default:
        $result = sfDataSource::EQUAL;
        break;
    }
    return $result;
  }

  private function convertData($data, $operator)
  {
    switch ($operator) {
      case 'bw':
      case 'bn':
        $data = $data . '%';
        break;
      case 'ew':
      case 'en':
        $data = '%' . $data;
        break;
      case 'cn':
      case 'nc':
        $data = '%' . $data . '%';
        break;
      case 'in':
      case 'ni':
        throw new Exception("This type is not implemented yet");
        break;
      default:
        break;
    }

    return $data;
  }
}
