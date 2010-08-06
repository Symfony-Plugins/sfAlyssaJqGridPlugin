<?php
/*
 * (c) 2010 - Cooperativa de Trabajo Alyssa Limitada
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetAlyssaJqGridLinkBoolean
 *
 *
 * @package    lib
 * @subpackage widget
 * @author     Sergio Fabian Vier <sergio.vier@alyssa-it.com>
 * @version    SVN: $Id$
 */
class sfWidgetAlyssaJqGridBoolean extends sfWidgetAlyssaJqGrid
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

    // options for render
    $this->addOption('icon', 'ui-icon-check');

  }


  /**
   * renders icon according to the value
   *
   * @see sfWidget#render()
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if ($value)
    {
        return sprintf('<span class="ui-icon %s"></span>', $this->getOption('icon'));
    }
  }


}