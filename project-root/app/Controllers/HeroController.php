<?php

namespace App\Controllers;

use App\Models\UserModel; // Pastikan untuk membuat model ini
use App\Models\FurnitureModel;
use CodeIgniter\Controller;

class HeroController extends Controller
{
    public function index()
{
    // Cek apakah pengguna sudah login
    $userId = $this->session->get('user_id');

    if (!$userId) {
        return redirect()->to('login'); // Redirect ke login jika user tidak terautentikasi
    }

    $model = new UserModel();
    $user = $model->find($userId);

    if (!$user) {
        return redirect()->to('login'); // Redirect jika user tidak ditemukan
    }

    return view('hero', ['username' => $user['name'], 'user_id' => $userId]);
}

}
