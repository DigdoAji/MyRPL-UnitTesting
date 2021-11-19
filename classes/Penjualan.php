<?php

spl_autoload_register(function ($className) {
    include 'classes/' . $className . '.php';
});


class Penjualan
{
    private $table = 'penjualan';

    public $id, $nama_barang, $harga_satuan, $jumlah, $tanggal_beli, $total;

    public function countTotal()
    {
        return $this->jumlah * $this->harga_satuan;
    }


    public function insert()
    {
        $sql = "INSERT INTO $this->table(id,nama_barang,harga_satuan,jumlah, tanggal_beli, total) VALUES(:id,:nama,:price,:ammount,:tanggal,:total)";
        $stmt = (new Database)->prepared($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nama', $this->nama_barang);
        $stmt->bindParam(':price', $this->harga_satuan);
        $stmt->bindParam(':ammount', $this->jumlah);
        $stmt->bindParam(':tanggal', $this->tanggal_beli);
        $total = $this->countTotal();
        $stmt->bindParam(':total', $total);
        return $stmt->execute();
    }

    public function readAll()
    {
        $sql = "SELECT * FROM $this->table";
        $stmt = (new Database)->prepared($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if ($stmt->rowCount() > 0) {
            return $result;
        }
    }
    public function readById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id=:id";
        $stmt = (new Database)->prepared($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch();
    }
    public function delete($id)
    {
        $sql = "DELETE FROM $this->table WHERE id=:id";
        $stmt = (new Database)->prepared($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function update($id)
    {
        $sql  = "UPDATE $this->table SET nama_barang=:nama, harga_satuan=:price, jumlah=:ammount, tanggal_beli=:tanggal, total=:total WHERE id=:id";
        $stmt = (new Database)->prepared($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $this->nama_barang);
        $stmt->bindParam(':price', $this->harga_satuan);
        $stmt->bindParam(':ammount', $this->jumlah);
        $stmt->bindParam(':tanggal', $this->tanggal_beli);
        $total = $this->countTotal();
        $stmt->bindParam(':total', $total);
        return $stmt->execute();
    }
    public function fetchById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id=:id";
        $stmt = (new Database)->prepared($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            $penj = new Penjualan();
            $penj->id = $row['id'];
            $penj->nama_barang = $row['nama_barang'];
            $penj->harga_satuan = $row['harga_satuan'];
            $penj->jumlah = $row['jumlah'];
            $penj->tanggal_beli = $row['tanggal_beli'];
            $penj->total = $row['total'];
            return $penj;
        } else {
            return null;
        }
    }
}
