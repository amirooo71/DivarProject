<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends BaseController {

    /**
     * @Route("/category",name="categoryPage")
     * @Template
     */
    public function categoryAction() {

        $categories = $this->getEm()->getRepository('AppBundle:Category\Category')->findAll();
        return ["categories" => $categories];
    }

    /**
     * @Route("/childCategory/{id}",name="childCategoryPage")
     * @ParamConverter("category",class="AppBundle:Category\Category")
     * @Template
     */
    public function childCategoryAction(Category $category) {
        $childCategories = $this->getEm()->getRepository('AppBundle:Category\childCategory')->findByCategory($category);
        return ["childCategories" => $childCategories, "category" => $category];
    }

    /**
     * @Route("/listByCategory/{id}/{categoryTitle}/{cityId}", name="listByCategoryPage")
     * @Template
     */
    public function getListByCategoryNameAction($id, $categoryTitle, $cityId, Request $request) {


        $dql = "SELECT p FROM AppBundle:Product\Product p"
                . " LEFT JOIN p.images i WHERE p.category = $id AND p.city = $cityId";
        $query = $this->getEm()->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $products = $paginator->paginate(
                $query, /* query NOT result */ $request->query->getInt('page', 1)/* page number */, 10/* limit per page */
        );

        $childCategories = $this->getEm()->getRepository('AppBundle:Category\ChildCategory')->findByCategoryId($id);

        return ["products" => $products, "categoryTitle" => $categoryTitle, "childCategories" => $childCategories, "cityId" => $cityId];
    }

    /**
     * @Route("/listBySubCategory/{subCat_id}/{cityId}/{catTitle}",name="listBySubCategory")
     * @Template
     */
    public function listBySubCategoryAction($subCat_id, $cityId, $catTitle, Request $request) {

        $dql = "SELECT p FROM AppBundle:Product\Product p"
                . " LEFT JOIN p.images i WHERE p.childCategory = $subCat_id AND p.city = $cityId";
        $query = $this->getEm()->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $products = $paginator->paginate(
                $query, /* query NOT result */ $request->query->getInt('page', 1)/* page number */, 10/* limit per page */
        );

        return ["products" => $products, "catTitle" => $catTitle, "cityId" => $cityId];
    }

}
