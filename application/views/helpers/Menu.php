<?php
/**
 * This file is part of MySQLDumper released under the GNU/GPL 2 license
 * http://www.mysqldumper.net
 *
 * @package         MySQLDumper
 * @subpackage      View_Helpers
 * @version         SVN: $Rev$
 * @author          $Author$
 */

/**
 * Renders the menu
 *
 * @package         MySQLDumper
 * @subpackage      View_Helpers
 */
class Msd_View_Helper_Menu extends Zend_View_Helper_Abstract
{
    /**
     * Renders the menu
     *
     * @param Msd_Version $version Msd_Version object
     *
     * @return void
     */
    public function menu()
    {
        $front = Zend_Controller_Front::getInstance();
        $request = $front->getRequest();
        if ($request->getActionName() == 'login') {
            //don't render menu when we show the login form
            return;
        }

        $view = $this->view;
        $this->view->request = $request;
        $menu = $view->render('index/menu.phtml');
        return $menu;
    }

}