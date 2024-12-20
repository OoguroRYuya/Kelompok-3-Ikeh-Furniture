<?php

namespace App\Controllers;

use App\Models\CartModel;

class CheckoutController extends BaseController
{
    public function index()
    {
        $session = session();
        $userId = $session->get('user_id');
    
        if (!$userId) {
            return redirect()->to('/login');
        }
    
        $cartModel = new CartModel();
        $cartItems = $cartModel->getCartItems($userId); // Ambil data item di keranjang untuk user ini
    
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
    
        $data = [
            'cart_items' => $cartItems,
            'total_amount' => $totalAmount, // Simpan total amount dalam array data
            'user_id' => $userId,
        ];  
    
        return view('checkout', $data); // Kirim data ke view
    }


    
    
}
