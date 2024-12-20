<?php

namespace App\Controllers;

use App\Models\FurnitureModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class FurnitureController extends Controller
{
    public function index()
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login'); // Redirect ke halaman login jika user belum login
        }

        $furnitureModel = new FurnitureModel();
        $furnitureList = $furnitureModel->findAll(); // Ambil data furniture dari database
        $userModel = new \App\Models\UserModel();      
        $user = $userModel->find($userId);

        return view('furniture', [
            'furniture_list' => $furnitureList,
            'user_id' => $userId,
            'username' => $user['name'],
        ]);
    }
}
