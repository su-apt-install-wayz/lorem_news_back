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
    #[Route('/api/categories', name: 'api_category', methods: ['get'])]
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

    #[Route('/api/category/{id}', name: 'api_category_id', methods: ['get'])]
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
}
