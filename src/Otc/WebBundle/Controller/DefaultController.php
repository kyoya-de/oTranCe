<?php

namespace Otc\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OtcWebBundle:Default:index.html.twig');
    }
}
