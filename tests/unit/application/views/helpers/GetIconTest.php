<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'GetIcon.php';

/**
 * @group MsdViewHelper
 */
class GetIconTest extends PHPUnit_Framework_TestCase
{
    public function testGetIconEdit()
    {
        $expected = '<img src="/css/otc/icons/16x16/Edit.png" alt="" title=""/>';
        $viewHelper = new Msd_View_Helper_GetIcon();
        $res = $viewHelper->getIcon('Edit', '', 16);
        $this->assertEquals($expected, $res);
    }

    public function testGetIconEditWithTitle()
    {
        $expected = '<img src="/css/otc/icons/16x16/Edit.png" alt="Titletest" '
            .'title="Titletest"/>';
        $viewHelper = new Msd_View_Helper_GetIcon();
        $res = $viewHelper->getIcon('Edit', 'Titletest', 16);
        $this->assertEquals($expected, $res);
    }

    public function testGetIconInfoSize16()
    {
        $expected = '<img src="/css/otc/icons/16x16/Info.png" '
            . 'alt="" title=""/>';
        $viewHelper = new Msd_View_Helper_GetIcon();
        $res = $viewHelper->getIcon('Info', '', 16);
        $this->assertEquals($expected, $res);
    }

    public function testGetIconInfoSize20()
    {
        $expected = '<img src="/css/otc/icons/20x20/Admin.png" '
            . 'alt="" title=""/>';
        $viewHelper = new Msd_View_Helper_GetIcon();
        $res = $viewHelper->getIcon('Admin', '', 20);
        $this->assertEquals($expected, $res);
    }

    /**
     * @expectedException Msd_Exception
     */
    public function testFailGetNonExistantIcon()
    {
        $viewHelper = new Msd_View_Helper_GetIcon();
        $viewHelper->getIcon('nonExistantIcon');
    }

    public function testGetIconWithoutSize()
    {
        $expected = '<img src="/css/otc/icons/save.png" '
            . 'alt="" title=""/>';
        $viewHelper = new Msd_View_Helper_GetIcon();
        $res = $viewHelper->getIcon('save');
        $this->assertEquals($expected, $res);
    }

    public function testGetIconAddsClass()
    {
        $expected = '<img src="/css/otc/icons/save.png" '
            . 'alt="" title="" class="testClass"/>';
        $viewHelper = new Msd_View_Helper_GetIcon();
        $res = $viewHelper->getIcon('save', '', null, 'testClass');
        $this->assertEquals($expected, $res);
    }
}

