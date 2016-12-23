<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ProductType extends AbstractType {

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options) {
        $builder
                ->add("city")
                ->add("title", TextType::class, ['attr' => ['placeholder' => 'عنوان اگهی حداقل باید 10 خط باشد.']])
                ->add("email", TextType::class, ['attr' => ['placeholder' => 'your@gmail.com']])
                ->add("tell", TextType::class, ['attr' => ['placeholder' => '0912345689']])
                ->add("description")
        ;
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver) {
        $resolver->setDefaults([
            "data_class" => "AppBundle\Entity\Product\Product"
        ]);
    }

}
