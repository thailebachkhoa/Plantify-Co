<?php

class ContactController extends BaseController
{
    public function index()
    {
        $user = Auth::check() ? Auth::user() : null;

        $this->view('pages/contact', [
            'user' => $user
        ]);
    }
}
