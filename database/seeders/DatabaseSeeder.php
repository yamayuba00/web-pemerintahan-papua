<?php

namespace Database\Seeders;

use App\Models\ApplicationService;
use App\Models\Categories;
use App\Models\ComplaintLinks;
use App\Models\Complaints;
use App\Models\Settings;
use App\Models\Slider;
use App\Models\Tourism;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User
        // User::create([
        //     'name' => 'CMS Papua',
        //     'email' => 'cms@papua.go.id',
        //     'password' => Hash::make('password123'),
        // ]);

        // Settings
        Settings::create([
            'site_name' => 'Portal Papua',
            'welcome_text' => 'Selamat Datang di Portal Resmi Pemerintah Provinsi Papua',
            'description' => '<p>Portal resmi informasi dan layanan publik Pemerintah Provinsi Papua.</p>',
            'visi' => '<p>Mewujudkan Papua yang mandiri, sejahtera, dan berkeadilan.</p>',
            'misi' => '<p><ol><li>Meningkatkan kualitas sumber daya manusia Papua</li><li>Membangun infrastruktur yang merata</li><li>Mengembangkan ekonomi kerakyatan berbasis potensi lokal</li></ol></p>',
            'name_gubernur' => 'Lukas Enembe',
            'position_gubernur' => 'Gubernur Papua',
            'photo_gubernur' => null,
            'name_wakil_gubernur' => 'John Wempi Wetipo',
            'position_wakil_gubernur' => 'Wakil Gubernur Papua',
            'photo_wakil_gubernur' => null,
            'address' => 'Jln. Soa Siu Dok 2 Bawah, Jayapura, Papua',
            'phone' => '+6281239005482',
            'email' => 'info@papua.go.id',
        ]);

        // // Categories
        // $categories = ['Pemerintahan', 'Pendidikan', 'Kesehatan', 'Infrastruktur', 'Ekonomi'];
        // foreach ($categories as $category) {
        //     Categories::create(['name' => $category, 'slug' => Str::slug($category)]);
        // }

        // // Sliders
        // Slider::create([
        //     'title' => 'Selamat Datang di Papua',
        //     'description' => 'Portal resmi Pemerintah Provinsi Papua',
        //     'image' => null,
        //     'is_active' => true,
        // ]);

        // Slider::create([
        //     'title' => 'Pembangunan Papua',
        //     'description' => 'Membangun Papua untuk masa depan yang lebih baik',
        //     'image' => null,
        //     'is_active' => true,
        // ]);

        // // Complaints
        // $complaint = Complaints::create([
        //     'title' => 'Layanan Pengaduan Masyarakat',
        //     'description' => 'Sampaikan pengaduan Anda terkait pelayanan publik di Provinsi Papua melalui kanal resmi berikut.',
        // ]);

        // ComplaintLinks::create([
        //     'complaint_id' => $complaint->id,
        //     'title' => 'LAPOR!',
        //     'url' => 'https://www.lapor.go.id/',
        // ]);

        // ComplaintLinks::create([
        //     'complaint_id' => $complaint->id,
        //     'title' => 'SP4N LAPOR',
        //     'url' => 'https://www.sp4n.go.id/',
        // ]);

        // // Tourism
        // $tourisms = [
        //     [
        //         'name' => 'Raja Ampat',
        //         'slug' => 'raja-ampat',
        //         'location' => 'Kabupaten Raja Ampat',
        //         'description' => 'Kepulauan dengan keindahan bawah laut kelas dunia, surga bagi penyelam dan pecinta alam.',
        //         'category' => 'Wisata Alam',
        //     ],
        //     [
        //         'name' => 'Danau Sentani',
        //         'slug' => 'danau-sentani',
        //         'location' => 'Kabupaten Jayapura',
        //         'description' => 'Danau terbesar di Papua dengan pemandangan indah dan festival budaya tahunan.',
        //         'category' => 'Wisata Alam',
        //     ],
        //     [
        //         'name' => 'Lembah Baliem',
        //         'slug' => 'lembah-baliem',
        //         'location' => 'Kabupaten Jayawijaya',
        //         'description' => 'Lembah yang dihuni suku Dani dengan budaya dan tradisi yang masih terjaga.',
        //         'category' => 'Wisata Budaya',
        //     ],
        //     [
        //         'name' => 'Taman Nasional Lorentz',
        //         'slug' => 'taman-nasional-lorentz',
        //         'location' => 'Papua Tengah',
        //         'description' => 'Situs Warisan Dunia UNESCO dengan keanekaragaman hayati dari pesisir hingga pegunungan salju.',
        //         'category' => 'Wisata Alam',
        //     ],
        // ];

        // foreach ($tourisms as $tourism) {
        //     Tourism::create($tourism);
        // }

        // Application Services
        $services = [
            [
                'title' => 'SIPD - Sistem Informasi Pemerintahan Daerah',
                'description' => 'Sistem informasi untuk pengelolaan data pemerintahan daerah Provinsi Papua.',
                'url' => 'https://sipd.papua.go.id',
            ],
            [
                'title' => 'E-Sakip',
                'description' => 'Sistem Akuntabilitas Kinerja Instansi Pemerintah secara elektronik.',
                'url' => 'https://esakip.papua.go.id',
            ],
            [
                'title' => 'LPSE Papua',
                'description' => 'Layanan Pengadaan Secara Elektronik Provinsi Papua.',
                'url' => 'https://lpse.papua.go.id',
            ],
            [
                'title' => 'JDIH Papua',
                'description' => 'Jaringan Dokumentasi dan Informasi Hukum Provinsi Papua.',
                'url' => 'https://jdih.papua.go.id',
            ],
        ];

        foreach ($services as $service) {
            ApplicationService::create($service);
        }
    }
}
