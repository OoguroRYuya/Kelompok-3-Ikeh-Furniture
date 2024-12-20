<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderDetailsModel;
use App\Models\CartModel;
use App\Models\UserModel;
use App\Models\FurnitureModel;
use App\Models\ShipmentModel;
use App\Models\PaymentModel;

class OrderController extends BaseController
{
    public function index()
    {
        $session = session();
        $userId = $session->get('user_id');

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $orderModel = new OrderModel();
        $shipmentModel = new ShipmentModel(); // Load shipment model
        $orders = $orderModel->getOrdersWithStatus($userId, false); // false berarti hanya pesanan yang tidak dihapus

        // Dapatkan status pengiriman untuk setiap pesanan
        foreach ($orders as &$order) {
            // Ambil status pengiriman berdasarkan order_id
            $shipment = $shipmentModel->where('order_id', $order['order_id'])->first();
            $order['delivery_status'] = $shipment ? $shipment['delivery_status'] : 'Pending'; // Default ke 'Pending' jika tidak ada data pengiriman
        }

        return view('orders', [
            'orders' => $orders,
            'user_id' => $userId,
            'username' => $user['name'],
        ]);
    }

    public function placeOrder()
    {
        $session = session();
        $userId = $session->get('user_id');

        $userModel = new UserModel();
        $user = $userModel->find($userId);
        
        if (!$userId) {
            return redirect()->to('/login');
        }

        $cartModel = new CartModel();
        $cartItems = $cartModel->getCartItems($userId);
        
        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Your cart is empty.');
        }
        
        // Hitung total amount
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        
        // Simpan data order ke database
        $orderModel = new OrderModel();
        $orderId = $orderModel->insert([
            'user_id' => $userId,
            'total_amount' => $totalAmount,
        ]);

        if (!$orderId) {
            return redirect()->to('/cart')->with('error', 'Failed to create order.');
        }
        
        // Simpan detail order
        $orderDetailsModel = new OrderDetailsModel();
        $furnitureModel = new FurnitureModel();
        $shipmentModel = new ShipmentModel(); // buat shipment
        
        foreach ($cartItems as $item) {
            // Cek jika stok cukup
            $currentStock = $furnitureModel->where('furniture_id', $item['furniture_id'])->first()['stock'];
        
            if ($currentStock < $item['quantity']) {
                return redirect()->to('/cart')->with('error', 'Not enough stock for ' . $item['name']);
            }
        
            $orderDetailsModel->insert([
                'order_id' => $orderId, // Gunakan satu order_id untuk semua detail
                'furniture_id' => $item['furniture_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // Mengurangi stok di FurnitureModel
            $furnitureModel->set('stock', 'stock - ' . $item['quantity'], false)
                            ->where('furniture_id', $item['furniture_id'])
                            ->update();
        }

        // Buat entri untuk shipment
        $shipmentModel->insert([
            'order_id' => $orderId,
            'address' => $user['address'],
            'quantity' => "Pending",
            'delivery_status' => "Pending",
        ]);

        // Hapus item dari cart setelah order dibuat
        $cartModel->where('user_id', $userId)->delete();
        
        return redirect()->to('orders')->with('message', 'Order placed successfully.');
    }


    public function cancel($orderId)
    {
        $session = session();
        $userId = $session->get('user_id');

        // Model untuk order dan shipment
        $orderModel = new OrderModel();
        $shipmentModel = new ShipmentModel();
        $paymentModel = new PaymentModel(); // Model untuk Payment

        // Cari pesanan berdasarkan order_id
        $order = $orderModel->find($orderId);

        if (!$order || $order['user_id'] != $userId) {
            return redirect()->to('/orders')->with('error', 'Pesanan tidak ditemukan atau Anda tidak memiliki akses.');
        }

        // Cari status pengiriman dari tabel shipment
        $shipment = $shipmentModel->where('order_id', $orderId)->first();

        if (!$shipment) {
            return redirect()->to('/orders')->with('error', 'Status pengiriman tidak ditemukan.');
        }

        // Cek status pengiriman untuk menentukan apakah pesanan dapat dibatalkan
        if ($shipment['delivery_status'] == 'Pending') {
            // Hapus pesanan jika statusnya 'Pending'

            // Hapus detail pesanan dan shipment terkait
            $orderDetailsModel = new OrderDetailsModel();
            $orderDetailsModel->where('order_id', $orderId)->delete();
            $paymentModel->where('order_id', $order['order_id'])->delete();
            $shipmentModel->where('order_id', $order['order_id'])->delete();

            // Hapus data order
            if ($orderModel->delete($orderId)) {
                return redirect()->to('/orders')->with('message', 'Pesanan berhasil dibatalkan.');
            } else {
                return redirect()->to('/orders')->with('error', 'Failed to delete order');
            }

        } elseif ($shipment['delivery_status'] == 'Confirmed' && session()->get('is_admin')) {
            // Admin yang bisa membatalkan pesanan yang sudah dikonfirmasi
            $orderModel->delete($orderId);

            // Hapus detail pesanan dan shipment terkait
            $orderDetailsModel = new OrderDetailsModel();
            $orderDetailsModel->where('order_id', $orderId)->delete();

            $shipmentModel->where('order_id', $orderId)->delete();

            return redirect()->to('/orders')->with('message', 'Pesanan berhasil dibatalkan.');
        } elseif ($shipment['delivery_status'] == 'Shipped' || $shipment['delivery_status'] == 'Delivered') {
            // Tidak bisa dibatalkan jika sudah dikirim atau diterima
            return redirect()->to('/orders')->with('error', 'Pesanan sudah dikirim atau diterima, tidak bisa dibatalkan.');
        }
    }

    public function removeOrderHistory($orderId)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->find($orderId);

        if (!$order) {
            return redirect()->to('/orders')->with('error', 'Pesanan tidak ditemukan.');
        }


        // Update hanya jika is_deleted adalah false
        if ($order['is_deleted'] == 0) {

            $updateStatus = $orderModel->update($orderId, ['is_deleted' => TRUE]);

            if (!$updateStatus) {
                return redirect()->to('/orders')->with('error', 'Gagal memperbarui riwayat pesanan.');
            }

            return redirect()->to('/orders')->with('message', 'Riwayat pesanan berhasil dihapus.');
        } else {
            return redirect()->to('/orders')->with('error', 'Pesanan ini sudah dihapus sebelumnya.');
        }
    }


   public function getOrderDetails($orderId)
{
    $orderDetailsModel = new OrderDetailsModel();
    $shipmentModel = new ShipmentModel();
    $furnitureModel = new FurnitureModel(); // Model untuk furniture

    // Ambil detail pesanan
    $orderDetails = $orderDetailsModel->where('order_id', $orderId)->findAll();

    // Ambil informasi pengiriman
    $shipment = $shipmentModel->where('order_id', $orderId)->first();

    // Menambahkan informasi furniture (nama dan gambar) ke dalam setiap orderDetails
    $furnitureData = [];
    foreach ($orderDetails as &$item) {
        // Cari data furniture berdasarkan furniture_id di orderDetail
        $furniture = $furnitureModel->find($item['furniture_id']);
        if ($furniture) {
            // Menambahkan nama dan gambar dari tabel furniture ke orderDetails
            $item['furniture_name'] = $furniture['name'];
            $item['furniture_image'] = $furniture['image']; // Gambar furniture
            $furnitureData[] = $furniture; // Menyimpan data furniture untuk dikirimkan
        }
    }

    if ($orderDetails) {
        return $this->response->setJSON([
            'status' => 'success',
            'data' => [
                'orderDetails' => $orderDetails,
                'shipment' => $shipment,
                'furniture' => $furnitureData, // Mengirimkan data furniture
            ],
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Detail pesanan tidak ditemukan.',
        ]);
    }
}




}