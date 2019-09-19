<?php

namespace App\Form;

use App\Entity\Historique;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('evenements', CKEditorType::class, [
                'config' => [
                    'unicolor' => '#e2e2e2',
                    'toolbar'  => 'full',
                    'require'  => true
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Historique::class,
        ]);
    }
}
