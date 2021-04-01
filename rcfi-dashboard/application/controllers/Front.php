<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

    public function __construct(){
      parent::__construct();
    }

    public function index()
    {
      $this->load->view('front/index');
    }

    public function shop(){
      $this->load->view('front/shop');
    }

    public function shop2(){
      $this->load->view('front/shop2');
    }

    public function about(){
      $this->load->view('front/about-us');
    }

    public function contact(){
      $this->load->view('front/contact');
    }

    public function faq(){
      $this->load->view('front/faq');
    }

    public function login(){
      $this->load->view('front/login');
    }

    public function register(){
      $this->load->view('front/register');
    }

    public function inquire(){
      $this->load->view('front/inquire');
    }

    public function gallery(){
      $this->load->view('front/gallery');
    }

    public function testimonial(){
      $this->load->view('front/testimonial');
    }

}
