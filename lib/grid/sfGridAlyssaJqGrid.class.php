<?php

/*
 * (c) 2010 - Cooperativa de Trabajo Alyssa Limitada
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfGridAlyssaJqGrid
 *
 * @package    lib
 * @subpackage grid
 * @author     Sergio Fabian Vier <sergio.vier@alyssa-it.com>
 * @version    SVN: $Id$
 */
class sfGridAlyssaJqGrid extends sfContextGridJavaScript
{

  /**
   * @var array The sfWidgetGird instances that will be actions for the grid.
   */
  protected $rowActions = array();

  /**
   * Constructor.
   *
   * @param string $name   the name of the Alyssa Grid-components
   * @param  mixed $source An array or an instance of sfDataSourceInterface with
   *                       data that should be displayed in the grid.
   *                       If an array is given, the array must conform to the
   *                       requirements of the constructor of sfDataSourceArray.
   */
  public function __construct($source, $options = array())
  {
    parent::__construct($source, $options);
  }

  /**
   * Configures the grid. This method is called from the constructor. It can
   * be overridden in child classes to configure the grid.
   */
  public function configure($options = array())
  {
    parent::configure($options);

    // define the javascript formatter
    $this->setJavaScriptFormatter(new sfGridFormatterAlyssaJqGrid($this));

    // define the json formatter for Alyssa
    $this->setDataFormatter(new sfGridFormatterJsonAlyssaJqGrid($this));
  }

  /**
   * Returns the default widget
   *
   * @return sfWidget
   */
  protected function getDefaultWidget()
  {
    return new sfWidgetAlyssaJqGrid();
  }

  /**
   * Sets a list of widgets that should be used to render actions in the column
   * actions. The widgets should be given as associative array with the column
   * names as keys and instances of sfWidget as values.
   *
   * <code>
   * $grid->setRowActions(array(
   *     "load" => new sfWidgetAlyssaJqGridLink(array(
   *         'action'     => 'module/load',
   *         'key_column' => 'identifier',
   *         'label'      => 'Load',
   *         'icon'       => 'ui-icon-document')),
   *     "delete" => new sfWidgetAlyssaJqGridLink(array(
   *         'action'     => 'module/delete',
   *         'key_column' => 'identifier',
   *         'label'      => 'Delete',
   *         'icon'       => 'ui-icon-trash')),
   * ));
   * </code>
   *
   * Columns for which you do not specify a widget will not be modified. Per
   * default all columns are rendered with sfWidgetText.
   *
   * @param array $widgets   An associative array of column names and widgets
   * @throws LogicException  Throws an exception if any of the given column
   *                         names has not been configured with setColumns()
   */
  public function setRowActions($actions){
    foreach ($actions as $key => $action)
    {
      $this->setRowAction($key, $action);
    }
  }

  /**
   * Sets the widget used to render values in the actions column.
   *
   * <code>
   * $grid->setRowAction(
   *     "load" => new sfWidgetAlyssaJqGridLink(array(
   *         'action'     => 'module/load',
   *         'key_column' => 'identifier',
   *         'label'      => 'Load',
   *         'icon'       => 'ui-icon-document'))
   * ));
   * </code>
   *
   * @param  string $column   The name of the column
   * @param  sfWidget $widget The widget used to render values in this column
   * @throws LogicException   Throws an exception if the given column
   *                          name has not been configured with setColumns()
   */
  public function setRowAction($key, $action)
  {

    if (in_array($key, $this->rowActions))
    {
      throw new LogicException(sprintf('The key "%s" is alredy in use', $column));
    }

    if (!($action instanceof sfWidgetGrid))
    {
      throw new InvalidArgumentException('The given widget must be an instance of sfWidgetGrid class.');
    }

    $action->setGrid($this);

    $this->rowActions[$key] = $action;
  }

  /**
   * Returns the actions widget
   *
   * @return array action widgets present in the grid
   */
  public function getRowActions()
  {
    return $this->rowActions;
  }

  /**
   * Returns whether the grid has widgets setted in the actions column.
   *
   * @return boolean return true if are widgets
   */
  public function hasRowActions()
  {
    return count($this->getRowActions()) > 0;
  }

  /**
   * Gets the JavaScript paths associated with the widget.
   *
   * @return array An array of JavaScript paths
   */
  public function getJavascripts()
  {
    return array('/sfAlyssaJqGridPlugin/js/i18n/grid.locale-sp.js',
                 '/sfAlyssaJqGridPlugin/js/jquery.jqGrid.min.js',);
  }

  /**
   * Gets the stylesheet paths associated with the widget.
   *
   * @return array An array of stylesheet paths
   */
  public function getStylesheets()
  {
    return array('/sfAlyssaJqGridPlugin/css/ui.jqgrid.css' => 'screen');
  }


}