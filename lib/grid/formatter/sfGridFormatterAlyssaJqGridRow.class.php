<?php
/*
 * (c) 2010 - Cooperativa de Trabajo Alyssa Limitada
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A formatter that renders a row
 *
 * @package    grid
 * @subpackage formatter
 * @author     Sergio Fabian Vier <sergio.vier@alyssa-it.com>
 * @version    SVN: $Id$
 */
class sfGridFormatterAlyssaJqGridRow extends sfGridFormatterDynamicRow
{

  protected $rowActions = array();

  /**
   * Renders a row to html
   *
   * @return string
   */
  public function render()
  {
    $source = $this->grid->getDataSource();
    $source->seek($this->index);

    $data = array();

    foreach ($this->grid->getWidgets() as $column => $widget)
    {
      $data[$column] = $source[$column];
    }

    // FALTA: ver si aca esto es necesario! sino solo en el json response!
    if ($this->grid->hasRowActions()){
      $data['actions'] = $this->grid->getRowActions();
    }

    return $data;
  }
}