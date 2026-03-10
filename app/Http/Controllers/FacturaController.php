<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Factura;
use Illuminate\Http\Request;
use App\Http\Requests\Account\StoreFactura;
use App\Http\Requests\Account\UpdateFactura;
use App\Models\Store;
use App\Models\Product;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\ProductChild;
use App\Models\Currency;
use App\Models\TempPaymentItem;
use App\Models\RunOutSell;
use App\Models\User;
use App\View\Components\Alert;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;

class FacturaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private Factura $factura;
    private $limit = 10;
    private User $user;

    function __construct(Factura $factura)
    {
        $this->factura = $factura;
        // Injeção de dependência do usuário autenticado no construtor
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
        $this->middleware(['auth']);
    }



    public function index()
    {
        return view('factura.index');
    }


    public function create()
    {
        return view('factura.create', ['today' => today()]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            # Factura
            $items = array_filter($request->items, function ($item) {
                return $item['quantity'] > 0;
            });
            $customer = $request->customer;
            $totals = $request->valores;
            $productIds = array_column($items, 'id');
            #Check Stock for all products
            $itemsCollection = collect($items)->keyBy('id');

            $products = Product::select(['id', 'name', 'quantity', 'barcode', 'price', 'rate', 'parent', 'flap'])
                ->whereIn('id', $productIds)
                ->get()
                ->map(function ($product) use ($itemsCollection) {
                    $requested = ($itemsCollection->get($product->id)['quantity'] ?? 0);
                    $dedutionQuantity = $requested * $product->flap;

                    // Adicionamos os campos dinamicamente
                    $product->requested_quantity = $requested;
                    $product->stock_diff = $product->quantity - $requested;
                    $product->dedution = $dedutionQuantity;
                    return $product;
                });
            // dd($products->toArray());
            DB::beginTransaction();
            $factura = $this->factura->create([
                'customer_id' => null,
                'customer_name' => $customer['name'] ?? '',
                'customer_phone' => $customer['tel'] ?? '',
                'customer_nuit' => $customer['nuit'] ?? '',
                'customer_address' => $customer['address'] ?? '',
                'subtotal' => $totals['subtotal'],
                'totalrate' => 0,
                'discount' => 0,
                'total' => $totals['total'],
                'day' => today(),
                'payed' => 0,
            ]);
            # Registering the Items and update the stock for each one!
            foreach ($products as $product) {
                $data = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'barcode' => $product->barcode,
                    'quantity' => $product->requested_quantity,
                    'unitprice' => $product->price,
                    'rate' => $product->rate ?? env('RATE', 16),
                    'subtotal' => $product->price * $product->requested_quantity,
                    'dedution' => $product->dedution,
                ];
                $factura->items()->create($data);
                #Updating also the stock of the same product: usaos o parent ao inves de id para actualizarmos mesmo naqueles casos de retalho
                Product::where('id', $product->parent)
                    ->decrement('quantity', $product->dedution);
            }
            DB::commit();
            return response()->json(['message' => "Factura criada com sucesso. Nr: {$factura->id}"]);
        } catch (\Throwable $th) {
            return response()->json(['message' => "Erro guardar factura: {$th->getMessage()} na lina {$th->getLine()}."], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function show(Factura $factura): JsonResponse
    {
        try {
            $factura = $factura->loadMissing('items');
            return ApiResponse::success($factura, 'Factura obtida com sucesso.');
        } catch (\Throwable $th) {
            return response()->json(['message' => "Erro visualizar dados da factura: {$th->getMessage()} na lina {$th->getLine()}."], 400);
        }
    }

    public function display(Factura $factura)
    {
        try {
            $factura = $factura->loadMissing('items');
            return view('factura.show', compact('factura'));
        } catch (\Throwable $th) {
            return response()->json(['message' => "Erro ao apresentar os dados da factura: {$th->getMessage()} na lina {$th->getLine()}."], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function edit(Factura $factura)
    {
        return view('factura.edit', compact('factura'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Factura\UpdateFactura  $request
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFactura $request, Factura $factura)
    {
        try {
            return response(['Nothing']);
        } catch (\Throwable $th) {
            return response()->json(['message' => "Erro ao actualizar os dados da factura: {$th->getMessage()} na lina {$th->getLine()}."], 400);
        }
    }

    public function askDestroy(Request $request, $id)
    {
        $factura = $this->factura->findOrfail($id);

        $factura->destroy_date = Carbon::now();
        $factura->destroy_username = $request->destroy_username;
        $factura->destroy_reason = $request->destroy_reason;
        $update = $factura->update();
        if ($update) {
            return redirect()->route('factura.show', $factura->id)->with(['sucesso' => __('messages.prompt.request_done')]);
        } else {
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure')]);
        }
    }

    public function cancelAskDestroy(Request $request, $id)
    {
        $factura = $this->factura->findOrfail($id);

        $factura->destroy_date = null;
        $factura->destroy_username = null;
        $factura->destroy_reason = null;
        $update = $factura->update();
        if ($update) {
            return redirect()->route('factura.show', $factura->id)->with(['sucesso' => __('messages.prompt.request_done')]);
        } else {
            return redirect()->back()->with(['falha' => __('messages.prompt.request_failure')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factura $factura)
    {
        try {
        } catch (\Throwable $th) {
            return response()->json(['message' => "Erro ao cancelar a factura: {$th->getMessage()} na lina {$th->getLine()}."], 400);
        }
    }


    /**
     * Returns Invoices for payments
     * Filter by date:
     */
    public function invoicesForPayment($payed = false)
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $facturas = Factura::select('id', 'customer_name', 'total', 'created_at')
            ->where(function ($query) use ($today, $tomorrow, $payed) {
                $query->whereBetween('created_at', [$today, $tomorrow])
                    ->when($payed == 'false', function ($innerQuery) {
                        $innerQuery->where('payed', false);
                    })
                    ->when($payed == 'true', function ($innerQuery) {
                        $innerQuery->where('payed', true);
                    });
            })
            ->orderBy('created_at', 'desc')
            // ->take(100)
            ->get();
        $flag = $payed == 'true' ? '' : 'NÃO';
        $facturasHeader = "Pesquisar facturas {$flag} pagas";
        return view('factura.factura-for-payment', compact('facturas', 'facturasHeader', 'payed'));
    }

    /**
     * Brings the list of facruras based 
     */
    public function list($payed, $q = '')
    {
        try {
            $today = Carbon::today();
            $tomorrow = Carbon::tomorrow();

            $facturas = Factura::query()
                ->select(['id', 'customer_name', 'total', 'day', 'created_at', 'payed'])
                ->where(function ($query) use ($today, $tomorrow, $payed) {
                    $query->whereBetween('created_at', [$today, $tomorrow])
                        ->when($payed == 0, function ($innerQuery) {
                            $innerQuery->orWhere('payed', false);
                        })
                        ->when($payed == 1, function ($innerQuery) {
                            $innerQuery->where('payed', true);
                        });
                })
                ->when($q != '', function ($innerQuery) use ($q) {
                    $innerQuery->where('customer_name', 'like', "%{$q}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate($this->limit);
            return view('factura.list', compact('facturas', 'payed'));
        } catch (\Throwable $th) {
            DB::rollback();
            return response(Blade::renderComponent(new Alert("falha", "Erro buscar a lista de facturas ($payed): {$th->getMessage()} na lina {$th->getLine()}.")), 400);
        }
    }
}
