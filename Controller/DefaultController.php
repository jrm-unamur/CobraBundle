<?php

namespace JrmUnamur\CobraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        /*$notify = $this->get('jrmunamur.notify');
        $notify->add("test", array("type" => "instant", "message" => "Yummy"));
        if($notify->has("test")) return array("notifications" => $notify->get("test"));
        return array('name' => $name);*/
    }
}
