<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAddressController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/compte/adresses", name="account_address")
     */
    public function adresse(): Response
    {
        return $this->render('account/account_address.html.twig', []);
    }

    /**
     * @Route("/compte/ajouter-une-adresse", name="account_address_add")
     */
    public function add_address(Request $request, Cart $cart): Response
    {
        $address = new Address;
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());

            $this->em->persist($address);
            $this->em->flush();
            if ($cart->get()) {
                return $this->redirectToRoute('order');
            } else {

                return $this->redirectToRoute('account_address');
            }
        }

        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/compte/modifier-une-adresse{id<\d+>}", name="account_address_edit")
     */
    public function edit_address(Request $request, $id): Response
    {
        $address = $this->em->getRepository(Address::class)->findOneBy(['id' => $id]);

        if (!$address || $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_address');
        }

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->flush();

            return $this->redirectToRoute('account_address');
        }

        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/compte/supprimer-une-adresse{id<\d+>}", name="account_address_delete")
     */
    public function delete_address($id)
    {
        $address = $this->em->getRepository(Address::class)->findOneBy(['id' => $id]);

        if ($address && $address->getUser() == $this->getUser()) {

            $this->em->remove($address);
            $this->em->flush();
        }

        return $this->redirectToRoute('account_address');
    }
}
