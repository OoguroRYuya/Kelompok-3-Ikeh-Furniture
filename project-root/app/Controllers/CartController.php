<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\FurnitureModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class CartController extends Controller
{
    public function index()
    {
        $session = session();
        $userId = $session->get('user_id');
        
        $userModel = new \App\Models\UserModel();      
        $user = $userModel->find($userId);

        if (!$userId) {
            return redirect()->to('/login'); // Redirect jika belum login
        }

        $cartModel = new CartModel();
        $cartItems = $cartModel->getCartItems($userId);

        return view('cart', [
            'cart_items' => $cartItems,
            'user_id' => $userId,
            'username' => $user['name'],
        ]);
    }

    public function remove($cartId)
    {
        $cartModel = new CartModel();
        $cartModel->delete($cartId);

        return redirect()->to('/cart')->with('message', 'Item removed from cart.');
    }

    public function add()
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $furnitureId = $this->request->getPost('furniture_id');
        $quantity = $this->request->getPost('quantity');

        $cartModel = new CartModel();

        // Cek apakah item sudah ada di cart
        $existingItem = $cartModel->where('user_id', $userId)
                                ->where('furniture_id', $furnitureId)
                                ->first();

        if ($existingItem) {
            // Update quantity jika item sudah ada
            $newQuantity = $existingItem['quantity'] + $quantity;
            $cartModel->update($existingItem['cart_id'], ['quantity' => $newQuantity]);
        } else {
            // Tambah item baru ke cart
            $cartModel->insert([
                'user_id' => $userId,
                'furniture_id' => $furnitureId,
                'quantity' => $quantity
            ]);
        }

        return redirect()->to('/cart')->with('message', 'Item added to cart.');
    }

    public function updateQuantity($cartId)
{
    $session = session();
    $userId = $session->get('user_id');

    if (!$userId) {
        return redirect()->to('/login')->with('error', 'Please login first.');
    }

    $cartModel = new CartModel();
    $furnitureModel = new FurnitureModel();

    $cartItem = $cartModel->find($cartId);

    if ($cartItem && $cartItem['user_id'] == $userId) {
        $action = $this->request->getPost('action');
        $quantity = $cartItem['quantity'];

        $furniture = $furnitureModel->find($cartItem['furniture_id']);

        if ($action == 'increase' && $quantity < $furniture['stock']) {
            $quantity++; 
        } elseif ($action == 'decrease' && $quantity > 1) {
            $quantity--; 
        } else {
            return redirect()->to('/cart')->with('error', 'stok tidak cukup.');
        }
        $cartModel->update($cartId, ['quantity' => $quantity]);
    }

    return redirect()->to('/cart')->with('message', 'Cart updated successfully.');
}


    


}
