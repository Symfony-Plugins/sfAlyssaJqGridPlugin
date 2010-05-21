<?php
/*
 * (c) 2010 - Cooperativa de Trabajo Alyssa Limitada
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetAlyssaJqGridLink
 *
 * @package    lib
 * @subpackage widget
 * @author     Sergio Fabian Vier <sergio.vier@alyssa-it.com>
 * @version    SVN: $Id$
 */
class sfWidgetAlyssaJqGridLink extends sfWidgetGridLink
{

  /**
   * Configures the current widget.
   *
   * This method allows each widget to add options or HTML attributes
   * during widget creation.
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of HTML attributes
   *
   * @see __construct()
   */
  public function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    // options for render the widget
    //$this->addOption('column_config.name', '');
    $this->addOption('column_config.width', 140);
    $this->addOption('column_config.sortable', false);
    $this->addOption('column_config.align', 'center');

    // options for render
    $this->addOption('icon', 'ui-icon-document');
    $this->addOption('label', null);

    //    # icon class as: ui-icon-value
    //    icons:
    //      new:          plus
    //      filter:       check
    //      filters:      search
    //      reset:        circle-close
    //      show:         document
    //      edit:         pencil
    //      delete:       trash
    //      list:         arrowreturnthick-1-w
    //      save:         circle-check
    //      saveAndAdd:   circle-plus
    //      first:        seek-first
    //      previous:     seek-prev
    //      next:         seek-next
    //      last:         seek-end
  }


  /**
   * renders value (you can extend this class and pre-process this value)
   *
   * @see sfWidget#render()
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url', 'Tag'));

    $name = $this->getOption('label') ? $this->getOption('label') : $name;
    // add styles for a link button in jquery
    $name = sprintf('<span class="ui-icon %s"></span>', $this->getOption('icon')).$name;
    $attributes['class'] = 'fg-button-mini fg-button ui-state-default fg-button-icon-left';

    return link_to($name, $this->getUri(), $attributes);
  }

  /**
   * Returns the column-definition for ColumnModel
   * this is defined in the widget, to allow you to define the type
   *
   * @param string $name
   * @return array
   */
  public function getColumnConfig($name)
  {
    $arrJs = array(
      //'name'      => $this->getOption('column_config.name'),
      'width'     => $this->getOption('column_config.width'),
      'sortable'  => $this->getOption('column_config.sortable'),
      'align'     => $this->getOption('column_config.align'),
    );

    return $arrJs;
  }

}