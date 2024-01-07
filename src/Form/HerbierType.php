<?php

namespace App\Form;

use App\Entity\Herbier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Exception\TransformationFailedException;

class HerbierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder 
            ->add('Date', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('Lieu', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])

            ->add('Releve', TextType::class, [
                'attr' => [
                    'placeholder' => '1/2/3/4/5/6/7/8/9',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ]);

        $builder->get('Releve')
            ->addModelTransformer(new CallbackTransformer(
                function ($ReleveAsArray) {
                    // transform the array to a string
                    return implode('/', $ReleveAsArray);
                },
                function ($ReleveAsString) {
                    // transform the string back to an array
                    $values = array_map('intval', explode('/', $ReleveAsString));
                    if (count($values) !== 9) {
                        throw new TransformationFailedException('Releve must contain exactly 9 digits');
                    }
                    foreach ($values as $val) {
                        if (!is_int($val)) {
                            throw new TransformationFailedException('Releve should contain only digits');
                        }
                    }
                    return $values;
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Herbier::class,
        ]);
    }
}
?>