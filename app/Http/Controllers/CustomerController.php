<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers
     */
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'desc')->get();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created customer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                'unique:customers,code',
                'regex:/^[a-zA-Z0-9]+$/', // Only alphanumeric
            ],
            'name' => 'required|string|max:200',
            'full_address' => 'required|string',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'village' => 'required|string|max:100',
            'postal_code' => 'required|numeric|digits:5',
        ], [
            'code.regex' => 'Customer code must be alphanumeric only (no special characters)',
            'code.unique' => 'Customer code already exists',
            'postal_code.digits' => 'Postal code must be exactly 5 digits',
            'postal_code.numeric' => 'Postal code must be numeric only',
        ]);

        try {
            Customer::create($validated);
            return redirect()->route('customers.index')
                ->with('success', 'Customer created successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create customer: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified customer
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified customer
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('customers', 'code')->ignore($customer->id),
                'regex:/^[a-zA-Z0-9]+$/',
            ],
            'name' => 'required|string|max:200',
            'full_address' => 'required|string',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'village' => 'required|string|max:100',
            'postal_code' => 'required|numeric|digits:5',
        ], [
            'code.regex' => 'Customer code must be alphanumeric only (no special characters)',
            'code.unique' => 'Customer code already exists',
            'postal_code.digits' => 'Postal code must be exactly 5 digits',
            'postal_code.numeric' => 'Postal code must be numeric only',
        ]);

        try {
            $customer->update($validated);
            return redirect()->route('customers.index')
                ->with('success', 'Customer updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update customer: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified customer
     */
    public function destroy(Customer $customer)
    {
        try {
            // Check if customer has transactions
            if ($customer->hasTransactions()) {
                return redirect()->route('customers.index')
                    ->with('error', 'Cannot delete customer that has transactions');
            }

            $customer->delete();
            return redirect()->route('customers.index')
                ->with('success', 'Customer deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('customers.index')
                ->with('error', 'Failed to delete customer: ' . $e->getMessage());
        }
    }
}
