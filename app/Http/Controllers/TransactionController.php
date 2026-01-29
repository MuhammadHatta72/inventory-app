<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions
     */
    public function index()
    {
        $transactions = Transaction::with('customer')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new transaction
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        return view('transactions.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created transaction
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_code' => 'required|exists:customers,code',
            'transaction_date' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_code' => 'required|exists:products,code',
            'products.*.qty' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.discount_1' => 'nullable|numeric|min:0',
            'products.*.discount_2' => 'nullable|numeric|min:0',
            'products.*.discount_3' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Get customer data
            $customer = Customer::where('code', $validated['customer_code'])->first();

            // Create transaction
            $transaction = Transaction::create([
                'customer_code' => $customer->code,
                'customer_name' => $customer->name,
                'customer_address' => $customer->full_address_formatted,
                'transaction_date' => $validated['transaction_date'],
                'total' => 0,
            ]);

            // Process each product
            foreach ($validated['products'] as $productData) {
                $product = Product::where('code', $productData['product_code'])->first();

                // Check stock availability
                if (!$product->isStockAvailable($productData['qty'])) {
                    throw new \Exception("Insufficient stock for product: {$product->name}. Available: {$product->stock}");
                }

                // Create transaction detail
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'invoice_number' => $transaction->invoice_number,
                    'product_code' => $product->code,
                    'product_name' => $product->name,
                    'qty' => $productData['qty'],
                    'price' => $productData['price'],
                    'discount_1' => $productData['discount_1'] ?? 0,
                    'discount_2' => $productData['discount_2'] ?? 0,
                    'discount_3' => $productData['discount_3'] ?? 0,
                ]);

                // Reduce stock
                $product->reduceStock($productData['qty']);
            }

            // Calculate total
            $transaction->calculateTotal();

            DB::commit();
            return redirect()->route('transactions.index')
                ->with('success', 'Transaction created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create transaction: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified transaction
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('details');
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Generate and download/stream invoice PDF
     */
    public function invoicePdf(Transaction $transaction)
    {
        $transaction->load('details');
        $pdf = Pdf::loadView('pdf.invoice', compact('transaction'))
            ->setPaper('a4')
            ->setOption('isHtml5ParserEnabled', true);
        $filename = 'invoice-' . str_replace(['/', '\\'], '-', $transaction->invoice_number) . '.pdf';
        return $pdf->stream($filename);
    }

    /**
     * Get customer data via AJAX
     */
    public function getCustomer($code)
    {
        $customer = Customer::where('code', $code)->first();
        if ($customer) {
            return response()->json([
                'success' => true,
                'data' => $customer
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Customer not found'
        ], 404);
    }

    /**
     * Get product data via AJAX
     */
    public function getProduct($code)
    {
        $product = Product::where('code', $code)->first();
        if ($product) {
            return response()->json([
                'success' => true,
                'data' => $product
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Product not found'
        ], 404);
    }
}
