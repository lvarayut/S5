<?php

namespace Enstb\Bundle\VisplatBundle\Administrator;


use Enstb\Bundle\VisplatBundle\Repository\UserRepository;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array('label' => 'Name'))
            ->add('lastName', 'text', array('label' => 'Last name'))
            ->add('email') //if no type is specified, SonataAdminBundle tries to guess it
            ->add('username')
            ->add('password')
            ->add('rolesCollection','entity',array(
                'class' => 'EnstbVisplatBundle:Role',
                'property'=>'name',
                'expanded' => true,
                'compound' => true,
                'multiple' => true,
                'by_reference' => false // the setter of rolesCollection will be called.
            ))
            ->add('doctorID', 'entity', array(
                'class' => 'EnstbVisplatBundle:User',
                'property' => 'name',
                'label' => 'Doctor\'s name',
                // Query only doctors to be shown in the choice field
                'query_builder' => function (UserRepository $er) {
                        return $er->createQueryBuilder('u')->orderBy('u.name', 'ASC')->where('u.doctorId is NULL');
                    },
                'empty_value' => 'No category',

            ));
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('lastName')
            ->add('roles')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('lastName')
            ->add('email')
            ->add('roles','sonata_type_model')
        ;
    }



}