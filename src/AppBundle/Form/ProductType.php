<?php

namespace AppBundle\Form;

use AppBundle\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProductType
 * @package AppBundle\Form
 */
class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options = []): void
    {
        $builder->add('name', TextType::class)->add('reference', TextType::class)->add('price', MoneyType::class);
    }
    
    /**
     * @param OptionsResolver $resolver
     * @throws AccessException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'         => Product::class,
            'csrf_protection'    => true,
            'validation_groups'  => true,
            'translation_domain' => false
        ]);
    }
}
