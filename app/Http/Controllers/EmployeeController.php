<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::select('users.id', 'users.name', 'users.email', DB::raw('count(orders.id) as total_orders'))
            ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->get();

        return view('employees.index', compact('employees'));
    }

    // You don't need the other methods (create, store, show, edit, update, destroy) for displaying the employee list.  You can remove them if you want, or leave them empty.
}

