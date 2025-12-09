<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\TempEntry;
use App\Models\Currency;
use App\Models\Stock;
use App\Models\Account;
use App\Models\Exchange;
use App\Models\TempPaymentItem;

class APIController extends Controller {

    public function getProduct(Request $request) {
        $id = $request->id;
        $searchBy = $request->searchBy;
        $product = Product::where($searchBy ?? 'id', $id)->first();
        $stock = Stock::where('store_id', 1)->where('product_id', $product->id)->first();
        $product->description = $stock != null ? $stock->quantity : 0;
//        dd($request->all());
        return json_encode($product != null ? $product : null);
    }

    public function Additems(Request $request) {
        $id = $request->id;
        $operation = $request->operation;
        $searchBy = $request->searchBy;
        $quantity = $request->quantity ?? 1;
        $account = $request->account_id ?? null;
        $product = Product::where($searchBy ?? 'id', $id)->first();
        $user = auth()->user();
        $items = $user->temp_items;
        $this->update_items($items, $product, $operation, $quantity, $account);
        $data = $user->temp_items;
        return json_encode($data);
    }

    private function update_items($items, $product, $operation, $quantity, $account) {
        if ($product != null) {
            $price = $product->price;
            $Account = new Account();
            if ($account != null) {
                $Account = Account::find($account);
                $price += $price * $Account->extra_price / 100;
            }
            // dd($price);
            $found = false;
            foreach ($items as $key => $item) {
                if (($item->product_id ?? '') == $product->id) {
                    $found = true;
                    if ($operation == 0) {
                        $item->quantity = 0;
                        $item->subtotal = 0;
                        $item->delete();
                    } elseif ($operation == 1) {
                        $item->quantity += 1;
                        $item->subtotal += $price;
                        $item->update();
                    } elseif ($operation == -1) {
                        $item->quantity -= 1;
                        $item->subtotal -= $price;
                        $item->update();
                    } elseif ($operation == 99) {
                        $item->quantity = $quantity;
                        $item->subtotal = $price * $quantity;
                        $item->update();
                    }
                }
            }
            if (!$found) {
                $item = $this->createNewitem($product, $quantity, $price);
                auth()->user()->temp_items()->save($item);
            }
        }
//        return $items;
    }

    private function createNewitem($product, $quantity, $price) {
        $item = new TempItem();
        $item->quantity = $quantity;
        $item->product_id = $product->id;
        $item->name = $product->name;
        $item->barcode = $product->barcode;
        $item->unitprice = $price / 1.16;
        $item->rate = $product->rate;
        $item->subtotal = $price * $quantity;
        return $item;
    }

    /* Entries */

    public function AddEntry(Request $request) {
        $id = $request->id;
        $searchBy = $request->searchBy;
        $user = auth()->user();
        $product = Product::where($searchBy ?? 'id', $id)->first();
        $entries = $user->temp_entries;
        $this->update_entries($entries, $product, $request);
        $data = $user->temp_entries;
        return json_encode($data);
    }

    private function update_entries($entries, $product, $request) {
        if ($product != null) {
            $found = false;
            $operation = $request->operation;
            foreach ($entries as $entry) {
                if (($entry->product_id ?? '') == $product->id) {
                    $found = true;
                    if ($operation == 0) {
                        $entry->delete();
                    } elseif ($operation == 11) {
                        $entry->quantity = $request->quantity;
                        $entry->update();
                    } elseif ($operation == 1) {
                        $entry->quantity += 1;
                        $entry->update();
                    } elseif ($operation == -1) {
                        $entry->quantity -= 1;
                        $entry->update();
                    } elseif ($operation == 99) {
                        $entry->quantity = $request->quantity;
//                        $entry->subtotal = $entry->buying_price * $request->quantity;
                        $entry->update();
                    }
                }
            }
            if (!$found) {
                $entry = $this->createNewEntry($request, $product);
                auth()->user()->temp_items()->save($entry);
            }
        }
    }

    private function createNewEntry($request, $product) {
//        dd("request: ".$request->name."<br /> Product: ". $product->name);
        $entry = new TempEntry();
        $entry->quantity = $request->quantity;
        $entry->old_price = $request->old_price;
        $entry->buying_price = $request->buying_price;
        $entry->current_price = $request->current_price;
        $entry->product_id = $product->id;
        $entry->store_id = $request->store_id;
        $entry->name = $request->name ?? $product->name;
        $entry->rate = $request->rate;
        $entry->description = $request->name ?? $product->name;
        return $entry;
    }

    public function AddPaymentItem(Request $request) {
        $user = auth()->user();
        $paymentitems = $user->temp_payment_items;
        $this->update_paymentitems($request, $paymentitems);
        $data = $user->temp_payment_items;
        return json_encode($data);
    }

    private function update_paymentitems($request, $paymentitems) {
//        dd($request->all());
        if ($request->way != "99") {
            $found = false;
            foreach ($paymentitems as $paymentitem) {
                if (($paymentitem->way ?? '') == $request->way) {
                    $found = true;
                    if ($request->operation == -1) {
                        $paymentitem->delete();
                    } elseif ($request->operation == 1) {
                        $paymentitem->amount = $request->amount;
                        $paymentitem->exchanged = $request->exchanged;
                        $paymentitem->update();
                    }
                }
            }
            if (!$found) {
                $paymentitem = $this->createNewpaymentitem($request);
                auth()->user()->temp_payment_items()->save($paymentitem);
            }
        }
    }

    private function createNewpaymentitem($request) {
        $paymentitem = new TempPaymentItem();
        $paymentitem->way = $request->way;
        $paymentitem->reference = $request->reference;
        $paymentitem->amount = $request->amount;
        $paymentitem->exchanged = $request->exchanged;
        $paymentitem->currency_id = $request->currency_id;
        $paymentitem->currency = $request->currency_id == 0 ? 'MT': Currency::find($request->currency_id ?? 0)->name;
        return $paymentitem;
    }

    /*
     * 
     * Abount Exchange
     */

    public function getLastExchange(Request $request) {
        $exchange = Exchange::where('currency_id', $request->id)->latest()->first();
        return json_encode(['amount' => ($exchange != null ? $exchange->amount : 0)]);
    }

    
}
