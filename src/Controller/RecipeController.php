<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

final class RecipeController extends AbstractController
{

    #[Route('/recipes', name: 'recipe.index')]
    public function index(Request $request, RecipeRepository $repository, EntityManagerInterface $entity): Response
    {

        dd($repository->findTotalDuration());
        //$recipes = $repository->findAll();

        $recipes = $repository->findWithDurationLowerThan(25);

        //$entity->persist($this->createRecipe());
        // $entity->flush();

        // $recipes = $entity->getRepository(Recipe::class)->findWithDurationLowerThan(25);

        return $this->render('recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
            'recipes' => $recipes
        ]);
    }

    #[Route('/recipes/{slug}-{id}', name: 'recipe.show', requirements: ['id' => '\d+', 'slug' => '[a-z0-9-]+'])]
    public function show(Request $request, string $slug, int $id, RecipeRepository $repository): Response
    {

        $recipe = $repository->find($id);

        if ($recipe->getSlug() !== $slug) {
            return $this->redirectToRoute('recipe.show', ['slug' => $recipe->getSlug(), 'id' => $recipe->getId()]);
        }

        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    private function createRecipe()
    {
        $slugger = new AsciiSlugger('en');
        $recipe = new Recipe();
        $recipe->setTitle('26 Easy Slow Cooker Chili Recipes for Cozy Winter Nights Ahead')
            ->setSlug($slugger->slug("26 Easy Slow Cooker Chili Recipes for Cozy Winter Nights Ahead")->lower())
            ->setContent("26 Easy Slow Cooker Chili Recipes for Cozy Winter Nights Ahead 26 Easy Slow Cooker Chili Recipes 
        for Cozy Winter Nights Ahead26 Easy Slow Cooker Chili Recipes for Cozy Winter Nights Ahead")
            ->setDuration(60)
            ->setCreatedAt(new DateTimeImmutable())
            ->setUpdatedAt(new DateTimeImmutable());

        return $recipe;
    }
}
