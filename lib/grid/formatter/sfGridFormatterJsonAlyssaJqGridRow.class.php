<?php
/*
 * (c) 2010 - Cooperativa de Trabajo Alyssa Limitada
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A formatter that renders a row as JSON
 *
 * @package    grid
 * @subpackage formatter
 * @author     Sergio Fabian Vier <sergio.vier@alyssa-it.com>
 * @version    SVN: $Id$
 */
class sfGridFormatterJsonAlyssaJqGridRow extends sfGridFormatterDynamicRow
{

  protected $templateActions  = <<<EOF2
<ul class="sf_admin_td_actions fg-buttonset fg-buttonset-single">
  %action%
</ul>
EOF2;


  protected $templateAction = <<<EOF
<li class="sf_admin_action_show">
  %link%
</li>
EOF;


  /**
   * Renders a row to an array
   *
   * @return string
   */
  public function render()
  {
    $source = $this->grid->getDataSource();
    $source->seek($this->index);

    $arrData = array();

    $arrData['cell']  = array();

    $widgets = $this->grid->getWidgets();

    foreach ($widgets as $column => $widget)
    {
      $arrData['cell'][] = $widget->render($column, $source[$column]);
    }

    if ($this->grid->hasRowActions()){
      $arrData['cell'][] = $this->renderActions();
    }
    return $arrData;
  }

  protected function renderActions()
  {
    $source = $this->grid->getDataSource();
    $actions = '';
    foreach ($this->grid->getRowActions() as $action){
      $actions .= strtr($this->templateAction, array('%link%' => $action->render($action->getKeyColumn(), $source[$action->getKeyColumn()])));

    }

    return strtr($this->templateActions, array('%action%' => $actions));
  }

}