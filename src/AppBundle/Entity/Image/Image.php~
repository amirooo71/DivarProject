<?php

namespace AppBundle\Entity\Image;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="image_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Image\ImageRepository")
 */
class Image {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="ext", type="string", length=255)
     */
    private $ext;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product\Product", inversedBy="images")
     */
    private $product;

    public function setExtFromName($fileName) {
        $arr = explode(".", $fileName);
        $this->setExt(end($arr));
    }

    public function getImagePathName() {
        $path = "uploader/images/" . $this->getId() . "." . $this->getExt();
        return $path;
    }

    public function getImagePathNameSmallSize() {
        $path = "uploader/images/small/" . $this->getId() . "." . $this->getExt();
        return $path;
    }

    public function getImagePathNameMediumSize() {
        $path = "uploader/images/medium/" . $this->getId() . "." . $this->getExt();
        return $path;
    }

    public function getImagePathNameLargeSize() {
        $path = "uploader/images/large/" . $this->getId() . "." . $this->getExt();
        return $path;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Image
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set ext
     *
     * @param string $ext
     *
     * @return Image
     */
    public function setExt($ext) {
        $this->ext = $ext;

        return $this;
    }

    /**
     * Get ext
     *
     * @return string
     */
    public function getExt() {
        return $this->ext;
    }

    /**
     * Set product
     *
     * @param \AppBUndle\Entity\Product\Product $product
     *
     * @return Image
     */
    public function setProduct(\AppBUndle\Entity\Product\Product $product = null) {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBUndle\Entity\Product\Product
     */
    public function getProduct() {
        return $this->product;
    }

}
