<?php
namespace App\Interfaces;

use Illuminate\Http\Request;

interface DriverRepositoryInterface
{
    public function searchDriver(Request $request);
    public function saveDateBitacora(Request $request);
}
