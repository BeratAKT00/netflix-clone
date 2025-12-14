<?php

namespace App\Controller\Admin;

use App\Entity\Movie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MovieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Movie::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // On cache l'ID car on n'a pas besoin de le voir ou le modifier
            IdField::new('id')->hideOnForm(),

            // Le titre du film
            TextField::new('titre'),

            // Une case à cocher pour dire si c'est une série
            BooleanField::new('isSeries', 'Est une série ?'),

            // Pour l'image, on utilise un champ Texte pour l'instant (car ce sont des URLs)
            TextField::new('coverImage', 'URL de l\'image'),

            // La date de sortie
            DateField::new('releaseDate', 'Date de sortie'),

            // La relation avec les catégories (Menu déroulant automatique)
            AssociationField::new('categories'),

            // Un éditeur de texte riche pour la description (gras, italique...)
            TextEditorField::new('description'),
        ];
    }
}
