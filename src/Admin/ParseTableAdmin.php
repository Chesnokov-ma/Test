<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

final class ParseTableAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('title', TextType::class);
        $form->add('link', TextType::class);
        $form->add('validuntil', DateType::class);
        $form->add('countdown', IntegerType::class);
        $form->add('img', TextType::class);

    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('title');
        $datagrid->add('link');
        $datagrid->add('validuntil');
        $datagrid->add('countdown');
        $datagrid->add('img');
        
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('title');
        $list->addIdentifier('link');
        $list->addIdentifier('validuntil');
        $list->addIdentifier('countdown');
        $list->addIdentifier('img');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('title');
        $show->add('link');
        $show->add('validuntil');
        $show->add('countdown');
        $show->add('img');
    }
}