<?php

namespace App\Models;

use CodeIgniter\Model;
use TCPDF;

class servicemodel extends Model
{
    // protected $table = 'user';
    // protected $primaryKey = 'id_user';
    // protected $allowedFields = ['foto'];
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    protected $table2 = 'transaksi';
    protected $primaryKey2 = 'id_transaksi';
    protected $allowedFields = [
        'no_transaksi',
        'tanggal',
        'nama_pemilik',
        'jenis_service',
        'harga',
        'status',
        'bayaran',
        'kembalian'
    ];


    public function tampil($tabel)
    {
        return $this->db->table($tabel)
            ->get()
            ->getResult();

    }
    public function tampil_urut($table)
    {
        return $this->db->table($table)
            ->where('deleted_at', NULL)
            ->get()
            ->getResult();
    }
    public function join($tabel1, $tabel2, $on)
    {
        return $this->db->table($tabel1)
            ->join($tabel2, $on)
            ->get()
            ->getResult();

    }
    public function join1($tabel1, $tabel2, $on)
    {
        return $this->db->table($tabel1)
            ->join($tabel2, $on, 'inner')
            ->get()
            ->getResult();

    }
    public function joinWhere($tabel1, $tabel2, $on, $where)
    {
        return $this->db->table($tabel1, $where)
            ->join($tabel2, $on, 'left')
            ->get()
            ->getRow();

    }
    public function joinWherer($tabel1, $tabel2, $on, $where)
    {
        return $this->db->table($tabel1)
            ->join($tabel2, $on, 'left')
            ->getWhere($where)
            ->getRow();

    }
    public function tambah($table, $isi)
    {
        return $this->db->table($table)
            ->insert($isi);
    }
    public function upload($file)
    {
        $imageName = $file->getName();
        $file->move(ROOTPATH . 'public/img', $imageName);
    }
    public function hapus($table, $where)
    {
        return $this->db->table($table)
            ->delete($where);
    }
    public function edit($tabel, $isi, $where)
    {
        return $this->db->table($tabel)
            ->update($isi, $where);
    }
    public function updatee($tabel, $isi)
    {
        return $this->db->table($tabel)
            ->update($isi);
    }
    public function getWhere($tabel, $where)
    {
        return $this->db->table($tabel)
            ->getwhere($where)
            ->getRow();
    }

    public function joinWhererr($tabel1, $tabel2, $on, $where)
    {
        return $this->db->table($tabel1)
            ->join($tabel2, $on, 'inner')
            ->getWhere($where)
            ->getResult();

    }

    public function join3($tabel1, $tabel2, $tabel3, $on, $on2, $where)
    {
        return $this->db->table($tabel1)
            ->join($tabel2, $on, 'inner')
            ->join($tabel3, $on2, 'inner')
            ->getWhere($where)
            ->getResult();

    }

    public function join3s($tabel1, $tabel2, $tabel3, $on, $on2)
    {
        return $this->db->table($tabel1)
            ->join($tabel2, $on, 'inner')
            ->join($tabel3, $on2, 'inner')
            ->get()
            ->getResult();

    }

    public function getById($id)
    {
        return $this->db->table('teknisi_backup')
            ->where('id_teknisi', $id)
            ->get()
            ->getResult();
    }

    public function betweenjoin1($table1, $table2, $on1, $tanggalAwal, $tanggalAkhir)
    {
        // Perform the join and date filtering using BETWEEN clause
        return $this->db->table($table1)
            ->join($table2, $on1)
            ->where('transaksi.tanggal BETWEEN ' . $this->db->escape($tanggalAwal) . ' AND ' . $this->db->escape($tanggalAkhir))
            ->get()
            ->getResult();
    }



    public function getTotalOrders()
    {
        return $this->where('deleted_at', null)->countAllResults();
    }
    public function getTotalPendingOrders()
    {
        return $this->where('status', 'Pending')->countAllResults();
    }
    public function getTotalOngoingOrders()
    {
        return $this->where('status', 'On-Going')->countAllResults();
    }



    public function edit2($table2, $data, $where)
    {
        return $this->db->table($table2)->update($data, $where);
    }

    public function getOrderById($id)
    {
        return $this->where('id_pesanan', $id)->get()->getRowArray();
    }

    public function insertTransaksi($data)
    {
        $transaksiTable = $this->db->table('transaksi');
        return $transaksiTable->insert($data);
    }

    public function deletePesanan($id)
    {
        return $this->where('id_pesanan', $id)->delete();
    }

    public function getLatestTransaksi()
    {
        return $this->db->table('transaksi')->orderBy('id_transaksi', 'DESC')->limit(1)->get()->getRowArray();
    }

    public function checkTransaksiExists($no_transaksi)
    {
        return $this->db->table('transaksi')
            ->where('no_transaksi', $no_transaksi)
            ->countAllResults() > 0;
    }

    public function getOrdersByUser($id_user)
    {
        return $this->where('id_user', $id_user)->findAll();
    }

    public function getAllOrders()
    {
        return $this->findAll(); // Mengambil semua data
    }

    public function updateTransaksi($id, $data)
    {
        return $this->update($id, $data);
    }

    public function getActiveTechnicians()
    {
        return $this->db->table('teknisi')
            ->where('status', 'Aktif')
            ->get()
            ->getResult();
    }


    public function getTechnicianNameById($id_teknisi)
    {
        return $this->db->table('teknisi')
            ->select('nama_teknisi')
            ->where('id_teknisi', $id_teknisi)
            ->get()
            ->getRowArray()['nama_teknisi'];
    }

    public function getAllTechnicians()
    {
        return $this->db->table('teknisi')->get()->getResult();
    }

    public function getTransactionById($id)
    {
        return $this->where('id_transaksi', $id)->first();
    }

    public function getRecentOrders()
    {
        // Mengurutkan berdasarkan id_pesanan dalam urutan menurun dan hanya menampilkan pesanan yang belum dihapus
        return $this->where('deleted_at', null)
            ->orderBy('id_pesanan', 'DESC')
            ->findAll();
    }



    public function generateNoTransaksi($kodeToko = '100')
    {
        $today = date('ymd'); // Format tahun, bulan, tanggal
        $prefix = $kodeToko . $today;
        $query = $this->db->query("SELECT no_transaksi FROM " . $this->table2 . " WHERE no_transaksi LIKE '" . $prefix . "%' ORDER BY no_transaksi DESC LIMIT 1");

        if (!$query) {
            die("Query Error: " . $this->db->error()['message']);
        }

        $row = $query->getRow();
        if ($row) {
            $lastCode = $row->no_transaksi;
            $lastNumber = (int) substr($lastCode, -3); // Mengambil dua angka terakhir
            $newNumber = $lastNumber + 1;
            $newCode = $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        } else {
            $newCode = $prefix . '100';
        }

        return $newCode;
    }

    public function tampil2($table2, $limit, $offset)
    {
        return $this->db->table($table2)
            ->where('deleted_at', NULL)
            ->orderBy('id_transaksi', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->getResultArray();
    }


    public function updateOrderStatus($orderId, $status)
    {
        $this->db->table('pesanan')->where('id_pesanan', $orderId)->update(['status' => $status]);

    }

    public function check_service_status()
    {
        $model = new servicemodel;
        $today = date('Y-m-d');

        // Find orders with a service date matching today and status is still Pending
        $orders = $model->where('tanggal_service', $today)
            ->where('status', 'Pending')
            ->findAll();

        foreach ($orders as $order) {
            // Update the status to 'On-Going'
            $model->update($order['id_pesanan'], ['status' => 'On-Going']);
        }
    }


    public function logActivity($data)
    {
        return $this->db->table('log')->insert($data);
    }



    public function getLogs()
    {
        $builder = $this->db->table('log');  // Pastikan nama tabel benar
        $builder->join('user', 'user.id_user = log.id_user');
        $builder->select('log.*, user.username');
        $builder->orderBy('time', 'DESC');

        $query = $builder->get();

        if ($query === false) {
            // Log the error for debugging
            $error = $this->db->error();
            log_message('error', 'Query error: ' . $error['message']);
            return [];
        }

        return $query->getResultArray();
    }

    public function query($query)
    {
        return $this->db->query($query)
            ->getResult();

    }

    public function insertBackup($data)
    {
        // Cek apakah data berhasil dimasukkan
        if (!$this->db->table('teknisi_backup')->insert($data)) {
            log_message('error', 'Gagal menyimpan data ke teknisi_backup');
        }
    }


    public function getBackupData()
    {
        return $this->db->table('teknisi_backup')->get()->getResultArray();
    }

    public function getProductById($id)
    {
        return $this->db->table('teknisi')->where('id_teknisi', $id)->get()->getRow();
    }

    public function getFilteredTransactions($tanggal1, $tanggal2)
    {
        return $this->db->table('transaksi')
            ->where('deleted_at', NULL)
            ->where('tanggal >=', $tanggal1)
            ->where('tanggal <=', $tanggal2)
            ->orderBy('id_transaksi', 'DESC')
            ->get()
            ->getResult(); // Use getResult() to get objects
    }

    public function updateUser($id_user, $data)
    {
        return $this->db->table('user')->where('id_user', $id_user)->update($data);
    }


}