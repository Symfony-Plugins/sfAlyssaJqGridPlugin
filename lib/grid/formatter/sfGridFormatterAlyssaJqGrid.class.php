<?php
/*
 * (c) 2010 - Cooperativa de Trabajo Alyssa Limitada
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A formatter that renders as html
 *
 * @package    grid
 * @subpackage formatter
 * @author     Sergio Fabian Vier <sergio.vier@alyssa-it.com>
 * @version    SVN: $Id$
 */
class sfGridFormatterAlyssaJqGrid extends sfGridFormatterDynamic
{
  /**
   *
   * @param sfGridAlyssaJqGrid $grid
   */
  public function __construct(sfGridAlyssaJqGrid $grid)
  {
    // grid setup
    $this->grid = $grid;
    $this->row = new sfGridFormatterAlyssaJqGridRow($grid, 0);
  }


  public function getColumnNamesConfig()
  {

    $columnNameConfig = array();

    foreach ($this->grid->getColumns() as $column)
    {
      $columnNameConfig[] = $this->grid->getTitleForColumn($column);
    }

    if ($this->grid->hasRowActions())
    {
      $columnNameConfig[] = "Actions";
    }

    return $columnNameConfig;
  }

  /**
   * Returns an array of columns, containing Json-arrays with parameters
   *
   * @return array
   */
  public function getColumnModelConfig()
  {
    $columnModelConfig = array();

    $sortable = $this->grid->getSortable();

    foreach ($this->grid->getWidgets() as $column => $widget)
    {
      $columnConfig             = $widget->getColumnConfig($column);
      $columnConfig['name']     = $this->grid->getTitleForColumn($column);
      $columnConfig['index']    = $this->grid->getTitleForColumn($column);
      $columnConfig['sortable'] = in_array($column, $sortable);

      $columnModelConfig[] = $columnConfig;
    }

    if ($this->grid->hasRowActions())
    {
      $columnModelConfig[] = array('name' => 'Actions', 'index' => 'Actions', 'sortable' => false, 'aling' => 'center');
    }

    return $columnModelConfig;
  }


  /**
   * currently does it all... needs to be refactored obviously
   * @return string
   */
  public function render()
  {
    $controller = sfContext::getInstance()->getController();

    $route = strtolower($this->grid->getName());
    $url = url_for("@grid_{$route}?sf_format=json", true);

    $javascript = <<<EOF
<table id="grid"></table>
<div id="pager"></div>
<script type="text/javascript">
jQuery("#grid").jqGrid(%grid%);
jQuery("#grid").jqGrid('navGrid','#pager',{edit:false,add:false,del:false});
</script>
EOF;

    $grid = json_encode(array(
              'url'         => $url,
              'datatype'    => 'json',
              'colNames'    => $this->getColumnNamesConfig(),
              'colModel'    => $this->getColumnModelConfig(),
              'rowNum'      => $this->grid->getPager()->getMaxPerPage(),
              'rowList'     => array(10,20,30),
              'pager'       => '#pager',
              //'sortname'    => 'identifier',
              'gridview'    => true,              //remember, this option disabe subgrid and treeview features
              'viewrecords' => true,
              'sortorder'   => 'desc',
              'autowidth'   => true,
              'multiselect' => true,
              'caption'     => $this->grid->getTitle(),
    ));

    return strtr($javascript, array('%grid%' => $grid));

  }

  public function setRowActions($actions)
  {
    $this->row->setRowActions($actions);
  }

}
