<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Kursi',
                'deskripsi' => 'Kategori untuk pengaduan terkait kerusakan kursi belajar atau kursi staff'
            ],
            [
                'nama_kategori' => 'Meja',
                'deskripsi' => 'Kategori untuk pengaduan terkait kerusakan meja belajar atau meja kerja'
            ],
            [
                'nama_kategori' => 'Lampu',
                'deskripsi' => 'Kategori untuk pengaduan terkait kerusakan lampu penerangan ruangan'
            ],
            [
                'nama_kategori' => 'Proyektor',
                'deskripsi' => 'Kategori untuk pengaduan terkait kerusakan proyektor presentasi'
            ],
            [
                'nama_kategori' => 'AC',
                'deskripsi' => 'Kategori untuk pengaduan terkait kerusakan AC atau pendingin ruangan'
            ],
            [
                'nama_kategori' => 'Pintu',
                'deskripsi' => 'Kategori untuk pengaduan terkait kerusakan pintu ruangan atau pintu utama'
            ],
            [
                'nama_kategori' => 'Jendela',
                'deskripsi' => 'Kategori untuk pengaduan terkait kerusakan jendela atau kusen jendela'
            ],
            [
                'nama_kategori' => 'Papan Tulis',
                'deskripsi' => 'Kategori untuk pengaduan terkait kerusakan papan tulis whiteboard'
            ],
            [
                'nama_kategori' => 'Locker',
                'deskripsi' => 'Kategori untuk pengaduan terkait kerusakan loker penyimpanan barang'
            ],
            [
                'nama_kategori' => 'Lainnya',
                'deskripsi' => 'Kategori untuk pengaduan terkait sarana lainnya yang tidak termasuk kategori di atas'
            ]
        ];

        foreach ($kategoris as $kategori) {
            Kategori::firstOrCreate(
                ['nama_kategori' => $kategori['nama_kategori']],
                ['deskripsi' => $kategori['deskripsi']]
            );
        }
    }
}
