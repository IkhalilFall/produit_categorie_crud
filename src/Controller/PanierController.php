<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\CartItem;
use App\Repository\CartItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/panier')]
class PanierController extends AbstractController
{
    #[Route('/', name: 'app_panier')]
    public function index(CartItemRepository $cartItemRepository): Response
    {
        $user = $this->getUser();
        $items = $cartItemRepository->findBy(['user' => $user]);

        return $this->render('panier/index.html.twig', [
            'items' => $items,
        ]);
    }

    #[Route('/ajouter/{id}', name: 'panier_ajouter')]
    public function ajouter(Produit $produit, EntityManagerInterface $em): RedirectResponse
    {
        $user = $this->getUser();
        $repo = $em->getRepository(CartItem::class);

        $item = $repo->findOneBy(['user' => $user, 'produit' => $produit]);

        if ($item) {
            $item->setQuantite($item->getQuantite() + 1);
        } else {
            $item = new CartItem();
            $item->setUser($user);
            $item->setProduit($produit);
            $item->setQuantite(1);
            $em->persist($item);
        }

        $em->flush();

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/supprimer/{id}', name: 'panier_supprimer')]
    public function supprimer(CartItem $item, EntityManagerInterface $em): RedirectResponse
    {
        $em->remove($item);
        $em->flush();

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/modifier/{id}', name: 'panier_modifier', methods: ['POST'])]
    public function modifier(Request $request, CartItem $item, EntityManagerInterface $em): RedirectResponse
    {
        $quantite = (int) $request->request->get('quantite');

        if ($quantite > 0) {
            $item->setQuantite($quantite);
            $em->flush();
        } else {
            $em->remove($item);
            $em->flush();
        }

        return $this->redirectToRoute('app_panier');
    }
}
