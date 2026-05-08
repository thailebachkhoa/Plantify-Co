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
        $this->view('pages/home', ['user' => $user]);
    }

    /**
     * Shop page - view products
     */
    public function shop()
    {
        $user = Auth::check() ? Auth::user() : null;
        $this->view('pages/shop', ['user' => $user]);
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
        $this->view('pages/product-detail', ['user' => $user, 'product_id' => $id]);
    }

    /**
     * Shopping cart page
     */
    public function cart()
    {
        $user = Auth::check() ? Auth::user() : null;
        $this->view('pages/cart', ['user' => $user]);
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
        $this->view('pages/checkout', ['user' => $user]);
    }

    /**
     * About page
     */
    public function about()
    {
        $user = Auth::check() ? Auth::user() : null;
        $this->view('pages/about', ['user' => $user]);
    }

    /**
     * Contact page
     */
    public function contact()
    {
        $user = Auth::check() ? Auth::user() : null;
        $this->view('pages/contact', ['user' => $user]);
    }
}
