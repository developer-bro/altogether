<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Repository\JobsRepository;
use App\Entity\Jobs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\Security;

class TaskType extends AbstractType
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->security->getUser();
        $builder
            ->add('name', ChoiceType::class, [
                'choices'  => [
                    'Apply' => 'Apply',
                    'Thank You Letter' => 'Thank You Letter',
                    'Follow-Up' => 'Follow-Up',
                    'Interview Prep' =>'Interview Prep'
                ],
            ])
            ->add('fromName',  EntityType::class, [
                'class' => Jobs::class,
                'query_builder' => function (JobsRepository $jobs) use ($user) {
                     return $jobs->createQueryBuilder('j')
                     ->select('j.comapnyName')
                     ->where('j.User = :user')
                     ->orderBy('j.id', 'DESC')
                     ->setParameter('user', $user);
                },
                'label' => 'Comapany Name',
                ])
            ->add('toName',  TextareaType::class, ['label' => 'Job Title'])
            ->add('dueDate', DateType::class, [
                'widget' => 'choice',
                // this is actually the default format for single_text
                'data' => new \DateTime('now'),
             
            ])
            ->add('notes')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class
        ]);
    }
}
