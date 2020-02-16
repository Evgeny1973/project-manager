<?php


namespace App\Model\Work\UseCase\Projects\Task\Status;


use App\Model\Work\Entity\Projects\Task\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', ChoiceType::class, ['choices' =>
                [
                    'New' => Status::NEW,
                    'Working' => Status::WORKING,
                    'Need help' => Status::HELP,
                    'Checking' => Status::CHECKING,
                    'Rejecting' => Status::REJECTING,
                    'Done' => Status::DONE,
                ], 'attr' => ['onchange' => 'this.form.submit()']
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
        ]);
    }
}