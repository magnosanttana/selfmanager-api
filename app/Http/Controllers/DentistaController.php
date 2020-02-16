<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DentistaController extends Controller
{
    
    public function index()
    {
        return $this->service->lists();
    }
    
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    public function show(int $id)
    {
        return $this->service->find($id);
    }

    public function update(Request $request, int $id)
    {
        return $this->service->update($request->all(), $id);
    }

    public function destroy(int $id)
    {
        return $this->service->delete($id);
    }
}