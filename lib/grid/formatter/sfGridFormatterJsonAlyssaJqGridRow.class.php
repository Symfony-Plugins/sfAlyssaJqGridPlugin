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

  /**
   * Renders a row to an array
   *
   * @return string
   */
  public function render()
  {
    $this->grid->getDataSource()->seek($this->index);

    $arrData = array();

    $arrData['cell']  = array();

    $widgets = $this->grid->getWidgets();

    foreach ($widgets as $column => $widget)
    {
      $data = $this->grid->getDataForColumn($column);

      $arrData['cell'][] = $widget->render($column, $data);
    }

    if ($this->grid->hasRowActions()){
      $arrData['cell'][] = $this->renderActions();
    }
    return $arrData;
  }

  protected function renderActions()
  {
    $templateActions = <<<EOF2
<ul class="sf_admin_td_actions fg-buttonset fg-buttonset-single">
  %action%
</ul>
EOF2;

    $templateAction = <<<EOF
<li class="sf_admin_action_show">
  %link%
</li>
EOF;

    $actions = '';
    foreach ($this->grid->getRowActions() as $k => $action){
      $actions .= strtr($templateAction, array('%link%' => $action->render($k)));

    }

    return strtr($templateActions, array('%action%' => $actions));
  }

}
