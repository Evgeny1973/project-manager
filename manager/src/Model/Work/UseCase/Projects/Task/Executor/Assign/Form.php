<?php


namespace App\Model\Work\UseCase\Projects\Task\Executor\Assign;


use App\ReadModel\Work\Members\Member\MemberFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    /**
     * @var MemberFetcher
     */
    private $members;
    
    public function __construct(MemberFetcher $members)
    {
        $this->members = $members;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $members = [];
        foreach ($this->members->activeDepartmentListForProject($options['project_id']) as $item) {
            $members[$item['department'] . ' - ' . $item['name']] = $item['id'];
        }
        
        $builder
            ->add('members', ChoiceType::class, [
                'choices' => $members,
                'expanded' => true,
                'multiple' => true,
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
        ]);
        $resolver->setRequired(['project_id']);
    }
    
}