<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
		  ->add('materiel_id',     HiddenType::class)
		  ->add('titre',     TextType::class)
		  ->add('contenu',     TextareaType::class)			  
		  ->add('save',      SubmitType::class)
		;
	}
	
	public function configureOptions(OptionsResolver $resolver){
		$resolver->setDefaults(array(
			'data_class'=>'App\Entity\Comment'
		));
	}
}