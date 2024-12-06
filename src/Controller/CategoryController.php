<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;

class CategoryController extends AbstractController
{
    #[Route('/api/categories', name: 'api_categories_all', methods: ['get'])]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $categories = $doctrine->getRepository(Category::class)->findAll();
        $data = [];

        foreach ($categories as $category) {
            $data[] = [
                'id' => $category->getId(),
                'name' => $category->getName()
            ];
        }

        return $this->json($data);
    }

    #[Route('/api/categories/{id}', name: 'api_category_id', methods: ['get'])]
    public function show(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $category = $doctrine->getRepository(Category::class)->find($id);

        if (!$category) {
            return $this->json('No products found for id ' . $id, 404);
        }

        $data = [
            'id' => $category->getId(),
            'name' => $category->getName()
        ];

        return $this->json($data);
    }

    #[Route('/api/categories', name: 'api_categories_create', methods: ['post'])]
    public function create(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();

        $category = new Category();
        $category->setName($request->request->get('name'));

        $entityManager->persist($category);
        $entityManager->flush();

        $data = [
            'id' => $category->getId(),
            'name' => $category->getName()
        ];

        return $this->json($data);
    }

    #[Route('/api/categories/{id}', name: 'api_categories_update', methods: ['put', 'patch'])]
    public function update(ManagerRegistry $doctrine, Request $request, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $category = $doctrine->getRepository(Category::class)->find($id);

        if (!$category) {
            return $this->json('No products found for id ' . $id, 404);
        }

        $category->setName($request->request->get('name'));
        $entityManager->flush();

        $data = [
            'id' => $category->getId(),
            'name' => $category->getName()
        ];

        return $this->json($data);
    }

    #[Route('/api/categories/{id}', name: 'api_categories_delete', methods: ['delete'])]
    public function delete(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $category = $doctrine->getRepository(Category::class)->find($id);

        if (!$category) {
            return $this->json('No products found for id ' . $id, 404);
        }

        $entityManager->remove($category);
        $entityManager->flush();

        return $this->json('Deleted category with id ' . $id);
    }
}
