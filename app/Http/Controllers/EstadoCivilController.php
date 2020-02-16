<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EstadoCivilController extends Controller
{
    
    public function index()
    {
        return $this->service->lists();
    }
    
    public function show(int $id)
    {
        return $this->service->find($id);
    }

}