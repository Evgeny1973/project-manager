<?php


namespace App\Model\Work\UseCase\Projects\Task\Progress;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('priority', ChoiceType::class, ['choices' =>
                [
                    0 => 0,
                    25 => 25,
                    50 => 50,
                    75 => 75,
                    100 => 100,
                ], 'attr' => ['onchange' => 'this.form.submit()']
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class ' => Command::class,
        ]);
    }
    
    public function getBlockPrefix(): string
    {
        return 'progress';
    }
}