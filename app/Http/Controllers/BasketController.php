<?php

namespace App\Http\Controllers;

use App\Models\Basket;

/**
 ** Made by Kishan Jethwa
 */

/**
 *? The basket controller is responsible for showing the user's basket and deleting the user's basket
 *? Basket creation is handled by the basket item controller
 */

class BasketController extends Controller
{
    public function show()
    {
        // Get the authenticated user
        $user = auth()->user();
        // Get the basket of the authenticated user
        $basket = Basket::where('user_id', $user->id)->first();
        // Optionally get the basket items of the basket if the basket exists
        $basketItems = optional($basket)->items;

        // Calculate the total price of the basket items
        $totalPrice = 0;
        foreach ($basketItems as $basketItem) {
            // For each item in the basket, add the price of the product multiplied by the quantity to the total price
            $totalPrice += $basketItem->product->selling_price * $basketItem->quantity;
        }

        if ($basketItems) {
            return view('basket.show', compact('basketItems', 'totalPrice')); // Pass the basket items to the view as well as the total price
        } else {
            return view('basket.show')->with('error', 'You do not have a basket'); // Redirect to the basket and display an error
        }
    }

    public function destroy()
    {
        // Get the authenticated user
        $user = auth()->user();
        // Get the basket of the authenticated user
        $basket = Basket::where('user_id', $user->id)->first();
        // Delete the basket
        $basket->delete();

        return redirect()->route('basket.show')->with('success', 'Basket deleted');
    }
}
