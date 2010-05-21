<?php
/*
 * (c) 2010 - Cooperativa de Trabajo Alyssa Limitada
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A formatter that renders as JSON
 *
 * @package    grid
 * @subpackage formatter
 * @author     Sergio Fabian Vier <sergio.vier@alyssa-it.com>
 * @version    SVN: $Id$
 */
class sfGridFormatterJsonAlyssaJqGrid extends sfGridFormatterDynamic

{
  /**
   * constructor of a Grid Formatter
   *
   * @param sfGrid $grid
   */
  public function __construct(sfGrid $grid)
  {
    parent::__construct($grid, new sfGridFormatterJsonAlyssaJqGridRow($grid, 0));
  }

  /**
   * Renders the row in HTML
   *
   * @return string
   */
  public function render()
  {
    $arrJson = array();

    $arrJson['total'] = $this->grid->getPager()->getRecordCount();
    $arrJson['page']  = $this->grid->getPager()->getPage();
    $arrJson['rows']  = $this->getData();

    return json_encode($arrJson);
  }


  public function getData()
  {
    $arrJson = array();
    foreach ($this as $row)
    {
      $arrJson[] = $row->render();
    }

    return $arrJson;
  }

}

