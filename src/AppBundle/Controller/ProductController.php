<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category\childCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Eventviva\ImageResize;

class ProductController extends BaseController {

    /**
     * @Route("/new/{id}/{key}", name="newPage")
     * @ParamConverter("childCategory",class="AppBundle:Category\childCategory")
     * @Template
     */
    public function newAction(Request $request, childCategory $childCategory, $key = null) {
        
        /**
         * generate urlPage
         */
        if ($key === null) {
            $key = md5(uniqid());
            return $this->redirectToRoute("newPage", ["id" => $childCategory->getId(), "key" => $key]);
        }

        $categoryTitle = $childCategory->getCategory()->getTitle();
        $categoryId = $childCategory->getCategory()->getId();

        $form = $this->createFormBuilder();
        $form->add("base", \AppBundle\Form\ProductType::class);

        /**
         * generate extra fields
         */
        $this->generateExtraFields($form, $childCategory);

        $form->add("save", SubmitType::class);
        $form = $form->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $data = $form->getData();
                $product = $data['base'];
                $this->getEm()->persist($product);
                /**
                 * save extra fields
                 */
                $this->saveExtraFields($childCategory, $data, $product);

                $files = $request->getSession()->get("files_$key", []);
                /**
                 * save product image
                 */
                $this->saveProductImage($files, $product);
                $product->setCategory($childCategory->getCategory());
                $product->setChildCategory($childCategory);
                $this->getEm()->flush();
                return $this->redirectToRoute("managePage", ["id" => $product->getId()]);
            } catch (Exception $ex) {
                
            }
        }
        return ["form" => $form->createView(), "childCategory" => $childCategory, "categoryTitle" => $categoryTitle, "categoryId" => $categoryId, "key" => $key];
    }

    private function generateExtraFields($form, $childCategory) {
        foreach ($childCategory->getCategoryFeilds() as $fields) {
            $form->add($fields->getName());
        }
    }

    private function saveExtraFields($childCategory, $data, $product) {
        foreach ($childCategory->getCategoryFeilds() as $fields) {
            $fieldValue = new \AppBundle\Entity\Product\ProductFeildValue();
            $fieldValue->setProduct($product);
            $fieldValue->setField($fields);
            $fieldValue->setValue($data[$fields->getName()]);
            $this->getEm()->persist($fieldValue);
        }
    }

    private function saveProductImage($files, $product) {
        if (count($files) > 0) {
            foreach ($files as $f) {
                if ($f['success']) {
                    $image = new \AppBundle\Entity\Image\Image();
                    $image->setProduct($product);
                    $product->addImage($image);
                    $image->setExtFromName($f['uploadName']);
                    $image->setTitle($product->getTitle());
                    $this->getEm()->persist($image);
                    $this->getEm()->flush();
                    $img = "../files/$f[uuid]/$f[uploadName]";
                    $this->imageResizer($img, 260, 195, $image->getImagePathNameMediumSize());
                    $this->imageResizer($img, 750, 420, $image->getImagePathNameLargeSize());
                    rename("../files/$f[uuid]/$f[uploadName]", $image->getImagePathName());
                }
            }
        }
    }

    private function imageResizer($img, $width, $height, $path) {
        $resizer = new ImageResize($img);
        $resizer->resize($width, $height);
        $resizer->save($path);
    }

    /**
     * @Route("/upload-handler/{key}",name="upload-handler")
     * @Method({"POST","DELETE"})
     */
    public function uploadAction(Request $request, $key) {


        $uploader = new \AppBundle\Upload\Handler();

// Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $uploader->allowedExtensions = array(); // all files types allowed by default
// Specify max file size in bytes.
        $uploader->sizeLimit = null;

// Specify the input name set in the javascript.
        $uploader->inputName = "qqfile"; // matches Fine Uploader's default inputName value by default
// If you want to use the chunking/resume feature, specify the folder to temporarily save parts.
        $uploader->chunksFolder = "chunks";

        $method = $_SERVER["REQUEST_METHOD"];
        if ($method == "POST") {
            header("Content-Type: text/plain");

            // Assumes you have a chunking.success.endpoint set to point here with a query parameter of "done".
            // For example: /myserver/handlers/endpoint.php?done
            if (isset($_GET["done"])) {
                $result = $uploader->combineChunks("files");
            }
            // Handles upload requests
            else {
                // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
                $result = $uploader->handleUpload("../files");

                // To return a name used for uploaded file you can use the following line.
                $result["uploadName"] = $uploader->getUploadName();
            }

            $session = $request->getSession();
            $files = $session->get("files_$key", []);
            $files[] = $result;
            $session->set("files_$key", $files);


            return new \Symfony\Component\HttpFoundation\JsonResponse($result);
        }
// for delete file requests
        else if ($method == "DELETE") {
            $result = $uploader->handleDelete("files");
            return new \Symfony\Component\HttpFoundation\JsonResponse($result);
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
        }
    }

}
