<?php

namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product_product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\ProductRepository")
 */
class Product {

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
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="tell", type="integer")
     */
    private $tell;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category\City",inversedBy="products")
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category\Category",inversedBy="products")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category\childCategory",inversedBy="products")
     */
    private $childCategory;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Image\Image", mappedBy="product")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="ProductFeildValue", mappedBy="product")
     */
    private $fields;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fields = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Product
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set tell
     *
     * @param integer $tell
     *
     * @return Product
     */
    public function setTell($tell)
    {
        $this->tell = $tell;

        return $this;
    }

    /**
     * Get tell
     *
     * @return integer
     */
    public function getTell()
    {
        return $this->tell;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set city
     *
     * @param \AppBundle\Entity\Category\City $city
     *
     * @return Product
     */
    public function setCity(\AppBundle\Entity\Category\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \AppBundle\Entity\Category\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category\Category $category
     *
     * @return Product
     */
    public function setCategory(\AppBundle\Entity\Category\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set childCategory
     *
     * @param \AppBundle\Entity\Category\childCategory $childCategory
     *
     * @return Product
     */
    public function setChildCategory(\AppBundle\Entity\Category\childCategory $childCategory = null)
    {
        $this->childCategory = $childCategory;

        return $this;
    }

    /**
     * Get childCategory
     *
     * @return \AppBundle\Entity\Category\childCategory
     */
    public function getChildCategory()
    {
        return $this->childCategory;
    }

    /**
     * Add image
     *
     * @param \AppBundle\Entity\Image\Image $image
     *
     * @return Product
     */
    public function addImage(\AppBundle\Entity\Image\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \AppBundle\Entity\Image\Image $image
     */
    public function removeImage(\AppBundle\Entity\Image\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add field
     *
     * @param \AppBundle\Entity\Product\ProductFeildValue $field
     *
     * @return Product
     */
    public function addField(\AppBundle\Entity\Product\ProductFeildValue $field)
    {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * Remove field
     *
     * @param \AppBundle\Entity\Product\ProductFeildValue $field
     */
    public function removeField(\AppBundle\Entity\Product\ProductFeildValue $field)
    {
        $this->fields->removeElement($field);
    }

    /**
     * Get fields
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFields()
    {
        return $this->fields;
    }
}
