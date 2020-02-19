<?php


namespace App\Model\Work\UseCase\Projects\Task\Type;


use App\Model\Work\Entity\Projects\Task\Type as TaskType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, ['choices' =>
                [
                    'None' => TaskType::NONE,
                    'Error' => TaskType::ERROR,
                    'Feature' => TaskType::FEATURE,
                ], 'attr' => ['onchange' => 'this.form.submit()']
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
        ]);
    }
    
    public function getBlockPrefix()
    {
        return 'type';
    }
}