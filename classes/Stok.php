<?php

spl_autoload_register(function ($className) {
    include 'classes/' . $className . '.php';
});


class Stok
{
    private $table = 'stoklaba';

    public $id, $nama_obat, $jumlah_stok, $harga_beli, $laba, $tanggal, $harga_jual;
    
    public function countHargaJual()
    {
        return $this->harga_beli * $this->laba / 100 + $this->harga_beli;
    }


    public function insert()
    {
        $sql = "INSERT INTO $this->table(id,nama_obat,jumlah_stok,harga_beli,laba,tanggal,harga_jual) 
        VALUES(:id,:nama,:jumlah_stok,:harga_beli,:laba,:tanggal,:harga_jual)";
        $stmt = (new Database)->prepared($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nama', $this->nama_obat);
        $stmt->bindParam(':jumlah_stok', $this->jumlah_stok);
        $stmt->bindParam(':harga_beli', $this->harga_beli);
        $stmt->bindParam(':laba', $this->laba);
        $stmt->bindParam(':tanggal', $this->tanggal);
        $harga_jual = $this->countHargaJual();
        $stmt->bindParam(':harga_jual', $harga_jual);
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
        $sql  = "UPDATE $this->table SET nama_obat=:nama, jumlah_stok=:jumlah_stok, harga_beli=:harga_beli, laba=:laba, tanggal=:tanggal, harga_jual=:harga_jual WHERE id=:id";
        $stmt = (new Database)->prepared($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $this->nama_obat);
        $stmt->bindParam(':jumlah_stok', $this->jumlah_stok);
        $stmt->bindParam(':harga_beli', $this->harga_beli);
        $stmt->bindParam(':laba', $this->laba);
        $stmt->bindParam(':tanggal', $this->tanggal);
        $harga_jual = $this->countHargaJual();
        $stmt->bindParam(':harga_jual', $harga_jual);
        return $stmt->execute();
    }

    public function fetchById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id=:id";
        $stmt = (new Database)->prepared($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            $pen = new Stok();
            $pen->id = $row['id'];
            $pen->nama_obat = $row['nama_obat'];
            $pen->jumlah_stok = $row['jumlah_stok'];
            $pen->harga_beli = $row['harga_beli'];
            $pen->laba = $row['laba'];
            $pen->tanggal = $row['tanggal'];
            $pen->harga_jual = $row['harga_jual'];
            return $pen;
        } else {
            return null;
        }
    }
}
