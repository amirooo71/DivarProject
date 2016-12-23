<?php

namespace AppBundle\Entity\Category;

use Doctrine\ORM\Mapping as ORM;

/**
 * childCategory
 *
 * @ORM\Table(name="categorychild_category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Category\childCategoryRepository")
 */
class childCategory {

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
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category\Category", inversedBy="child")
     */
    private $category;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Product\Product", mappedBy="childCategory")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="CategoryFeilds", mappedBy="childCategory")
     */
    private $categoryFeilds;

   
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categoryFeilds = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return childCategory
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
     * Set category
     *
     * @param \AppBundle\Entity\Category\Category $category
     *
     * @return childCategory
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
     * Add product
     *
     * @param \AppBundle\Entity\Product\Product $product
     *
     * @return childCategory
     */
    public function addProduct(\AppBundle\Entity\Product\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AppBundle\Entity\Product\Product $product
     */
    public function removeProduct(\AppBundle\Entity\Product\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Add categoryFeild
     *
     * @param \AppBundle\Entity\Category\CategoryFeilds $categoryFeild
     *
     * @return childCategory
     */
    public function addCategoryFeild(\AppBundle\Entity\Category\CategoryFeilds $categoryFeild)
    {
        $this->categoryFeilds[] = $categoryFeild;

        return $this;
    }

    /**
     * Remove categoryFeild
     *
     * @param \AppBundle\Entity\Category\CategoryFeilds $categoryFeild
     */
    public function removeCategoryFeild(\AppBundle\Entity\Category\CategoryFeilds $categoryFeild)
    {
        $this->categoryFeilds->removeElement($categoryFeild);
    }

    /**
     * Get categoryFeilds
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategoryFeilds()
    {
        return $this->categoryFeilds;
    }
}
