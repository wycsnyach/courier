<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    $data['user'] = new UsersController; 
    $data['branch'] = new BranchController; 
    /*$data['supplier'] = new SupplierController;
    $data['product'] = new ProductController;
    $data['purchase'] = new PurchaseController;
    $data['color'] = new ColorController;
    $data['sale'] = new SaleController;*/
    

    return view('home', $data);
}



    
}
