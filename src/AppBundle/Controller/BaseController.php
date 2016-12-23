<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of BaseController
 *
 * @author amirMIG
 */
class BaseController extends Controller {

    protected function getEm() {
        return $this->getDoctrine()->getManager();
    }
}
