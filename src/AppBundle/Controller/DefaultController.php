<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product\Product;
use AppBundle\Entity\Product\ProductFeildValue;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends BaseController {

    /**
     * @Route("/", name="homePage")
     * @Template
     */
    public function indexAction() {

        $cities = $this->getEm()->getRepository('AppBundle:Category\City')->findAll();

        return ["cities" => $cities];
    }

    /**
     * @Route("/list/{id}",name="listPage")
     * @Template
     */
    public function listAction(Request $request, $id) {

        $dql = "SELECT p FROM AppBundle:Product\Product p"
                . " LEFT JOIN p.images i WHERE p.city = $id";
        $query = $this->getEm()->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $products = $paginator->paginate(
                $query, /* query NOT result */ $request->query->getInt('page', 1)/* page number */, 10/* limit per page */
        );

        $categories = $this->getEm()->getRepository('AppBundle:Category\Category')->findAll();

        return ["products" => $products, "categories" => $categories, "cityId" => $id];
    }

    /**
     * @Route("/productDetail/{id}",name="productDetailPage")
     * @ParamConverter("detail", class="AppBundle:Product\Product")
     * @Template
     */
    public function productDetailAction($detail) {


        return ["detail" => $detail];
    }

    /**
     * @Route("/manage/{id}",name="managePage")
     * @ParamConverter("product", class="AppBundle:Product\Product")
     * @Template
     */
    public function manageAction($product) {



        return ["product" => $product];
    }

    /**
     * @Route("/edit/{id}",name="editPage")
     * @ParamConverter("product", class="AppBundle:Product\Product")
     * @Template
     */
    public function editAction(Request $request, Product $product) {

        /**
         * load ProductFieldValue For set Data.
         */
        $productFieldValue = $this->getEm()->getRepository('AppBundle:Product\ProductFeildValue')->findByProduct($product);
        /**
         * load ChildCategory for Category Fields.
         */
        $id = $product->getCategory()->getId();
        $child = $this->getDoctrine()->getRepository('AppBundle:Category\childCategory')->find($id);

        /**
         * Edit Products Form.
         */
        $form = $this->createFormBuilder();
        $form->add("base", ProductType::class);
        if ($child !== NULL) {
            $this->generateExtraFields($form, $child->getCategoryFeilds());
        }
        $form->add("save", SubmitType::class);
        $form = $form->getForm();
        $form->get("base")->setData($product);
        $this->setDataExtraFields($productFieldValue, $form);

        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $data = $form->getData();
                $product = $data['base'];
                $this->getEm()->persist($product);
                if ($child !== NULL) {
                    $this->deleteExtraFields($product);
                    $this->saveExtraFields($child, $data, $product);
                }
                $product->setCategory($product->getCategory());
                $this->getEm()->flush();
                return $this->redirectToRoute("managePage", ["id" => $product->getId()]);
            } catch (Exception $ex) {
                
            }
        }
        return ["form" => $form->createView()];
    }

    private function setDataExtraFields($productFieldValue, $form) {
        foreach ($productFieldValue as $fields) {
            $form->get($fields->getField()->getName())->setData($fields->getValue());
        }
    }

    private function generateExtraFields($form, $childCategory) {
        foreach ($childCategory as $fields) {
            $form->add($fields->getName());
        }
    }

    private function deleteExtraFields($product) {
        $fieldValues = $this->getEm()->getRepository('AppBundle:Product\ProductFeildValue')->findByProduct($product);
        foreach ($fieldValues as $fieldValue) {
            $this->getEm()->remove($fieldValue);
        }
    }

    private function saveExtraFields($child, $data, $product) {
        foreach ($child->getCategoryFeilds() as $fields) {
            $fieldValue = new ProductFeildValue();
            $fieldValue->setField($fields);
            $fieldValue->setProduct($product);
            $fieldValue->setValue($data[$fields->getName()]);
            $this->getEm()->persist($fieldValue);
        }
    }

    /**
     * @Route("/delete/{id}", name="deletePage")
     * @ParamConverter("product", class="AppBundle:Product\Product")
     * @Template
     */
    public function deleteAction($product) {

        $images = $this->getEm()->getRepository('AppBundle:Image\Image')->findByProduct($product);
        $fields = $this->getEm()->getRepository('AppBundle:Product\ProductFeildValue')->findByProduct($product);


        foreach ($images as $image) {
            $this->getEm()->remove($image);
        }
        foreach ($fields as $field) {
            $this->getEm()->remove($field);
        }
        $this->getEm()->remove($product);
        $this->getEm()->flush();
//        return $this->redirectToRoute('homePage');
        return [];
    }

}
