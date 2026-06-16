<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data dummy teks teknologi
        $documents = [
            [
                'title' => 'Panduan Lengkap Python untuk Pemula',
                'content' => 'Python adalah bahasa pemrograman tingkat tinggi yang mudah dipelajari. Python digunakan untuk web development, data science, artificial intelligence, dan automation. Fitur-fitur utama Python antara lain syntax yang sederhana, mudah dibaca, dan mendukung multiple programming paradigms. Python memiliki library yang sangat lengkap seperti NumPy, Pandas, dan Scikit-learn untuk data science. Dengan Python, Anda dapat mengembangkan aplikasi desktop, web, dan mobile dengan cepat dan efisien.',
            ],
            [
                'title' => 'Memahami Framework Laravel untuk Web Development',
                'content' => 'Laravel adalah framework PHP modern yang elegant dan powerful untuk web development. Laravel menyediakan tools lengkap seperti Eloquent ORM, migration, routing, dan middleware yang mempermudah pengembangan aplikasi. Framework ini mengikuti arsitektur MVC yang rapi dan mudah dimaintain. Laravel juga memiliki ecosystem yang kaya dengan tools seperti Tinker, Horizon, dan Telescope. Dengan Laravel, developer dapat membuat aplikasi web skala besar dengan code yang clean dan maintainable. Laravel juga menyediakan authentication, authorization, dan database migration yang powerful out of the box.',
            ],
            [
                'title' => 'Docker: Virtualisasi Container untuk Deployment',
                'content' => 'Docker adalah platform containerization yang memungkinkan Anda untuk package aplikasi beserta dependencies-nya dalam container. Container Docker memastikan aplikasi berjalan konsisten di berbagai environment development, testing, dan production. Docker menggunakan image sebagai template untuk membuat container, dan Dockerfile untuk mendefinisikan image. Dengan Docker, deployment menjadi lebih mudah, cepat, dan reliable. Docker Compose memungkinkan Anda mendefinisikan multi-container application dalam satu file. Keuntungan Docker antara lain portability, isolation, scalability, dan cost efficiency.',
            ],
            [
                'title' => 'Information Retrieval: Teknologi Pencarian di Era Digital',
                'content' => 'Information Retrieval (IR) adalah bidang ilmu yang mempelajari cara mengambil informasi yang relevan dari koleksi dokumen. Sistem IR menggunakan teknik full-text search, ranking, dan relevance scoring untuk memberikan hasil pencarian terbaik. Komponen utama IR mencakup indexing, retrieval model, ranking algorithm, dan evaluation metrics. Teknik IR modern menggunakan machine learning dan deep learning untuk meningkatkan akurasi pencarian. Search engine seperti Google, Elasticsearch, dan Apache Solr adalah contoh implementasi IR yang sukses. Text preprocessing, term weighting, dan semantic search adalah konsep penting dalam IR.',
            ],
            [
                'title' => 'Keamanan Jaringan: Proteksi Data dan Sistem Informasi',
                'content' => 'Keamanan jaringan adalah praktik melindungi jaringan dan data dari unauthorized access, disruption, atau modification. Elemen utama keamanan jaringan mencakup authentication, encryption, firewall, intrusion detection, dan vulnerability management. Cyber threats seperti malware, ransomware, phishing, dan DDoS attack terus berkembang. Best practices keamanan jaringan antara lain: menggunakan strong password, updating software regularly, melakukan backup rutin, dan monitoring jaringan. Protokol keamanan seperti SSL/TLS, SSH, dan VPN digunakan untuk melindungi komunikasi data. Sertifikasi keamanan seperti CISSP dan CEH membantu professional develop keahlian security.',
            ]
        ];

        // Insert data menggunakan foreach loop
        foreach ($documents as $doc) {
            Document::create([
                'title' => $doc['title'],
                'content' => $doc['content'],
            ]);
        }
    }
}
