<?php


namespace App\ReadModel\Work\Projects\Project\Filter;


use App\Model\Work\Entity\Projects\Project\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Name',
                'onchange' => 'this.form.submit()',]])
            ->add('status', ChoiceType::class, ['choices' => [
                'Active' => Status::ACTIVE,
                'Archived' => Status::ARCHIVED,],
                'required' => false,
                'placeholder' => 'All Statuses', 'attr' =>
                    ['onchange' => 'this.form.submit()']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Filter::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}