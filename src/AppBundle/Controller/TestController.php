<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eventviva\ImageResize;

/**
 * Description of TestController
 *
 * @author amirMIG
 */
class TestController extends Controller {

    /**
     * @Route("/test",name="testPage")
     * @Template
     */
    public function testAction() {

        $i = "uploader/images/16.png";
        $im = new ImageResize($i);
        $im->scale(50);
        $i2 = "uploader/images/mama.png";
        $im->save($i2);


        return [];
    }

}
