<?php

require_once('./classes/Stok.php');

class StokTest extends \PHPUnit\Framework\TestCase
{
    protected $stok;

    protected function setUp(): void
    {
        $this->stok = new Stok();
    }

    public function testCountTotal()
    {
        $this->stok->harga_beli = 20000;
        $this->stok->laba = 15;
        $harga_jual = $this->stok->countHargaJual();
        self::assertEquals(23000, $harga_jual);
    }

    public function testAddSuccess()
    {
        $this->stok->id = '123';
        $this->stok->nama_obat = "Obat Test";
        $this->stok->jumlah_stok = 19;
        $this->stok->harga_beli = 20000;
        $this->stok->laba = 15;
        $this->stok->tanggal = '2021-11-12';
        $this->stok->harga_jual = $this->stok->countHargaJual();

        $this->stok->insert();

        $result = $this->stok->fetchById($this->stok->id);
        self::assertEquals($this->stok->id, $result->id);
        self::assertEquals($this->stok->nama_obat, $result->nama_obat);
        self::assertEquals($this->stok->jumlah_stok, $result->jumlah_stok);
        self::assertEquals($this->stok->harga_beli, $result->harga_beli);
        self::assertEquals($this->stok->laba, $result->laba);
        self::assertEquals($this->stok->tanggal, $result->tanggal);
        self::assertEquals($this->stok->harga_jual, $result->harga_jual);
    }

    public function testUpdateSuccess()
    {
        $idBarang = "123";
        $this->stok->nama_obat = "Obat Test";
        $this->stok->jumlah_stok = 25;
        $this->stok->harga_beli = 30000;
        $this->stok->laba = 10;
        $this->stok->tanggal = '2021-11-13';
        $this->stok->harga_jual = $this->stok->countHargaJual();

        $this->stok->update($idBarang);

        $result = $this->stok->fetchById($idBarang);
        self::assertEquals($idBarang, $result->id);
        self::assertEquals($this->stok->nama_obat, $result->nama_obat);
        self::assertEquals($this->stok->jumlah_stok, $result->jumlah_stok);
        self::assertEquals($this->stok->harga_beli, $result->harga_beli);
        self::assertEquals($this->stok->laba, $result->laba);
        self::assertEquals($this->stok->tanggal, $result->tanggal);
        self::assertEquals($this->stok->harga_jual, $result->harga_jual);
    }

    public function testDeleteSuccess()
    {
        $idBarang = "123";
        $this->stok->delete($idBarang);
        $result = $this->stok->fetchById($idBarang);
        self::assertEquals(null, $result);
    }
}
