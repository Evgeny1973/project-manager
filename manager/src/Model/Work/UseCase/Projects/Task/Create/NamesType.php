<?php


namespace App\Model\Work\UseCase\Projects\Task\Create;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class NamesType extends AbstractType implements DataTransformerInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this);
    }
    
   public function getParent(): string
   {
       return TextareaType::class;
   }
    
    /**
     * @param NameRow[] $value
     * @return string
     */
    public function transform($value):string
    {
        $lines = [];
    
        return implode(PHP_EOL, array_map(static function (NameRow $row) {
            return $row->name;
        }, $lines));
    }

    public function reverseTransform($value)
    {
        return array_filter(array_map(static function($name) {
            if (empty($name)) {
                return null;
            }
            return new NameRow($name);
        }, preg_split('#[\r\n]+#', $value)));
    }
}