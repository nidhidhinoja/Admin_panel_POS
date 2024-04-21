<?php

namespace App\Http\Controllers;
// use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Shopkeeper;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
     {
         $startDate = null;
         $endDate = null;

         if (request()->has(['dateFrom', 'dateTo'])) {
             $startDate = request('dateFrom');
             $endDate = request('dateTo');
         }

         $user = Auth::user();

         if ($user->role == 1) {
             $orders = Order::with('customer')
                 ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                     return $query->whereBetween('created_at', [
                         Carbon::parse($startDate)->startOfDay(),
                         Carbon::parse($endDate)->endOfDay()
                     ]);
                 })
                 ->orderBy('created_at', 'desc')
                 ->get();
         } else {
             $orders = Order::with('customer')
                 ->whereHas('customer', function ($query) use ($user) {
                     $query->where('shop_id', $user->shop_id);
                 })
                 ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                     return $query->whereBetween('created_at', [
                         Carbon::parse($startDate)->startOfDay(),
                         Carbon::parse($endDate)->endOfDay()
                     ]);
                 })
                 ->orderBy('created_at', 'desc')
                 ->get();
         }

         foreach ($orders as $order) {
             $order->order_id = $order->id;
         }

         return view('order.index', compact('orders'));
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         $products = $request->input('products');
         $shopkeeper = Auth::user(); // Get the authenticated shopkeeper

         $order = new Order();
         // Set the created_at and updated_at timestamps
        $order->created_at = Carbon::now();
        $order->updated_at = Carbon::now();

        // Check if the order_date is provided in the raw data
        if ($request->has('order_date')) {
            $order->order_date = $request->input('order_date');
        } else {
            // Set the order_date to the current date if not provided
            $order->order_date = Carbon::now()->toDateString();
        }
         $order->customer_id = $request->input('customer_id');
         $order->payment_method = $request->input('payment_method');
         $order->tendered_amount = $request->input('tendered_amount');
         $order->status = $request->input('status');
         $order->description = $request->input('description');
         $order->save();

         $totalAmount = 0;

         foreach ($products as $product) {
             $product_id = $product['product_id'];
             $quantity = $product['quantity'];

             $product = $shopkeeper->products()->findOrFail($product_id); // Only find products belonging to the shopkeeper
             $price = $product->price * $quantity;

             $totalAmount += $price;

             $orderDetails = new OrderDetails();
             $orderDetails->order_id = $order->id;
             $orderDetails->product_id = $product_id;
             $orderDetails->quantity = $quantity;
             $orderDetails->price = $price;
             $orderDetails->save();
         }

         $order->total_amount = $totalAmount;
         $order->change = $order->tendered_amount - $order->total_amount;
         $order->save();

         return $this->print($request, $order->id);
     }

     public function posStore(Request $request)
     {
         $products = $request->input('products');
         $shopkeeper = Auth::user(); // Get the authenticated shopkeeper

         // Start a transaction
         DB::beginTransaction();

         try {
             $order = new Order();
             // Set the created_at and updated_at timestamps
             $order->created_at = Carbon::now();
             $order->updated_at = Carbon::now();

             // Check if the order_date is provided in the raw data
             if ($request->has('order_date')) {
                 $order->order_date = $request->input('order_date');
             } else {
                 // Set the order_date to the current date if not provided
                 $order->order_date = Carbon::now()->toDateString();
             }
             $order->customer_id = $request->input('customer_id');
             $order->payment_method = $request->input('payment_method');
             $order->tendered_amount = $request->input('tendered_amount');
             $order->status = $request->input('status');
             $order->description = $request->input('description');

             // Check if the customer exists and belongs to the shopkeeper
             $customer = Customer::where('id', $order->customer_id)
                 ->where('shop_id', $shopkeeper->shop_id)
                 ->first();

             if (!$customer) {
                 throw new \Exception('Invalid customer_id or customer does not belong to the shopkeeper');
             }

             $order->save();

             $totalAmount = 0;
             $hasInvalidProduct = false;

             foreach ($products as $product) {
                 $product_id = $product['product_id'];
                 $quantity = $product['quantity'];

                 // Check if the product belongs to the shopkeeper
                 $product = $shopkeeper->products()->find($product_id);
                 if (!$product) {
                     $hasInvalidProduct = true;
                     break;
                 }

                 $price = $product->price * $quantity;
                 $totalAmount += $price;

                 $orderDetails = new OrderDetails();
                 $orderDetails->order_id = $order->id;
                 $orderDetails->product_id = $product_id;
                 $orderDetails->quantity = $quantity;
                 $orderDetails->price = $price;
                 $orderDetails->save();
             }

             if ($hasInvalidProduct) {
                 throw new \Exception('Invalid product_id or product does not belong to the shopkeeper');
             }

             $order->total_amount = $totalAmount;
             $order->change = $order->tendered_amount - $order->total_amount;
             $order->save();

             // Commit the transaction
             DB::commit();

             return $this->posPrint($request, $order->id);
         } catch (\Exception $e) {
             // Rollback the transaction in case of any exception
             DB::rollback();

             return response()->json([
                 'message' => $e->getMessage()
             ], 400);
         }
     }



     public function show(Request $request, string $id)
     {
         try {
             $order = Order::with(['customer', 'orderDetails.product.shopkeeper'])
                 ->findOrFail($id);

             $products = $order->orderDetails->map(function ($orderDetail) {
                 return [
                     'product_id' => $orderDetail->product_id,
                     'product_name' => $orderDetail->product->name,
                     'quantity' => $orderDetail->quantity,
                     'price' => $orderDetail->price,
                 ];
             });

             $shopkeeperName = $order->orderDetails->first()->product->shopkeeper->name;
             $shopName = $order->orderDetails->first()->product->shopkeeper->shop_name;
             $shopCity = $order->orderDetails->first()->product->shopkeeper->shop_city;

             return response()->json([
                 'order_id' => $order->id,
                 'customer_id' => $order->customer->id,
                 'customer_name' => $order->customer->name,
                 'order_date' => $order->order_date,
                 'shopkeeper_name' => $shopkeeperName,
                 'shop_name' => $shopName,
                 'shop_city' => $shopCity,
                 'products' => $products,
                 'payment_method' => $order->payment_method,
                 'tendered_amount' => $order->tendered_amount,
                 'change' => $order->change,
                 'status' => $order->status,
                 'total_amount' => $order->total_amount,
                 'description' => $order->description,
             ]);
         } catch (ModelNotFoundException $e) {
             // Handle the case when the order is not found
             return response()->json([
                 'error' => 'Order not found.',
             ], 404);
         } catch (\Exception $e) {
             // Handle any other exceptions
             return response()->json([
                 'error' => 'An error occurred.',
             ], 500);
         }
     }


     public function print(Request $request, string $id)
     {
         try {
             $order = Order::with(['customer', 'orderDetails.product.shopkeeper'])
                 ->findOrFail($id);

             $products = $order->orderDetails->map(function ($orderDetail) {
                 return [
                     'product_id' => $orderDetail->product_id,
                     'product_name' => $orderDetail->product->name,
                     'quantity' => $orderDetail->quantity,
                     'price' => $orderDetail->price,
                     // Add other fields for the product
                 ];
             });

             $data = [
                 'order_id' => $order->id,
                 'order_date'=> $order->order_date,
                 'customer_id' => $order->customer->id,
                 'customer_name' => $order->customer->name,
                 'customer_address' => $order->customer->address,
                 'customer_city' => $order->customer->city,
                 'shopkeeper_name' => $order->orderDetails[0]->product->shopkeeper->name,
                 'shop_name' => $order->orderDetails[0]->product->shopkeeper->shop_name,
                 'shop_logo' => $order->orderDetails[0]->product->shopkeeper->image,
                 'shop_address' => $order->orderDetails[0]->product->shopkeeper->shop_address,
                 'shop_city' => $order->orderDetails[0]->product->shopkeeper->shop_city,
                 'products' => $products,
                 'payment_method' => $order->payment_method,
                 'tendered_amount' => $order->tendered_amount,
                 'change' => $order->change,
                 'status' => $order->status,
                 'total_amount' => $order->total_amount,
                 'description' => $order->description,
             ];

             $pdf = new Dompdf();
             $html = view('invoice')->with('data', $data)->render(); // Pass $data using with()
             $pdf->loadHtml($html);
             $pdf->setPaper('A4', 'portrait');
             $pdf->render();

             $filename = 'invoice_' . $id . '.pdf';
             $pdfContent = $pdf->output();

             // Set the response headers
             $headers = [
                 'Content-Type' => 'application/pdf',
                 'Content-Disposition' => 'attachment; filename="' . $filename . '"',
             ];

             // Return the PDF content as a response with the appropriate headers
             return response($pdfContent, 200, $headers);
         } catch (ModelNotFoundException $e) {
             // Handle the case when the order is not found
             return response()->json([
                 'error' => 'Order not found.',
             ], 404);
         } catch (\Exception $e) {
             // Handle any other exceptions
             return response()->json([
                 'error' => 'An error occurred.',
             ], 500);
         }
     }

    public function posPrint(Request $request, string $id)
    {
        $shopkeeper = Auth::user(); // Get the authenticated shopkeeper

            $order = Order::with(['customer', 'orderDetails.product.shopkeeper'])
                ->whereHas('orderDetails.product.shopkeeper', function ($query) use ($shopkeeper) {
                    $query->where('shopkeepers.id', $shopkeeper->id);
                })
                ->findOrFail($id);

            $products = $order->orderDetails->map(function ($orderDetail) {
                return [
                    'product_id' => $orderDetail->product_id,
                    'product_name' => $orderDetail->product->name,
                    'quantity' => $orderDetail->quantity,
                    'price' => $orderDetail->price,
                    // Add other fields for the product
                ];
            });
        $data = [
            'order_id' => $order->id,
            'order_date'=> $order->order_date,
            'customer_id' => $order->customer->id,
            'customer_name' => $order->customer->name,
            'customer_address' => $order->customer->address,
            'customer_city' => $order->customer->city,
            'customer_num' => $order->customer->phone_no,
            'shopkeeper_name' => $order->orderDetails[0]->product->shopkeeper->name,
            'shop_name' => $order->orderDetails[0]->product->shopkeeper->shop_name,
            'shop_logo' => $order->orderDetails[0]->product->shopkeeper->image,
            'shop_address' => $order->orderDetails[0]->product->shopkeeper->address,
            'shop_city' => $order->orderDetails[0]->product->shopkeeper->city,
            'shop_num' => $order->orderDetails[0]->product->shopkeeper->phone_number,
            'shop_gstin' => $order->orderDetails[0]->product->shopkeeper->gst,
            'products' => $products,
            'payment_method' => $order->payment_method,
            'tendered_amount' => $order->tendered_amount,
            'change' => $order->change,
            'status' => $order->status,
            'total_amount' => $order->total_amount,
            'description' => $order->description,
        ];
            $pdf = new Dompdf();
            $html = view('thermalDynamic')->with('data', $data)->render();

            // Set custom paper size for thermal bill
            $paperOptions = [
                'width' => '80mm',  // Adjust width as needed
                'height' => 'auto',  // Adjust height as needed
            ];

            $pdf->setPaper($paperOptions['width'], $paperOptions['height'], 'portrait');
            $pdf->loadHtml($html);
            $pdf->render();

            $filename = 'posInvoice_' . $id . '.pdf';
            $pdfContent = $pdf->output();

            // Set the response headers
            $headers = [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            // Return the PDF content as a response with the appropriate headers
            return response($pdfContent, 200, $headers);
    }

    public function getOrdersByDateRange(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $shopkeeper = Auth::user(); // Get the authenticated shopkeeper

        $orders = Order::whereBetween('created_at', [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay()
        ])
            ->whereHas('orderDetails.product.shopkeeper', function ($query) use ($shopkeeper) {
                $query->where('shopkeepers.id', $shopkeeper->id);
            })
            ->get();


        $formattedOrders = [];

        foreach ($orders as $order) {
            $formattedOrders[] = $this->show($request, $order->id);
        }

        return response()->json($formattedOrders);
    }

    public function filterOrdersByDate(Request $request)
    {
        // Get the selected dates from the request
        $dateFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo');

        // Convert the selected dates to Carbon instances
        $startDate = Carbon::parse($dateFrom)->startOfDay();
        $endDate = Carbon::parse($dateTo)->endOfDay();

        // Query the orders between the selected dates
        $filteredOrders = DB::table('orders')
            ->whereBetween('order_date', [$startDate, $endDate])
            ->get();

        // Return the filtered orders
        return $filteredOrders;
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
