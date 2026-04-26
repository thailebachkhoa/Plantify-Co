<?php

/**
 * Guest Controller
 * Handle public pages for guests and members
 */
class GuestController extends BaseController
{

    public function index()
    {
        // Home page - visible to both guests and members
        $user = Auth::check() ? Auth::user() : null;
        $this->view('home', ['user' => $user]);
    }

    public function shop()
    {
        // Shop page - view products (guests can browse)
        $user = Auth::check() ? Auth::user() : null;
        $this->view('shop', ['user' => $user]);
    }

    public function product($id = null)
    {
        // Product detail page
        if (!$id) {
            $this->redirect('home/shop');
            return;
        }

        $user = Auth::check() ? Auth::user() : null;
        $this->view('product-detail', ['user' => $user, 'product_id' => $id]);
    }

    public function cart()
    {
        // Shopping cart - can be viewed by guests, but checkout requires login
        $user = Auth::check() ? Auth::user() : null;
        $this->view('cart', ['user' => $user]);
    }

    public function checkout()
    {
        // Checkout page - requires login
        if (!Auth::check()) {
            $this->redirect('auth/register');
            return;
        }

        $user = Auth::user();
        $this->view('checkout', ['user' => $user]);
    }

    public function about()
    {
        // About page
        $user = Auth::check() ? Auth::user() : null;
        $this->view('about', ['user' => $user]);
    }

    public function contact()
    {
        // Contact page
        $user = Auth::check() ? Auth::user() : null;
        $this->view('contact', ['user' => $user]);
    }
}
