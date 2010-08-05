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

    // translate params
    if (isset($getParameters['page']))  $parameters['page'] = $getParameters['page'];
    // if doesn't have setted a value (clicked a column to define order)
    if (isset($getParameters['sidx']) && $getParameters['sidx'] != '')
    {
      $parameters['sort'] = $getParameters['sidx'];
      if (isset($getParameters['sord']))  $parameters['type'] = $getParameters['sord'];
    }


    return parent::getObjectForParameters($parameters);
  }

}