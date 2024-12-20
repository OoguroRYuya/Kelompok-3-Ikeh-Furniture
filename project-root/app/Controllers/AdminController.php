<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OrderModel;
use App\Models\FurnitureModel;
use App\Models\OrderDetailsModel;
use App\Models\CartModel;
use App\Models\PaymentModel;
use App\Models\ShipmentModel;


class AdminController extends BaseController
{
    
    // Menampilkan halaman utama admin
    public function index()
    {
        return view('admin/admin');
    }   

    // Mengelola pengguna
    public function manageUsers()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();

        return view('admin/admin_users', ['users' => $users]);
    }

    // Menghapus pengguna
    public function deleteUser($userId)
    {
        $userModel = new UserModel();
        $cartModel = new CartModel(); // Model untuk Cart
        $orderModel = new OrderModel(); // Model untuk Order
        $orderDetailsModel = new OrderDetailsModel(); // Model untuk OrderDetails
        $paymentModel = new PaymentModel(); // Model untuk Payment
        $shipmentModel = new ShipmentModel();

        // Cek apakah user ada
        $user = $userModel->find($userId);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User not found');
        }

        // Hapus data terkait di tabel order_details (gunakan order_id yang terkait dengan user_id)
        $orders = $orderModel->where('user_id', $userId)->findAll();
        foreach ($orders as $order) {
            // Hapus semua order_details yang terkait dengan order_id
            $orderDetailsModel->where('order_id', $order['order_id'])->delete();

            // Hapus data pembayaran yang terkait dengan order_id
            $paymentModel->where('order_id', $order['order_id'])->delete();

            $paymentModel->where('order_id', $order['order_id'])->delete();

            $shipmentModel->where('order_id', $order['order_id'])->delete();
        }

        // Hapus data terkait di tabel orders (gunakan user_id)
        $orderModel->where('user_id', $userId)->delete();

        // Hapus data terkait di tabel cart (gunakan user_id)
        $cartModel->where('user_id', $userId)->delete();

        // Hapus data user setelah data terkait dihapus
        if ($userModel->delete($userId)) {
            return redirect()->to('/admin/users')->with('message', 'User and related data deleted successfully');
        } else {
            return redirect()->to('/admin/users')->with('error', 'Failed to delete user');
        }
    }

    // Mengelola pesanan
    public function manageOrders()
    {
        $orderModel = new OrderModel();
        $orders = $orderModel->findAll();
        
        $shipmentModel = new ShipmentModel();
        
        // Mendapatkan status shipment untuk setiap order
        foreach ($orders as &$order) {
            $shipment = $shipmentModel->getShipmentByOrderId($order['order_id']);
            $order['shipment_status'] = $shipment ? $shipment['delivery_status'] : 'Not shipped';
        }

        return view('admin/admin_orders', ['orders' => $orders]);
    }

    // Mengubah status shipment
    public function updateShipmentStatus($orderId)
    {
        $status = $this->request->getPost('status');
        $shipmentModel = new ShipmentModel();

        // Update status shipment berdasarkan order_id
        if ($shipmentModel->updateShipmentStatus($orderId, $status)) {
            return redirect()->to('/admin/orders')->with('message', 'Shipment status updated successfully.');
        } else {
            return redirect()->to('/admin/orders')->with('error', 'Failed to update shipment status.');
        }
    }

    public function deleteOrder($id)
    {
        $orderModel = new OrderModel();
        $orderDetailsModel = new OrderDetailsModel();
        $paymentModel = new PaymentModel(); // Model untuk Payment
        $shipmentModel = new ShipmentModel();

        // Cek apakah order dengan ID tersebut ada
        $order = $orderModel->find($id);
        if ($order) {
            // Hapus data order details yang terkait
            $orderDetailsModel->where('order_id', $id)->delete();
            $paymentModel->where('order_id', $order['order_id'])->delete();
            $shipmentModel->where('order_id', $order['order_id'])->delete();

            // Hapus data order
            if ($orderModel->delete($id)) {
                return redirect()->to('/admin/orders')->with('message', 'Order deleted successfully');
            } else {
                return redirect()->to('/admin/orders')->with('error', 'Failed to delete order');
            }
        }

        return redirect()->to('/admin/orders')->with('error', 'Order not found');
    }



    public function manageFurniture()
    {
        $furnitureModel = new FurnitureModel();
        $furnitureItems = $furnitureModel->findAll();
        
        return view('admin/admin_furniture', ['furniture' => $furnitureItems]);
    }

    // Menambah furniture baru
    public function addFurniture()  
    {
        $furnitureModel = new FurnitureModel();
        $data = $this->request->getPost();

        if ($this->request->getFile('image')->isValid()) {
            $image = $this->request->getFile('image');
            $image->move('images', $image->getName());
            $data['image'] = $image->getName();
        }

        $furnitureModel->save($data);

        return redirect()->to('/admin/furniture')->with('message', 'Furniture added successfully.');
    }

    // Edit furniture
    public function editFurniture($id)
    {
        $furnitureModel = new FurnitureModel();
        $furniture = $furnitureModel->find($id);

        if (!$furniture) {
            return redirect()->to('/admin/furniture')->with('error', 'Furniture not found');
        }

        return view('admin/edit_furniture', ['furniture' => $furniture]);
    }

    // Update furniture
    public function updateFurniture($id)
    {
        $furnitureModel = new FurnitureModel();
        $data = $this->request->getPost();

        // Cek apakah file gambar baru di-upload
        if ($this->request->getFile('image')->isValid()) {
            $image = $this->request->getFile('image');
            $image->move('images', $image->getName());
            $data['image'] = $image->getName();
        }

        if ($furnitureModel->update($id, $data)) {
            return redirect()->to('/admin/furniture')->with('message', 'Furniture updated successfully.');
        } else {
            return redirect()->to('/admin/furniture')->with('error', 'Failed to update furniture.');
        }
    }

    // Menghapus furniture
    public function deleteFurniture($id)
    {
        $furnitureModel = new FurnitureModel();

        // Cek apakah furniture dengan ID tersebut ada
        if ($furnitureModel->find($id)) {
            // Hapus data furniture
            if ($furnitureModel->delete($id)) {
                return redirect()->to('/admin/furniture')->with('message', 'Furniture deleted successfully');
            } else {
                return redirect()->to('/admin/furniture')->with('error', 'Failed to delete furniture');
            }
        }

        return redirect()->to('/admin/furniture')->with('error', 'Furniture not found');
    }
}

