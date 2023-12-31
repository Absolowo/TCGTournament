<?php
namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Leader;


class ParticipanteType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        ->add('nombre', TextType::class)
        ->add('jid', TextType::class)
        ->add('score', TextType::class)
        ->add('leader', EntityType::class, array(
            'class' => Leader::class, 'choice_label' => 'nombre',))
        ->add('save', SubmitType::class, array('label' => 'Enviar'))
        ->add('saveAndAdd', SubmitType::class, ['label' => 'Save and Add']);
    }
}