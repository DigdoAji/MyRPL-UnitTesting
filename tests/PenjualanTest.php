<?php

require_once('./classes/Penjualan.php');

class PenjualanTest extends \PHPUnit\Framework\TestCase
{
    protected $penjualan;

    protected function setUp(): void
    {
        $this->penjualan = new Penjualan();
    }

    public function testCountTotal()
    {
        $this->penjualan->harga_satuan = 40000;
        $this->penjualan->jumlah = 2;
        $total = $this->penjualan->countTotal();
        self::assertEquals(80000, $total);
    }
    public function testAddSuccess()
    {
        $this->penjualan->id = '123';
        $this->penjualan->nama_barang = "Test barang";
        $this->penjualan->harga_satuan = 4000;
        $this->penjualan->jumlah = 34;
        $this->penjualan->tanggal_beli = '2020-02-02';
        $this->penjualan->total = $this->penjualan->countTotal();

        $this->penjualan->insert();

        $result = $this->penjualan->fetchById($this->penjualan->id);

        self::assertEquals($this->penjualan->id, $result->id);
        self::assertEquals($this->penjualan->nama_barang, $result->nama_barang);
        self::assertEquals($this->penjualan->harga_satuan, $result->harga_satuan);
        self::assertEquals($this->penjualan->jumlah, $result->jumlah);
        self::assertEquals($this->penjualan->tanggal_beli, $result->tanggal_beli);
        self::assertEquals($this->penjualan->total, $result->total);
    }

    public function testUpdateSuccess()
    {
        $idSumber = "123";
        $this->penjualan->nama_barang = "Test Ubah";
        $this->penjualan->harga_satuan = 90000;
        $this->penjualan->jumlah = 27;
        $this->penjualan->tanggal_beli = '2019-02-02';
        $this->penjualan->total = $this->penjualan->countTotal();


        $this->penjualan->update($idSumber);

        $result = $this->penjualan->fetchById($idSumber);
        self::assertEquals($idSumber, $result->id);
        self::assertEquals($this->penjualan->nama_barang, $result->nama_barang);
        self::assertEquals($this->penjualan->harga_satuan, $result->harga_satuan);
        self::assertEquals($this->penjualan->jumlah, $result->jumlah);
        self::assertEquals($this->penjualan->tanggal_beli, $result->tanggal_beli);
        self::assertEquals($this->penjualan->total, $result->total);
    }

    public function testDeleteSuccess()
    {
        $idSumber = "123";
        $this->penjualan->delete($idSumber);
        $result = $this->penjualan->fetchById($idSumber);
        self::assertEquals(null, $result);
    }
}
