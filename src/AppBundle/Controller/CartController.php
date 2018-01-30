<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\Order;
use AppBundle\Entity\Product;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CartController
 * @package AppBundle\Controller
 */
class CartController extends Controller
{
    /**
     * @var array $stripeCredentials
     */
    protected $stripeCredentials = [];
    
    /**
     * CartController constructor.
     * @param string $stripeKey
     * @param string $stripePubKey
     */
    public function __construct(string $stripeKey, string $stripePubKey)
    {
        $this->stripeCredentials = [
            'secret_key'      => $stripeKey,
            'publishable_key' => $stripePubKey
        ];
        Stripe::setApiKey($stripeKey);
    }
    
    /**
     * @param Request $request
     * @return Response
     * @throws \LogicException
     * @Route("/cart", name="cart_index")
     */
    public function indexAction(Request $request): Response
    {
        $session = $request->getSession();
        return $this->render(':Cart:index.html.twig', [
            'userCart'     => $session->has('cart') ? $session->get('cart') : null,
            'stripePubKey' => $this->stripeCredentials['publishable_key'],
            'cartAmount'   => $this->getTotalAmount()
        ]);
    }
    
    /**
     * Get Cart Amount Total
     * @return int
     */
    protected function getTotalAmount(): int
    {
        $cartAmount = 0;
        $cart       = $this->get('session')->get('cart');
        if ($cart) {
            foreach ($cart->getProducts() as $item) {
                $product    = $item['product'];
                $quantity   = $item['quantity'];
                $cartAmount += ($product->getPrice() * $quantity) * 100;
            }
        }
        return $cartAmount;
    }
    
    /**
     * @param Request $request
     * @param int     $productId
     * @param int     $quantity
     * @return RedirectResponse
     * @throws \LogicException
     * @Route("/cart/add/{productId}", name="cart_add", requirements={"productId"="\d+"})
     */
    public function addAction(Request $request, $productId, $quantity = 1): RedirectResponse
    {
        $em      = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($productId);
        $session = $request->getSession();
        if ($session->has('cart')) {
            $userCart = $session->get('cart');
            $userCart->addProduct($product, $quantity);
            $session->set('cart', $userCart);
        } else {
            $cart = new Cart();
            $cart->setUser($this->getUser());
            $cart->addProduct($product, $quantity);
            $session->set('cart', $cart);
        }
        $this->addFlash('success', 'Produit ajouté au panier avec succès');
        return $this->redirectToRoute('cart_index');
    }
    
    /**
     * Destroy Cart
     * @param Request $request
     * @return RedirectResponse
     * @throws \LogicException
     * @Route("/cart/destroy", name="cart_destroy")
     */
    public function destroyAction(Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $session->remove('cart');
        $this->addFlash('success', 'Le panier a été vidé avec succès');
        return $this->redirectToRoute('cart_index');
    }
    
    /**
     * Display Stripe payment form
     * @return Response
     * @throws \LogicException
     * @Route("/cart/checkout/stripe", name="cart_checkout_stripe")
     */
    public function checkoutStripeAction(): Response
    {
        return $this->render(':Cart:checkoutStripe.html.twig', [
            'pubKey' => $this->stripeCredentials['publishable_key'],
            'amount' => $this->getTotalAmount() / 100
        ]);
    }
    
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \LogicException
     * @Route("/cart/process/stripe", name="cart_process_payment_stripe")
     */
    public function processPaymentStripeAction(Request $request): RedirectResponse
    {
        if ($request->isMethod('POST')) {
            $session  = $request->getSession();
            $token    = $request->get('stripeToken');
            $user     = $this->getUser();
            $cart     = $session->get('cart');
            $customer = Customer::create([
                'source'      => $token,
                'description' => $user->getFirstName() . ' ' . $user->getLastName(),
                'email'       => $user->getEmail()
            ]);
            $charge   = Charge::create([
                'amount'   => $this->getTotalAmount(),
                'currency' => 'eur',
                'customer' => $customer
            ]);
            if ($charge->paid && $charge->status === 'succeeded') {
                $this->addFlash('success', 'Paiement OK');
                $session->remove('cart');
                $em    = $this->getDoctrine()->getManager();
                $order = new Order();
                $order->setAmount($charge->amount / 100)
                      ->setGateway('stripe')
                      ->setInvoiceNumber('invoice-54122365')
                      ->setPayerId($customer->id)
                      ->setPaymentId($charge->id)
                      ->setStatus($charge->status)
                      ->setUser($this->getUser())
                      ->setProducts($cart->getProducts());
                $em->persist($order);
                $em->flush();
                return $this->redirectToRoute('cart_index');
            }
            $this->addFlash('error',
                'Error Code: ' . $charge->failure_code . '<br>Error Message: ' . $charge->failure_message);
            return $this->redirectToRoute('cart_checkout_stripe');
            
        }
        return $this->redirectToRoute('cart_index');
    }
}
