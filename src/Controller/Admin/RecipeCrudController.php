<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;


class RecipeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recipe::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('recettes')
            ->setEntityLabelInSingular('recette')

            ->setPageTitle("index", "SymRecipe - Administration des recettes")

            ->setPaginatorPageSize(10);
    }


    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('name'),
            NumberField::new('price'),
            NumberField::new('time'),
            NumberField::new('nbPeople'),
            NumberField::new('difficulty'),
            BooleanField::new('isFavorite')
            ->hideOnIndex(),
            BooleanField::new('isPublic')
            ->hideOnIndex(),
            TextareaField::new('description')
            ->hideOnIndex(),
            DateTimeField::new('createdAt')
                ->hideOnForm()
        ];
    }
}
