<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\FurnitureModel;
use App\Models\AdminModel;


class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function processLogin()
    {
        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
            
        $user = $userModel->getUserByEmail($email);

        if(!$user){
            return redirect()->to('/')->with('error', 'Email tidak terdaftar!');
        } else if($user && !password_verify($password, $user['password'])){
            return redirect()->to('/')->with('error', 'password salah!');
        } else if ($user && password_verify($password, $user['password'])) {
            session()->set('user_id', $user['id']);
            $userId = session()->get('user_id');
            return redirect()->to('/hero'); // Redirect ke halaman produk
        } else {
            return redirect()->back()->with('error', 'email atau password invalid!');
        }
    }

    
    public function signup()
    {
        return view('auth/signup');
    }

    public function processSignup()
    {
        $userModel = new UserModel();
        $email = $this->request->getPost('email');

        $existingUser = $userModel->where('email', $email)->first();

        if ($existingUser) {
            return redirect()->back()->with('error', 'Email sudah terdaftar. Gunakan email lain.');
        }

        $data = [
            'name'     => $this->request->getPost('name'),
            'email'    => $email,
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'address'  => $this->request->getPost('address'),
            'phone'    => $this->request->getPost('phone'),
        ];

        if ($userModel->insert($data)) {
            return redirect()->to(site_url('/'));  // Arahkan ke halaman login setelah signup
        } else {
            return redirect()->back()->with('error', 'Registration failed');
        }
    }


    public function frontpage()
    {
        return view('auth/frontpage_login');
    }

    public function hero($userId = null)
{
    // Jika userId tidak diberikan, ambil dari session
    if (!$userId) {
        $userId = session()->get('user_id');
    }

    // Cek jika userId valid
    if (!$userId) {
        return redirect()->to('/login'); // Jika belum login, arahkan ke halaman login
    }

    $userModel = new \App\Models\UserModel();
    $user = $userModel->find($userId);

    $furnitureModel = new FurnitureModel();
    $furnitureList = $furnitureModel->findAll(); // Ambil data furniture dari database

    if (!$user) {
        return redirect()->to('/login'); // Jika user tidak ditemukan, arahkan ke login
    }

    // Kirim data username ke view
    return view('auth/hero', ['user_id' => $userId, 'username' => $user['name'], 'furniture_list' => $furnitureList,]);
}


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function forgotPassword()
{
    return view('auth/forgotpassword'); // Menampilkan halaman form forgot password
}

public function processForgotPassword()
{
    $userModel = new UserModel();
    $email = $this->request->getPost('email');

    // Validasi apakah email terdaftar
    $user = $userModel->getUserByEmail($email);

    if ($user) {
        session()->set('reset_email', $email);
        return redirect()->to('/reset_password'); // Perbaikan di sini
    } else {
        // Jika email tidak ditemukan, tampilkan error
        return redirect()->back()->with('error', 'Email not registered!');
    }
}

public function resetPassword($email)
{
    return view('auth/reset_password', ['email' => urldecode($email)]);
}

public function processResetPassword()
    {
        $userModel = new UserModel();
        $email = session()->get('reset_email');
        $newPassword = $this->request->getPost('password');
            $data = [
                'password' => password_hash($newPassword, PASSWORD_BCRYPT) // Hash password baru
            ];

        if ($userModel->where('email',$email)->set($data)->update()) {
                return redirect()->to(site_url('/'));  // Arahkan ke halaman login setelah signup
            } else {
                return redirect()->back()->with('error', 'Failed to reset password');
            }
    }

    //dari sini untuk admin

    public function adminLogin()
    {
        return view('admin/login'); // Halaman login admin
    }

    // Memproses login admin
    public function processAdminLogin()
    {
        $adminModel = new AdminModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $admin = $adminModel->where('email', $email)->first();

        if(!$admin){
            return redirect()->back()->with('error', 'Email tidak terdaftar!');
        }else if($admin && !password_verify($password, $admin['password'])){
            return redirect()->back()->with('error', 'Password salah!');
        }
        else if ($admin && password_verify($password, $admin['password'])) {
            session()->set('admin_id', $admin['admin_id']);
            return redirect()->to('/admin/dashboard');
        } else {
            return redirect()->to('admin/login')->with('error', 'email atau password invalid!');
        }
    }

    // Menampilkan halaman signup untuk admin
    public function adminSignup()
    {
        return view('admin/signup'); // Halaman sign-up admin
    }

    // Memproses signup admin
    public function processAdminSignup()
    {
        $adminModel = new AdminModel();
        $data = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ];

        if ($adminModel->insert($data)) {
            return redirect()->to('/adminIFA')->with('success', 'Admin account created successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to create admin account');
        }
    }

    // Admin logout
    public function adminLogout()
    {
        session()->destroy();
        return redirect()->to('/adminIFA'); //Ubah link admin sesuai yang diinginkan
    }


}