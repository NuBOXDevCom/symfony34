<?php

namespace AppBundle\Form;

use AppBundle\Entity\Domain;
use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use function in_array;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DomainType
 * @package AppBundle\Form
 */
class DomainType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options = []): void
    {
        $builder->add('name', TextType::class);
        if (in_array('ROLE_SUPER_ADMIN', $options['role'], true) || in_array('ROLE_ADMIN', $options['role'], true)) {
            $builder->add('user', EntityType::class, [
                'class'         => User::class,
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.username', 'ASC');
                },
                'choice_label'  => 'username',
                'choice_value'  => 'id',
                'required'      => false,
                'placeholder'   => false
            ])->add('enabled', CheckboxType::class, ['label' => 'Activé', 'required' => false]);
        }
    }
    
    /**
     * @param OptionsResolver $resolver
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'         => Domain::class,
            'csrf_protection'    => true,
            'validation_groups'  => true,
            'translation_domain' => false,
            'role'               => ['ROLE_USER']
        ]);
    }
}
