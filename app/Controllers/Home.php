<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\servicemodel;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Home extends BaseController
{



public function log_activity()
{
    $model = new servicemodel();
    $data['logs'] = $model->getLogs();
    $where = array('id_setting' => '1');
    $data['darren2'] = $model->getwhere('setting', $where);
    $id_user = session()->get('id');
    $model = new servicemodel;
    $activityLog = [
        'id_user' => $id_user,
        'activity' => 'Masuk ke Log Activity',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
    echo view('header',$data);
    echo view('menu', $data);
    echo view('log_activity', $data);
    echo view('footer');
}


    public function dashboard()
    {
        $model = new servicemodel;
        $id_user = session()->get('id');
        $user_level = session()->get('level');
    
        if ($user_level > '') {
    
            // Check and update service status within the dashboard function
            $today = date('Y-m-d');
    
            // Find orders with a service date matching today and status is still Pending
            $orders = $model->where('tanggal_permintaan', $today)
                            ->where('status', 'Pending')
                            ->findAll();
    
            if ($orders === false) {
                // Handle query error
                log_message('error', 'Failed to retrieve orders with pending status.');
            } else {
                foreach ($orders as $order) {
                    // Log the current order being updated
                    log_message('info', 'Updating order ID: ' . $order['id_pesanan']);
    
                    // Update the status to 'On-Going'
                    $updateStatus = $model->updateOrderStatus($order['id_pesanan'], 'On-Going');
    
                    if ($updateStatus) {
                        log_message('info', 'Order ID: ' . $order['id_pesanan'] . ' status updated to On-Going.');
                    } else {
                        log_message('error', 'Failed to update order ID: ' . $order['id_pesanan']);
                    }
                }
            }
    
            if ($user_level == 'Admin') {
                $data['darren'] = $model->getAllOrders(); 
                $data['technicians'] = $model->getActiveTechnicians(); 
            } else {
                $data['darren'] = $model->getOrdersByUser($id_user); 
                $data['technicians'] = $model->getActiveTechnicians(); 
            }
    
            $data['totalOrders'] = $model->getTotalOrders();
            $data['totalOngoingOrders'] = $model->getTotalOngoingOrders();
            $data['totalPendingOrders'] = $model->getTotalPendingOrders();
            $data['username'] = session()->get('username');
            $data['hasOrders'] = !empty($data['darren']);
    
            $data['darren'] = $model->getRecentOrders();
            $where = ['id_setting' => '1'];
            $data['darren2'] = $model->getwhere('setting', $where);
            $id_user = session()->get('id');
            $model = new servicemodel;
            $activityLog = [
                'id_user' => $id_user,
                'activity' => 'Masuk ke Dashboard',
                'time' => date('Y-m-d H:i:s')
            ];
            $model->logActivity($activityLog);
            echo view('header', $data);
            echo view('menu', $data);
            echo view('dashboard', $data); // Pass data to view
            echo view('footer');
        } else {
            return redirect()->to('home/login');
        }
    }
    




public function getTechnicianName()
{
    $model = new servicemodel;
    $id_teknisi = $this->request->getPost('id_teknisi');

    // Ambil nama teknisi dari model
    $nama_teknisi = $model->getTechnicianNameById($id_teknisi);

    // Kirimkan sebagai respons JSON
    return $this->response->setJSON(['nama_teknisi' => $nama_teknisi]);
}


public function hapusp($id)
{
    $model = new servicemodel();
    $id_user = session()->get('id');
    $data = [
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => $id_user
    ];

    // Lakukan soft delete dengan mengupdate kolom 'delete'
    $model->edit('pesanan', $data, ['id_pesanan' => $id]);

    // Log aktivitas pengguna
    $id_user = session()->get('id');
    $activityLog = [
        'id_user' => $id_user,
        'activity' => 'Hapus Pesanan',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);

    // Redirect ke halaman transaksi
    return redirect()->to('home/dashboard');
}


	public function login()
	{
		$model = new servicemodel();
		$where = array('id_setting' => '1');
			$data['darren2'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('login',$data);
		echo view('footer');
	}


    public function aksi_login()
    {
        $name = $this->request->getPost('username');
        $pw = $this->request->getPost('password');
        $captchaResponse = $this->request->getPost('g-recaptcha-response');
        $backupCaptcha = $this->request->getPost('backup_captcha');
        
        $secretKey = '6LdFhCAqAAAAAM1ktawzN-e2ebDnMnUQgne7cy53'; // Ganti dengan secret key Anda yang sebenarnya
        $recaptchaSuccess = false;
    
        $captchaModel = new servicemodel();
    
        if ($this->isInternetAvailable()) {
            // Verifikasi reCAPTCHA
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captchaResponse");
            $responseKeys = json_decode($response, true);
            $recaptchaSuccess = $responseKeys["success"];
        }
        
        if ($recaptchaSuccess) {
            
            $where = [
                'username' => $name,
                'password' => $pw,
            ];
    
            $model = new servicemodel();
            $check = $model->getWhere('user', $where);
    
            if ($check) {
                session()->set('username', $check->username);
                session()->set('id', $check->id_user);
                session()->set('level', $check->level);
    
                $activityLog = [
                    'id_user' => $check->id_user,
                    'activity' => 'Login',
                    'time' => date('Y-m-d H:i:s')
                ];
                $model->logActivity($activityLog);
    
                return redirect()->to('home/dashboard');
            } else {
                return redirect()->to('home/login')->with('error', 'Invalid username or password.');
            }
        } else {
            // Validasi CAPTCHA offline
            $storedCaptcha = session()->get('captcha_code'); // Retrieve stored CAPTCHA from session
            
            // Debugging: Tampilkan nilai CAPTCHA yang dihasilkan dan yang diinput oleh user
            error_log('Stored CAPTCHA: ' . $storedCaptcha);
            error_log('User Input CAPTCHA: ' . $backupCaptcha);
    
            if ($storedCaptcha !== null) {
                if ($storedCaptcha === $backupCaptcha) {
                    // CAPTCHA valid
                    $where = [
                        'username' => $name,
                        'password' => $pw,
                    ];
    
                    $model = new servicemodel();
                    $check = $model->getWhere('user', $where);
    
                    if ($check) {
                        session()->set('username', $check->username);
                        session()->set('id', $check->id_user);
                        session()->set('level', $check->level);
    
                        $activityLog = [
                            'id_user' => $check->id_user,
                            'activity' => 'Login',
                            'time' => date('Y-m-d H:i:s')
                        ];
                        $model->logActivity($activityLog);
    
                        return redirect()->to('home/dashboard');
                    } else {
                        return redirect()->to('home/login')->with('error', 'Invalid username or password.');
                    }
                } else {
                    // CAPTCHA tidak valid
                    return redirect()->to('home/login')->with('error', 'Invalid CAPTCHA.');
                }
            } else {
                return redirect()->to('home/login')->with('error', 'CAPTCHA session is not set.');
            }
        }
    }
    
    
    
    
    // Helper function to check internet connection
    private function isInternetAvailable()
    {
        $connected = @fsockopen("www.google.com", 80); 
        if ($connected){
            fclose($connected);
            return true;
        }
        return false;
    }

    public function generateCaptcha()
    {
        $code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
    
        // Store the CAPTCHA code in the session
        session()->set('captcha_code', $code);
    
        // Generate the image
        $image = imagecreatetruecolor(120, 40);
        $bgColor = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);
    
        imagefilledrectangle($image, 0, 0, 120, 40, $bgColor);
        imagestring($image, 5, 10, 10, $code, $textColor);
    
        // Set the content type header - in this case image/png
        header('Content-Type: image/png');
    
        // Output the image
        imagepng($image);
    
        // Free up memory
        imagedestroy($image);
    }
    
    
    
public function logout()
{
    $session = session();
    $id_user = session()->get('id');
    $model = new servicemodel;
    $activityLog = [
        'id_user' => $id_user,
        'activity' => 'Logout',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
  

    $session->destroy();
    return redirect()->to('home/login');
}



// public function aksi_login()
// 	{
// 	$a = $this->request->getPost('username');
// 	$b = $this->request->getPost('password');
// 	$where = array(
// 		'username'=>$a,
// 		'password'=>$b
	
// 	);
	
// 	$model = new servicemodel;
// 	$cek = $model->getWhere('user', $where);

// 	if($cek>0){
// 		session()->set('username',$cek->username);
// 		session()->set('id',$cek->id_user);
// 		session()->set('level',$cek->level);
// 		return redirect()->to('home/dashboard');
// 	}else{
// 		return redirect()->to('home/login');
// 	}
// 	}





// public function register()
// 	{
// 		$model = new servicemodel;
// 	$data['darren'] = $model->tampil('user');
// 		echo view('header');
// 		echo view('register');
// 		echo view('footer');
// 	}

// 	public function aksiregister()
// {
// 	$username = $this->request->getPost('username');
// 	$password = $this->request->getPost('password');
// 	$email = $this->request->getPost('email');
	
		
// 	$tabel=array(
// 		'Username'=>$username,
// 		'Password'=>$password,
// 		'Email'=>$email,
// 		'Level'=>'Admin'

// 	);

// 	$model=new servicemodel;
// 	$model->tambah('user', $tabel);
// 	return redirect()->to('home/login');

// }


public function pesan()
	{
		if(session()->get('level')>''){
			$model=new servicemodel;
		$data['darren'] = $model->tampil('pesanan');

		$where = array('id_setting' => '1');
		$data['darren2'] = $model->getwhere('setting', $where);

        
		echo view('header', $data);
		echo view('pesan');
		echo view('footer');
	}else{
		return redirect()->to('home/login');
	}
	}

    public function aksi_pesan()
    {
        $model = new servicemodel;
        session()->start();
    
        $a = $this->request->getPost('nama');
        $b = $this->request->getPost('nomor');
        $c = $this->request->getPost('alamat');
        $d = $this->request->getPost('merek');
        $e = $this->request->getPost('mesin');
        $f = $this->request->getPost('kapasitas');
        $g = $this->request->getPost('deskripsi');
        $h = $this->request->getPost('tanggal_service'); 
        $id_user = session()->get('id');

        // Jika tanggal_service kosong, set menjadi NULL
    if (empty($h)) {
        $h = null;
    }

        $tabel = array(
            'nama_pemilik' => $a,
            'no_telp' => $b,
            'alamat' => $c,
            'merk_genset' => $d,
            'merk_mesin' => $e,
            'kapasitas_genset' => $f,
            'deskripsi_masalah' => $g,
            'tanggal_permintaan' => $h, 
            'status' => 'Pending',
            'sistem_pesanan' => '-',
            'created_at' => date('Y-m-d H:i:s'), 
            'created_by' => $id_user
        );
        $id_user = session()->get('id');
        $model = new servicemodel;
        $activityLog = [
            'id_user' => $id_user,
            'activity' => 'Input Pesanan',
            'time' => date('Y-m-d H:i:s')
        ];
        $model->logActivity($activityLog);
        $model->tambah('pesanan', $tabel);
        return redirect()->to('home/dashboard');
    }
    

	public function teknisi()
	{
		if (session()->get('level') == 'Pelanggan' || session()->get('level') == 'Admin') {
			$model = new servicemodel;
			$data['darren'] = $model->tampil_urut('teknisi');
			
			$where = array('id_setting' => '1');
			$data['darren2'] = $model->getwhere('setting', $where);

            $id_user = session()->get('id');
            $model = new servicemodel;
            $activityLog = [
                'id_user' => $id_user,
                'activity' => 'Masuk Menu Teknisi',
                'time' => date('Y-m-d H:i:s')
            ];
            $model->logActivity($activityLog);
			echo view('header',$data);
			echo view('menu',$data);
			echo view('teknisi', $data);
			echo view('footer');
		} else {
			return redirect()->to('home/login');
		}
	}
	public function deletet($id)
	{
        $model = new servicemodel();
        $id_user = session()->get('id');

        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => $id_user
        ];
    
        // Lakukan soft delete dengan mengupdate kolom 'delete'
        $model->edit('teknisi', $data, ['id_teknisi' => $id]);
    
        // Log aktivitas pengguna
        $id_user = session()->get('id');
        $activityLog = [
            'id_user' => $id_user,
            'activity' => 'Hapus Teknisi',
            'time' => date('Y-m-d H:i:s')
        ];
        $model->logActivity($activityLog);
    
        // Redirect ke halaman transaksi
        return redirect()->to('home/teknisi');
	}

	public function eteknisi($id)
	{
		$model = new servicemodel();
		$where = array('id_teknisi' => $id);
		$data['user'] = $model->getWhere('teknisi', $where);

		$where = array('id_setting' => '1');
		$data['darren2'] = $model->getwhere('setting', $where);
		echo view('header', $data);
		echo view('eteknisi', $data);
		echo view('footer');
	}

    public function aksieteknisi()
    {
        $model = new servicemodel();
        
        $a = $this->request->getPost('nama');
        $b = $this->request->getPost('notelp');
        $c = $this->request->getPost('email');
        $d = $this->request->getPost('status');
        $id = $this->request->getPost('id');
        $id_user = session()->get('id');
    
        // Cek apakah ada data dengan id_produk yang sama di produk_backup
        $backupWhere = ['id_teknisi' => $id];
        $existingBackup = $model->getWhere('teknisi_backup', $backupWhere);
    
        if ($existingBackup) {
            // Hapus data lama di produk_backup jika ada
            $model->hapus('teknisi_backup', $backupWhere);
        }
    
        // Ambil data produk lama berdasarkan id_produk
        $produkLama = $model->getProductById($id);
        
        // Simpan data produk lama ke tabel produk_backup
        $backupData = (array) $produkLama;  // Ubah objek menjadi array
        $model->tambah('teknisi_backup', $backupData);
    
        // Menyiapkan data yang akan di-update
        $isi = array(
            'nama_teknisi' => $a,
            'no_telp' => $b,
            'email' => $c,
            'status' => $d,
            'updated_at' => date('Y-m-d H:i:s'), 
            'updated_by' => $id_user
        );

    
        // Update data produk di database
        $where = array('id_teknisi' => $id);
        $model->edit('teknisi', $isi, $where);
    
        return redirect()->to('home/teknisi');
    }
    
    
	public function tteknisi()
	{
		$model = new servicemodel();
		$data['user'] = $model->tampil('teknisi');

		$where = array('id_setting' => '1');
		$data['darren2'] = $model->getwhere('setting', $where);

		echo view('header', $data);
		echo view('tteknisi', $data);
		echo view('footer');
	}
	public function aksitteknisi()
	{
		$nama = $this->request->getPost('nama');
		$jenis = $this->request->getPost('notelp');
		$harga = $this->request->getPost('email');
        $id_user = session()->get('id');
		$tabel = array(
			'nama_teknisi' => $nama,
			'no_telp' => $jenis,
			'email' => $harga,
			'status' => 'Tidak Aktif',
            'created_at' => date('Y-m-d H:i:s'), 
            'created_by' => $id_user
		);
        $id_user = session()->get('id');
        $model = new servicemodel;
        $activityLog = [
            'id_user' => $id_user,
            'activity' => 'Tambah Teknisi',
            'time' => date('Y-m-d H:i:s')
        ];
        $model->logActivity($activityLog);
		$model = new servicemodel;
		$model->tambah('teknisi', $tabel);
		return redirect()->to('home/teknisi');
	}

    public function transaksi()
{
    if (session()->get('level') > '') {
        $model = new servicemodel();

        // Determine the current page and items per page
        $page = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1;
        $perPage = 8;

        // Calculate the offset for the query
        $offset = ($page - 1) * $perPage;

        // Get the total number of rows (for pagination)
        $totalRows = $model->db->table('transaksi')->countAllResults();

        // Fetch the data with pagination
        $data['darren'] = $model->tampil2('transaksi', $perPage, $offset);

        // Calculate total pages
        $data['totalPages'] = ceil($totalRows / $perPage);
        $data['currentPage'] = $page;

        // Calculate the total amount for the current page
        $totalAmount = 0;
        foreach ($data['darren'] as $transaction) {
            $totalAmount += $transaction['harga'];
        }
        $data['totalAmount'] = $totalAmount;

        // Fetch other necessary data
        $where = array('id_setting' => '1');
        $data['darren2'] = $model->getwhere('setting', $where);

        // Log user activity
        $id_user = session()->get('id');
        $activityLog = [
            'id_user' => $id_user,
            'activity' => 'Masuk Menu Transaksi',
            'time' => date('Y-m-d H:i:s')
        ];
        $model->logActivity($activityLog);

        echo view('header', $data);
        echo view('menu', $data);
        echo view('transaksi', $data);
        echo view('footer');
    } else {
        return redirect()->to('home/login');
    }
}




    public function hapust($id)
    {
        $model = new servicemodel();
        $id_user = session()->get('id');
        $data = [
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => $id_user
        ];
    
        // Lakukan soft delete dengan mengupdate kolom 'delete'
        $model->edit('transaksi', $data, ['id_transaksi' => $id]);
    
        // Log aktivitas pengguna
        $id_user = session()->get('id');
        $activityLog = [
            'id_user' => $id_user,
            'activity' => 'Hapus Transaksi',
            'time' => date('Y-m-d H:i:s')
        ];
        $model->logActivity($activityLog);
    
        // Redirect ke halaman transaksi
        return redirect()->to('home/transaksi');
    }
    

	// public function user()
	// {
	// 	if(session()->get('level') == 'Admin'){
	// 		$model=new servicemodel;
	// 	$data['darren'] = $model->tampil('user');

	// 	$where = array('id_setting' => '1');
	// 	$data['darren2'] = $model->getwhere('setting', $where);
	// 	echo view('header', $data);
	// 	echo view('menu', $data);
	// 	echo view('user',$data);
	// 	echo view('footer');
	// }else{
	// 	return redirect()->to('home/error404');   
	// }
	// }

	public function setting()
	{
		if (session()->get('level') == 'Admin') {
			$model = new servicemodel();
			$where = array('id_setting' => 1);
			$data['darren2'] = $model->getwhere('setting', $where);
            $id_user = session()->get('id');
            $model = new servicemodel;
            $activityLog = [
                'id_user' => $id_user,
                'activity' => 'Masuk Menu Setting',
                'time' => date('Y-m-d H:i:s')
            ];
            $model->logActivity($activityLog);
			echo view('header', $data);
			echo view('menu', $data);
			echo view('setting', $data);
			echo view('footer');
		} else {
			return redirect()->to('home/error404');
		}
	}
	public function editsetting()
{
    $model = new servicemodel();
    $a = $this->request->getPost('namaWeb');
    $icon = $this->request->getFile('iconTab');
    $dash = $this->request->getFile('logoDash');
    $login = $this->request->getFile('logoLogin');

    // Debugging: Log received data
    log_message('debug', 'Website Name: ' . $a);
    log_message('debug', 'Tab Icon: ' . ($icon ? $icon->getName() : 'None'));
    log_message('debug', 'Dashboard Icon: ' . ($dash ? $dash->getName() : 'None'));
    log_message('debug', 'Login Icon: ' . ($login ? $login->getName() : 'None'));

    $data = ['nama_website' => $a];

    if ($icon && $icon->isValid() && !$icon->hasMoved()) {
        $icon->move(ROOTPATH . 'public/img/', $icon->getName());
        $data['icon_logo'] = $icon->getName();
    }

    if ($dash && $dash->isValid() && !$dash->hasMoved()) {
        $dash->move(ROOTPATH . 'public/img/', $dash->getName());
        $data['logo_dashboard'] = $dash->getName();
    }

    if ($login && $login->isValid() && !$login->hasMoved()) {
        $login->move(ROOTPATH . 'public/img/', $login->getName());
        $data['logo_login'] = $login->getName();
    }

    $where = ['id_setting' => 1];
    
    $model->edit2('setting', $data, $where);
    $id_user = session()->get('id');
    $model = new servicemodel;
    $activityLog = [
        'id_user' => $id_user,
        'activity' => 'Edit Setting',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);

    return redirect()->to('home/setting');
}


public function laporan()
{
    if (session()->get('level') == 'Admin') {
        $model = new servicemodel();
        $tanggal1 = $this->request->getPost('tanggal1');
        $tanggal2 = $this->request->getPost('tanggal2');

        if ($tanggal1 && $tanggal2) {
            $data['filteredTransactions'] = $model->getFilteredTransactions($tanggal1, $tanggal2);

            if (empty($data['filteredTransactions'])) {
                $data['noDataMessage'] = 'No transactions found for the selected date range.';
            }
        } else {
            $data['filteredTransactions'] = []; // Empty array if no filter is applied
        }

        $where = ['id_setting' => 1];
        $data['darren2'] = $model->getwhere('setting', $where);

        $id_user = session()->get('id');
        $activityLog = [
            'id_user' => $id_user,
            'activity' => 'Masuk Menu Laporan',
            'time' => date('Y-m-d H:i:s')
        ];
        $model->logActivity($activityLog);

        echo view('header', $data);
        echo view('menu', $data);
        echo view('laporan', $data);
        echo view('footer');
    } else {
        return redirect()->to('home/error404');
    }
}




	public function error404()
	{
			$model=new servicemodel;
			$where = array('id_setting' => 1);
			$data['darren2'] = $model->getwhere('setting', $where);
		echo view('header', $data);
		echo view('menu'), $data;
		echo view('404');
		echo view('footer');
	}
	
	public function editdetail()
{   
    $model = new servicemodel; 

    $id = $this->request->getPost('orderId'); // Ambil id dari form

    $sistemPesanan = $this->request->getPost('sistem');
    $status = $this->request->getPost('status');
    $teknisi = $this->request->getPost('teknisi');
    $estimasiWaktu = $this->request->getPost('estimasi_waktu') ?: '00:00:00';
    $id_user = session()->get('id');

    $where = array('id_pesanan' => $id);

    $isi = array(
        'sistem_pesanan' => $sistemPesanan,
        'status' => $status,
        'id_teknisi' => $teknisi,
        'estimasi_waktu' => $estimasiWaktu,
        'updated_at' => date('Y-m-d H:i:s'), // Set created_at to current date and time
        'updated_by' => $id_user
    );
    $id_user = session()->get('id');
    $model = new servicemodel;
    $activityLog = [
        'id_user' => $id_user,
        'activity' => 'Edit Detail Pesanan',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
    $model->edit2('pesanan', $isi, $where);

    if ($status == 'Done') {
        // Get the id_user and nama from pesanan
        $orderData = $model->getOrderById($id);
        $no_transaksi = $model->generateNoTransaksi();
        $id_user = session()->get('id');
        $transaksiData = [
            'nama_pemilik' => $orderData['nama_pemilik'],
            'no_transaksi' => $no_transaksi,
            'tanggal' => date('Y-m-d'),
            'harga' => 0,
            'status' => 'Belum Bayar',
            'jenis_service' => '(Belum ditentukan)',
            'id_teknisi' => $orderData['id_teknisi'],
            'created_at' => date('Y-m-d H:i:s'), // Set created_at to current date and time
         'created_by' => $id_user
        ];

        $model->insertTransaksi($transaksiData);

        $model->deletePesanan($id);
        $id_user = session()->get('id');
        $model = new servicemodel;
        $activityLog = [
            'id_user' => $id_user,
            'activity' => 'Menyelesaikan Pesanan',
            'time' => date('Y-m-d H:i:s')
        ];
        $model->logActivity($activityLog);
    }

    return redirect()->to('home/dashboard');
}


public function editTransaksi()
{
    $id = $this->request->getPost('id_transaksi');
    $jenisService = $this->request->getPost('jenis_service');
    $harga = $this->request->getPost('harga');
    $id_user = session()->get('id');

    $model = new servicemodel;
	if ($harga <= 0) {
        // Set flashdata error message and redirect back
        session()->setFlashdata('error', 'Harga harus lebih dari 0');
        return redirect()->back()->withInput();
    }
    $data = [
        'jenis_service' => $jenisService,
        'harga' => $harga,
        'updated_at' => date('Y-m-d H:i:s'), // Set created_at to current date and time
        'updated_by' => $id_user
    ];

    $where = ['id_transaksi' => $id];
    $model->edit2('transaksi', $data, $where);
    $id_user = session()->get('id');
    $model = new servicemodel;
    $activityLog = [
        'id_user' => $id_user,
        'activity' => 'Edit Detail Transaksi',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
    return redirect()->to('home/transaksi');
}

public function processPayment()
{
    $model = new servicemodel;

    $idTransaksi = $this->request->getPost('id_transaksi');
    $bayar = $this->request->getPost('bayar');
    $harga = $this->request->getPost('harga');
    $kembalian = $bayar - $harga;

    if ($kembalian >= 0) {
        $data = [
            'status' => 'Sudah Bayar',
			'bayaran' => $bayar,
			'kembalian' => $kembalian,
        ];

        $model->edit2('transaksi', $data, ['id_transaksi' => $idTransaksi]);
        $id_user = session()->get('id');
        $model = new servicemodel;
        $activityLog = [
            'id_user' => $id_user,
            'activity' => 'Pembayaran Transaksi',
            'time' => date('Y-m-d H:i:s')
        ];
        $model->logActivity($activityLog);
        return redirect()->to('home/transaksi')->with('message', 'Pembayaran berhasil diproses');
    } else {
        return redirect()->to('home/transaksi')->with('error', 'Jumlah bayar tidak cukup');
    }
}


public function printNota($id_transaksi)
{
    if (session()->get('level') > '') {
        $model = new ServiceModel();
        $where = ['id_transaksi' => $id_transaksi];

        // Ambil data transaksi
        $transaction = $model->getWhere('transaksi', $where);
        
        // Ambil data teknisi berdasarkan id_teknisi dari transaksi
        $teknisiWhere = ['id_teknisi' => $transaction->id_teknisi];
        $teknisi = $model->getWhere('teknisi', $teknisiWhere);
        
        // Siapkan data untuk view
        $data['transaction'] = $transaction;
        $data['teknisi'] = $teknisi;
        $id_user = session()->get('id');
        $model = new servicemodel;
        $activityLog = [
            'id_user' => $id_user,
            'activity' => 'Print Nota',
            'time' => date('Y-m-d H:i:s')
        ];
        $model->logActivity($activityLog);
        return view('nota', $data);
    } else {
        return redirect()->to('home/login');
    }
}

public function printpdf()
{
    // Ensure the session level is checked correctly
    if (session()->get('level')) {
        // Retrieve 'tanggal_mulai' and 'tanggal_akhir' from POST request
        $tanggal_mulai = $this->request->getPost('tanggal1');
        $tanggal_akhir = $this->request->getPost('tanggal2');
        
        // Ensure both 'tanggal_mulai' and 'tanggal_akhir' are provided
        if (empty($tanggal_mulai) || empty($tanggal_akhir)) {
            // Handle the error, perhaps by redirecting back with an error message
            return redirect()->back()->with('error', 'Both start and end dates are required');
        }
        
        // Load the model
        $model = new ServiceModel();
        
        // Retrieve data with the provided method
        $data = [
            'satu' => $model->betweenjoin1(
                'transaksi', 'teknisi',
                'transaksi.id_teknisi = teknisi.id_teknisi',
                $tanggal_mulai,
                $tanggal_akhir
            ),
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
        ];
        
        // Load the view with the data
        $id_user = session()->get('id');
        $model = new servicemodel;
        $activityLog = [
            'id_user' => $id_user,
            'activity' => 'Print PDF',
            'time' => date('Y-m-d H:i:s')
        ];
        $model->logActivity($activityLog);
        return view('printpdf', $data);
    } else {
        // Redirect to login if the user is not authenticated
        return redirect()->to('home/login');
    }
}

public function printexcel()
{
    // Ensure the session level is checked correctly
    if (session()->get('level')) {
        // Retrieve 'tanggal_mulai' and 'tanggal_akhir' from POST request
        $tanggal_mulai = $this->request->getPost('tanggal1');
        $tanggal_akhir = $this->request->getPost('tanggal2');
        
        // Ensure both 'tanggal_mulai' and 'tanggal_akhir' are provided
        if (empty($tanggal_mulai) || empty($tanggal_akhir)) {
            // Handle the error, perhaps by redirecting back with an error message
            return redirect()->back()->with('error', 'Both start and end dates are required');
        }
        
        // Load the model
        $model = new ServiceModel();
        
        // Retrieve data with the provided method
        $data = [
            'satu' => $model->betweenjoin1(
                'transaksi', 'teknisi',
                'transaksi.id_teknisi = teknisi.id_teknisi',
                $tanggal_mulai,
                $tanggal_akhir
            ),
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
        ];
        
        // Load the view with the data
        $id_user = session()->get('id');
        $model = new servicemodel;
        $activityLog = [
            'id_user' => $id_user,
            'activity' => 'Print Excel',
            'time' => date('Y-m-d H:i:s')
        ];
        $model->logActivity($activityLog);
        return view('printexcel', $data);
    } else {
        // Redirect to login if the user is not authenticated
        return redirect()->to('home/login');
    }
}

public function printwindows()
{
    if (session()->get('level')) {
        $tanggal_mulai = $this->request->getPost('tanggal1');
        $tanggal_akhir = $this->request->getPost('tanggal2');
        
        if (empty($tanggal_mulai) || empty($tanggal_akhir)) {
            return redirect()->back()->with('error', 'Both start and end dates are required');
        }
        
        $model = new ServiceModel();
        
        $data = [
            'satu' => $model->betweenjoin1(
                'transaksi', 'teknisi',
                'transaksi.id_teknisi = teknisi.id_teknisi',
                $tanggal_mulai,
                $tanggal_akhir
            ),
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
        ];
        
        $id_user = session()->get('id');
        $model = new servicemodel;
        $activityLog = [
            'id_user' => $id_user,
            'activity' => 'Print Windows    ',
            'time' => date('Y-m-d H:i:s')
        ];
        $model->logActivity($activityLog);
        return view('printwindows', $data);
    } else {
        return redirect()->to('home/login');
    }
}

public function restoret()
{
    $model = new servicemodel();
	$where = array('id_setting' => '1');
			$data['darren2'] = $model->getwhere('setting', $where);
    $data['deletedTransaksi'] = $model->query('SELECT * FROM transaksi WHERE deleted_at IS NOT NULL');

    echo view('header',$data);
    echo view('menu',$data);
    echo view('restoret', $data);
    echo view('footer');
}

public function restorep()
{
    $model = new servicemodel();
    $where = array('id_setting' => '1');
    $data['darren2'] = $model->getwhere('setting', $where);
    $data['deletedPesanan'] = $model->query('SELECT * FROM pesanan WHERE deleted_at IS NOT NULL');

    // Define the title variable
    $data['title'] = 'Restore Pesanan';

    echo view('header', $data);
    echo view('menu', $data);
    echo view('restorep', $data);
    echo view('footer');
}


public function retteknisi()
{
    $model = new servicemodel();
	$where = array('id_setting' => '1');
			$data['darren2'] = $model->getwhere('setting', $where);
    $data['deletedTeknisi'] = $model->query('SELECT * FROM teknisi WHERE deleted_at IS NOT NULL');

     // Define the title variable
     $data['title'] = 'Restore Pesanan';
     
    echo view('header',$data);
    echo view('menu',$data);
    echo view('retteknisi', $data);
    echo view('footer');
}

public function restore($id) {
    $model = new servicemodel();
    
    $data = [
        'deleted_at' => null,
        'deleted_by' => null,
      
    ];
    $id_user = session()->get('id');
    $model = new servicemodel;
    $activityLog = [
        'id_user' => $id_user,
        'activity' => 'Restore Transaksi',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
   
    $model->edit('transaksi', $data, ['id_transaksi' => $id]);

    return redirect()->to('home/restoret');
}

public function restore2($id) {
    $model = new servicemodel();
    
    $data = [
        'deleted_at' => null,
        'deleted_by' => null,
    ];
    $id_user = session()->get('id');
    $model = new servicemodel;
    $activityLog = [
        'id_user' => $id_user,
        'activity' => 'Restore Pesanan',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
   
    $model->edit('pesanan', $data, ['id_pesanan' => $id]);

    return redirect()->to('home/restorep');
}

public function restore3($id) {
    $model = new servicemodel();
    
    $data = [
        'deleted_at' => null,
        'deleted_by' => null,
    ];
    $id_user = session()->get('id');
    $model = new servicemodel;
    $activityLog = [
        'id_user' => $id_user,
        'activity' => 'Restore Teknisi Terhapus',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
   
    $model->edit('teknisi', $data, ['id_teknisi' => $id]);

    return redirect()->to('home/retteknisi');
}

public function restoreteknisi($id)
{
    $model = new servicemodel();
    
    // Ambil data dari tabel produk_backup berdasarkan id_produk
    $backupData = $model->getWhere('teknisi_backup', ['id_teknisi' => $id]);

    if ($backupData) {
        // Konversi data backup menjadi array
        $restoreData = (array) $backupData;

        // Hapus id_produk dari array karena id_produk tidak perlu di-update
        unset($restoreData['id_teknisi']);

        // Update data di tabel produk dengan data dari produk_backup
        $model->edit('teknisi', $restoreData, ['id_teknisi' => $id]);

        // Hapus data dari tabel produk_backup setelah di-restore
        $model->hapus('teknisi_backup', ['id_teknisi' => $id]);
    }

    return redirect()->to('home/teknisi');
}

public function reditteknisi()
{
    $model = new ServiceModel();

    $where = array('id_setting' => '1');
    $data['darren2'] = $model->getwhere('setting', $where);
    $data['backupData'] = $model->getBackupData();

    // Load the views and pass the data
    echo view('header',$data);
    echo view('menu',$data);
    echo view('reditteknisi', $data);
    echo view('footer');
}

public function profile()
{
    if (session()->get('level') > '') {
        $model = new servicemodel;
        
        $where = array('id_setting' => '1');
        $data['darren2'] = $model->getwhere('setting', $where);

        $where = array('id_user' => session()->get('id'));
        $data['user'] = $model->getWhere('user', $where); // Assuming it returns a single result object

        echo view('header', $data);
        echo view('menu', $data);
        echo view('profile', $data);
        echo view('footer');
    } else {
        return redirect()->to('home/login');
    }
}


public function updateProfile()
{
    if($this->request->getMethod() === 'post'){
        $model = new servicemodel();
        $id_user = session()->get('id');
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email')
        ];
        
        // Update the user in the database
        $model->updateUser($id_user, $data);
        
        // Update the session data with the new username
        session()->set('username', $data['username']);
      
        return redirect()->to('home/profile')->with('success', 'Profile updated successfully.');
    }
}

 
public function resetPassword($id) {
    $model = new servicemodel();
    
    $data = [
        'password' => 123,
      
    ];
    $id_user = session()->get('id');
    $model = new servicemodel;
    $activityLog = [
        'id_user' => $id_user,
        'activity' => 'Reset Password',
        'time' => date('Y-m-d H:i:s')
    ];
    $model->logActivity($activityLog);
   
    $model->edit('user', $data, ['id_user' => $id]);

    return redirect()->to('home/profile');
}


}