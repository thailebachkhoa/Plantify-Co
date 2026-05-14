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
}