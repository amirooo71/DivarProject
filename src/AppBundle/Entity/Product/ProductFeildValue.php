<?php

namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductFeildValue
 *
 * @ORM\Table(name="product_product_feild_value")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\ProductFeildValueRepository")
 */
class ProductFeildValue
{
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
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category\CategoryFeilds")
     */
    private $field;
    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="fields")
     */
    private $product;

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
     * Set value
     *
     * @param string $value
     *
     * @return ProductFeildValue
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set field
     *
     * @param \AppBundle\Entity\Category\CategoryFeilds $field
     *
     * @return ProductFeildValue
     */
    public function setField(\AppBundle\Entity\Category\CategoryFeilds $field = null)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get field
     *
     * @return \AppBundle\Entity\Category\CategoryFeilds
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set product
     *
     * @param \AppBundle\Entity\Product\Product $product
     *
     * @return ProductFeildValue
     */
    public function setProduct(\AppBundle\Entity\Product\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Product\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
