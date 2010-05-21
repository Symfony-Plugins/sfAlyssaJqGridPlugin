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
   * the name of the AlyssaJqGrid-components
   *
   * @var string
   */
  protected $name;

  protected $rowActions = null;

  /**
   * Constructor.
   *
   * @param string $name   the name of the Alyssa Grid-components
   * @param  mixed $source An array or an instance of sfDataSourceInterface with
   *                       data that should be displayed in the grid.
   *                       If an array is given, the array must conform to the
   *                       requirements of the constructor of sfDataSourceArray.
   */
  public function __construct($name, $source)
  {
    parent::__construct($source);
    //FALTA: cambiar esto a opciones de una grilla.
    $this->name = $name;
  }

  /**
   * Configures the grid. This method is called from the constructor. It can
   * be overridden in child classes to configure the grid.
   */
  public function configure()
  {
    parent::configure();

    // get the source from the original pager
    //$source = $this->getPager()->getDataSource();
    // redefine the pager
    //    $this->pager = new sfDataSourcePagerAlyssa($source);

    // define the javascript formatter
    $this->setJavaScriptFormatter(new sfGridFormatterAlyssaJqGrid($this));

    // define the json formatter for Alyssa
    $this->setDataFormatter(new sfGridFormatterJsonAlyssaJqGrid($this));
  }

  /**
   * returns the name of the sfAlyssaJqGrid-components
   *
   * @return string
   */
  public function getName()
  {
    return $this->name;
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

  public function setRowActions($actions){
    foreach ($actions as $key => $action)
    {
      //TODO: make validations?
      $action->setGrid($this);
      $actions[$key] = $action;
    }

    $this->rowActions = $actions;
  }

  public function getRowActions(){
    return $this->rowActions;
  }

  public function hasRowActions(){
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