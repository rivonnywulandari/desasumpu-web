<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountModel;
use Google_client;
use CodeIgniter\Session\Session;
use Myth\Auth\Config\Auth as AuthConfig;

class Login extends BaseController
{
    protected $googleClient;
    protected $users;

    protected $auth;

    /**
     * @var AuthConfig
     */
    protected $config;

    /**
     * @var Session
     */
    protected $session;

    public function __construct()
    {
        session();

        $this->users = new AccountModel();
        $this->googleClient = new Google_Client();

        $this->session = service('session');
        $this->config = config('Auth');
        $this->auth = service('authentication');

        $this->googleClient->setClientId('392583878097-0qcl7pq6gls21h8vgr4tr468id64p6n8.apps.googleusercontent.com');
        $this->googleClient->setClientSecret('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');
        $this->googleClient->setRedirectUri(base_url('.auth/login/google/callback'));
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');
    }

    public function index()
    {
        // $data['link'] = $this->googleClient->createAuthUrl();
        $data = [
            'title' => 'Login',
            'config' => $this->config,
            'link' => $this->googleClient->createAuthUrl(),
        ];
        return view('login/index', $data);
    }

    // public function callback()
    // {
    //     $token = $this->googleClient->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
    //     if (!isset($token['error'])) {
    //         $this->googleClient->setAccessToken($token['access_token']);
    //         $googleService = new \Google_Service_Oauth2($this->googleClient);
    //         $data = $googleService->userinfo->get();

    //         $nameWithoutSpace = str_replace(' ', '', $data->name);
    //         // Data login untuk disimpan ke dalam database
    //         $row = [
    //             'email' => $data->email,
    //             'username' => $nameWithoutSpace . $data->id,
    //             'fullname' => $data->name,
    //             'user_image' => $data->picture,
    //             'active' => '1',

    //         ];


    //         $requestData = [
    //             'email' => $data->email,
    //         ];

    //         $checkExistingData = $this->users->checkIfDataExists($requestData);
    //         // $emailaccount = $nameWithoutSpace . $data->id;
    //         $emailaccount = $data->email;

    //         $findId = $this->users->get_id_profil($emailaccount)->getRowArray();
    //         // $password_hash = $findId['password_hash'];
    //         $currentDateTime = date("Y-m-d H:i:s");
    //         if ($checkExistingData && $findId['password_hash'] == null) {

    //             $id = $findId['id'];
    //             $dataaccount = [
    //                 'email' => $data->email,
    //                 'username' => $nameWithoutSpace . $data->id,
    //                 'fullname' => $data->name,
    //                 // 'user_image' => $data->picture,
    //                 'updated_at' => $currentDateTime,

    //             ];
    //             $updateRole = $this->users->update_account_users($id, $dataaccount);

    //             $ipAddress = $this->request->getIPAddress();

    //             // Data login untuk disimpan ke dalam database
    //             $dataLogins = [
    //                 'ip_address' => $ipAddress,
    //                 'email'      => $data->email,
    //                 'user_id' => $id,
    //                 'date' => date('Y-m-d H:i:s'),
    //                 'success'   => 1,
    //             ];
    //             $updateLogins = $this->users->addUserToAuthLogins($id, $dataLogins);

    //             if ($updateLogins) {

    //                 // session()->set('LoggedUserData', $row);
    //                 // var_dump(session()->getFlashdata('LoggedUserData'));
    //                 // Redirect ke halaman utama
    //                 // session()->set($row);
    //                 $findId = $this->users->get_profil($id)->getRowArray();

    //                 $this->session->set('LoggedUserData', $findId);

    //                 return redirect()->to(site_url('/'));
    //                 // return view('login/berhasil');
    //             }
    //         } else if ($checkExistingData && $findId['password_hash'] != null) {
    //             return redirect()->to(site_url('/failedlogin'));
    //         } else {

    //             $saveNewAccount = $this->users->save($row);

    //             $emailaccount = $data->email;;
    //             if ($saveNewAccount) {
    //                 $findId = $this->users->get_id_profil($emailaccount)->getRowArray();
    //                 $id = $findId['id'];
    //                 $groupId = 2;
    //                 // $data = [
    //                 //     'group_id' => 2,
    //                 //     'user_id' => $id,
    //                 // ];
    //                 if ($findId) {
    //                     // $updateRole = $this->users->update_role_api($id, $data);
    //                     $updateRole = $this->users->addUserToGroup($id, $groupId);

    //                     if ($updateRole) {

    //                         // return view('login/berhasil');
    //                         // session()->set($row);
    //                         // return redirect()->to(site_url('/web'));

    //                         $findId = $this->users->get_profil($id)->getRowArray();

    //                         $this->session->set('LoggedUserData', $findId);

    //                         return redirect()->to(site_url('/'));
    //                     }
    //                 }
    //             }
    //         }


    //         // session()->set($row);
    //         // return redirect()->to(site_url('/'));
    //         // var_dump($row);
    //     }
    // }

    public function callback()
{
    try {
        // Ambil kode otorisasi dari permintaan
        $code = $this->request->getVar('code');
        
        // Pastikan kode otorisasi tersedia
        if ($code) {
            // Dapatkan token akses menggunakan kode otorisasi
            $token = $this->googleClient->fetchAccessTokenWithAuthCode($code);
            
            // Pastikan token akses diperoleh dengan sukses
            if (!isset($token['error'])) {
                // Setel token akses ke klien Google
                $this->googleClient->setAccessToken($token['access_token']);
                
                // Dapatkan data pengguna dari layanan Google OAuth2
                $googleService = new \Google_Service_Oauth2($this->googleClient);
                $data = $googleService->userinfo->get();
                
                // Proses data pengguna untuk disimpan ke dalam database
                $nameWithoutSpace = str_replace(' ', '', $data->name);
                $row = [
                    'email' => $data->email,
                    'username' => $nameWithoutSpace . $data->id,
                    'fullname' => $data->name,
                    'user_image' => $data->picture,
                    'active' => '1',
                ];

                // Cek apakah data pengguna sudah ada di database
                $requestData = ['email' => $data->email];
                $checkExistingData = $this->users->checkIfDataExists($requestData);
                $emailaccount = $data->email;

                // Dapatkan id profil jika data pengguna sudah ada
                $findId = $this->users->get_id_profil($emailaccount)->getRowArray();
                $currentDateTime = date("Y-m-d H:i:s");

                if ($checkExistingData && $findId['password_hash'] == null) {
                    // Update data pengguna jika belum memiliki password
                    $id = $findId['id'];
                    $dataaccount = [
                        'email' => $data->email,
                        'username' => $nameWithoutSpace . $data->id,
                        'fullname' => $data->name,
                        'updated_at' => $currentDateTime,
                    ];
                    $updateRole = $this->users->update_account_users($id, $dataaccount);

                    // Tambahkan data login ke dalam log auth
                    $ipAddress = $this->request->getIPAddress();
                    $dataLogins = [
                        'ip_address' => $ipAddress,
                        'email'      => $data->email,
                        'user_id' => $id,
                        'date' => date('Y-m-d H:i:s'),
                        'success'   => 1,
                    ];
                    $updateLogins = $this->users->addUserToAuthLogins($id, $dataLogins);

                    if ($updateLogins) {
                        // Set session pengguna dan redirect ke halaman utama
                        $findId = $this->users->get_profil($id)->getRowArray();
                        $this->session->set('LoggedUserData', $findId);
                        return redirect()->to(site_url('/'));
                    }
                } else if ($checkExistingData && $findId['password_hash'] != null) {
                    // Handle jika data pengguna sudah ada dengan password
                    return redirect()->to(site_url('/failedlogin'));
                } else {
                    // Simpan data pengguna baru jika belum ada
                    $saveNewAccount = $this->users->save($row);

                    if ($saveNewAccount) {
                        // Dapatkan id profil pengguna baru
                        $findId = $this->users->get_id_profil($emailaccount)->getRowArray();
                        $id = $findId['id'];
                        $groupId = 2;

                        if ($findId) {
                            // Tambahkan pengguna ke dalam grup
                            $updateRole = $this->users->addUserToGroup($id, $groupId);

                            if ($updateRole) {
                                // Set session pengguna dan redirect ke halaman utama
                                $findId = $this->users->get_profil($id)->getRowArray();
                                $this->session->set('LoggedUserData', $findId);
                                return redirect()->to(site_url('/'));
                            }
                        }
                    }
                }
            } else {
                // Tangani jika terjadi galat saat mengambil token akses
                $errorMessage = $token['error_description'] ?? 'Unknown error';
                return redirect()->to(site_url('/error?message=' . urlencode($errorMessage)));
            }
        } else {
            // Tangani jika kode otorisasi tidak tersedia
            return redirect()->to(site_url('/error?message=Authorization code is missing'));
        }
    } catch (\Exception $e) {
        // Tangani galat umum yang terjadi
        return redirect()->to(site_url('/error?message=' . urlencode($e->getMessage())));
    }
}

}
