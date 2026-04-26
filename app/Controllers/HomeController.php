<?php

/**
 * Home Controller
 * Handle homepage and public pages
 */
class HomeController extends BaseController
{

    /**
     * Homepage - visible to all (guest & members)
     */
    public function index()
    {
        $user = Auth::check() ? Auth::user() : null;
        $this->view('home', ['user' => $user]);
    }

    /**
     * Shop page - view products
     */
    public function shop()
    {
        $user = Auth::check() ? Auth::user() : null;
        $this->view('shop', ['user' => $user]);
    }

    /**
     * Product detail page
     */
    public function product($id = null)
    {
        if (!$id) {
            $this->redirect('home/shop');
            return;
        }

        $user = Auth::check() ? Auth::user() : null;
        $this->view('product-detail', ['user' => $user, 'product_id' => $id]);
    }

    /**
     * Shopping cart page
     */
    public function cart()
    {
        $user = Auth::check() ? Auth::user() : null;
        $this->view('cart', ['user' => $user]);
    }

    /**
     * Checkout page - requires login
     */
    public function checkout()
    {
        if (!Auth::check()) {
            $this->redirect('auth');
            return;
        }

        $user = Auth::user();
        $this->view('checkout', ['user' => $user]);
    }

    /**
     * About page
     */
    public function about()
    {
        $user = Auth::check() ? Auth::user() : null;
        $this->view('about', ['user' => $user]);
    }

    /**
     * Contact page
     */
    public function contact()
    {
        $user = Auth::check() ? Auth::user() : null;
        $this->view('contact', ['user' => $user]);
    }
}
