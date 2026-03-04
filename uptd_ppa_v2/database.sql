-- ============================================================
-- DATABASE: uptd_ppa
-- Sistem Informasi Panduan Layanan UPTD PPA
-- ============================================================

CREATE DATABASE IF NOT EXISTS uptd_ppa
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE uptd_ppa;

-- ──────────────────────────────────────
-- TABEL: admin
-- Akun pengelola konten (internal)
-- ──────────────────────────────────────
CREATE TABLE IF NOT EXISTS admin (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username      VARCHAR(60)  NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  nama_lengkap  VARCHAR(120) NOT NULL,
  created_at    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ──────────────────────────────────────
-- TABEL: panduan
-- Konten panduan layanan (CRUD utama)
-- ──────────────────────────────────────
CREATE TABLE IF NOT EXISTS panduan (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug        VARCHAR(60)  NOT NULL UNIQUE,          -- misal: pelaporan, psikolog, hukum
  judul       VARCHAR(200) NOT NULL,
  deskripsi   TEXT,                                   -- sub-judul / ringkasan
  konten      LONGTEXT     NOT NULL,                  -- body HTML / markdown
  urutan      TINYINT      NOT NULL DEFAULT 1,        -- urutan tampil di menu
  aktif       TINYINT(1)   NOT NULL DEFAULT 1,
  created_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ──────────────────────────────────────
-- TABEL: dasar_hukum
-- Referensi peraturan perundang-undangan
-- ──────────────────────────────────────
CREATE TABLE IF NOT EXISTS dasar_hukum (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama_uu     VARCHAR(300) NOT NULL,                  -- misal: UU No. 23 Tahun 2004
  tentang     VARCHAR(300) NOT NULL,                  -- judul resmi
  ringkasan   TEXT         NOT NULL,
  urutan      SMALLINT     NOT NULL DEFAULT 1,
  aktif       TINYINT(1)   NOT NULL DEFAULT 1,
  created_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ──────────────────────────────────────
-- TABEL: faq
-- Pertanyaan yang sering diajukan
-- ──────────────────────────────────────
CREATE TABLE IF NOT EXISTS faq (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  pertanyaan  TEXT         NOT NULL,
  jawaban     TEXT         NOT NULL,
  kategori    VARCHAR(80)  DEFAULT NULL,              -- misal: Pelaporan, Hukum
  urutan      SMALLINT     NOT NULL DEFAULT 1,
  aktif       TINYINT(1)   NOT NULL DEFAULT 1,
  created_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ──────────────────────────────────────
-- TABEL: kontak_darurat
-- Nomor telepon darurat yang ditampilkan
-- ──────────────────────────────────────
CREATE TABLE IF NOT EXISTS kontak_darurat (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama        VARCHAR(120) NOT NULL,                  -- misal: UPTD PPA, Polisi
  nomor       VARCHAR(30)  NOT NULL,
  keterangan  VARCHAR(200) DEFAULT NULL,
  is_utama    TINYINT(1)   NOT NULL DEFAULT 0,        -- ditandai merah / urgent
  urutan      SMALLINT     NOT NULL DEFAULT 1,
  aktif       TINYINT(1)   NOT NULL DEFAULT 1,
  created_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- SEED DATA — data awal agar sistem langsung berjalan
-- ============================================================

-- Admin default  (password: admin123)
INSERT INTO admin (username, password_hash, nama_lengkap) VALUES
('admin', '$2y$10$KqBLkASjZPWzxPE8PfSMWOwFmIHVwbTzRfCAk2hP3yMKxIKdVBIWu', 'Administrator UPTD PPA');

-- Panduan awal
INSERT INTO panduan (slug, judul, deskripsi, konten, urutan) VALUES
('pelaporan',
 'Panduan Tata Cara Pelaporan',
 'Langkah-langkah yang jelas untuk membantu Anda memahami cara menyampaikan laporan ke UPTD PPA',
 '<h3>Siapa yang Dapat Melaporkan?</h3>
  <p>Laporan dapat disampaikan oleh korban langsung, keluarga korban, atau siapa pun yang mengetahui adanya tindak kekerasan terhadap perempuan atau anak. <strong>Anda tidak harus menjadi korban untuk mengajukan laporan.</strong></p>
  <h3>Tahapan Pelaporan</h3>
  <ol>
    <li><strong>Datang ke Kantor UPTD PPA</strong> — Kunjungi kantor UPTD PPA setempat pada jam kerja. Anda akan diterima oleh petugas yang terlatih.</li>
    <li><strong>Pertemuan Awal dengan Petugas</strong> — Petugas akan menyambut Anda dengan ramah dan menjelaskan proses yang akan dijalani.</li>
    <li><strong>Penyampaian Keterangan</strong> — Anda akan diminta memberikan keterangan mengenai kejadian. Tidak ada pertanyaan yang akan menghakimi.</li>
    <li><strong>Kelengkapan Dokumen</strong> — Secara umum dianjurkan membawa surat keterangan identitas. Ketiadaan dokumen tidak menghalangi proses pelaporan.</li>
    <li><strong>Tindak Lanjut</strong> — Setelah laporan diterima, UPTD PPA akan menentukan langkah tindak lanjut yang tepat.</li>
  </ol>',
 1),

('psikolog',
 'Pendampingan Psikolog &amp; Psikiater',
 'Informasi mengenai dukungan kesehatan jiwa yang tersedia untuk korban',
 '<h3>Pendampingan Psikologis Adalah Hak Anda</h3>
  <p>Setiap korban berhak mendapatkan dukungan kesehatan jiwa. Tidak ada yang &quot;terlalu kecil&quot; atau &quot;tidak penting&quot; — perasaan Anda valid dan layak mendapat perhatian.</p>
  <h3>Perbedaan Psikolog dan Psikiater</h3>
  <p><strong>Psikolog</strong> bertugas memberikan konseling dan terapi untuk mendukung kesehatan mental. Sesi konseling adalah ruang aman bagi Anda.</p>
  <p><strong>Psikiater</strong> adalah dokter spesialis yang dapat memberikan penanganan medis tambahan apabila dipandang perlu.</p>
  <h3>Tahapan Pendampingan</h3>
  <ol>
    <li><strong>Asesmen Awal</strong> — Psikolog melakukan asesmen untuk memahami kondisi dan kebutuhan Anda.</li>
    <li><strong>Sesi Konseling</strong> — Ruang aman untuk berbicara dan didengarkan tanpa penilaian.</li>
    <li><strong>Terapi Berkelanjutan</strong> — Dilakukan untuk mendukung pemulihan jangka panjang sesuai kebutuhan.</li>
    <li><strong>Rujukan ke Psikiater</strong> — Apabila penanganan medis diperlukan, Anda akan dirujuk secara profesional.</li>
  </ol>',
 2),

('hukum',
 'Panduan Bantuan Hukum',
 'Informasi mengenai hak-hak korban dan cara mengakses perlindungan hukum',
 '<h3>Anda Berhak Mendapatkan Perlindungan Hukum</h3>
  <p>Hukum Indonesia secara tegas melindungi korban kekerasan terhadap perempuan dan anak.</p>
  <h3>Hak-Hak Korban</h3>
  <ul>
    <li><strong>Hak atas Perlindungan</strong> — Korban berhak mendapatkan perlindungan dari pihak yang membahayakan keselamatannya.</li>
    <li><strong>Hak atas Pelayanan</strong> — Korban berhak mendapatkan pelayanan dari lembaga perlindungan dan penegak hukum.</li>
    <li><strong>Hak atas Bantuan Hukum</strong> — Korban berhak mendapatkan bantuan hukum dan representasi dari lembaga yang berwenang.</li>
    <li><strong>Hak atas Tempat Tinggal Sementara</strong> — Apabila diperlukan, korban berhak mendapatkan tempat tinggal sementara yang aman.</li>
  </ul>
  <h3>Cara Mengakses Bantuan Hukum</h3>
  <ol>
    <li>Hubungi UPTD PPA atau lembaga bantuan hukum setempat.</li>
    <li>Lakukan konsultasi awal dengan tim hukum.</li>
    <li>Tim hukum akan mendampingi Anda sepanjang proses penanganan kasus.</li>
  </ol>',
 3);

-- Dasar hukum awal
INSERT INTO dasar_hukum (nama_uu, tentang, ringkasan, urutan) VALUES
('UU No. 23 Tahun 2004',
 'Penghapusan Kekerasan dalam Rumah Tangga (KDRT)',
 'Mengatur definisi, bentuk, dan penanganan kekerasan dalam rumah tangga serta hak-hak korban KDRT.',
 1),
('UU No. 23 Tahun 2002 (diubah UU No. 35 Tahun 2014)',
 'Perlindungan Anak',
 'Mengatur hak-hak anak dan kewajiban negara dalam memberikan perlindungan kepada anak dari segala bentuk kekerasan dan pengeksploitasian.',
 2),
('UU No. 21 Tahun 2007',
 'Pemberantasan Perdagangan Orang',
 'Mengatur penanganan dan perlindungan korban perdagangan orang, termasuk perempuan dan anak.',
 3),
('UU No. 44 Tahun 2008',
 'Perlindungan dari Kejahatan Seksual',
 'Mengatur perlindungan korban kejahatan seksual dan hak-hak mereka dalam proses hukum.',
 4),
('UU No. 11 Tahun 2012',
 'Sistem Peradilan Anak',
 'Mengatur penanganan kasus yang melibatkan anak baik sebagai korban maupun tersangka.',
 5);

-- FAQ awal
INSERT INTO faq (pertanyaan, jawaban, kategori, urutan) VALUES
('Apakah saya harus datang langsung ke UPTD PPA untuk melaporkan?',
 'Ya, laporan disampaikan secara langsung ke kantor UPTD PPA. Petugas akan membantu Anda melalui proses pelaporan secara profesional dan menjaga kerahasiaan.',
 'Pelaporan', 1),
('Apakah biaya layanan pendampingan psikologis gratis?',
 'Layanan pendampingan psikologis yang disediakan oleh UPTD PPA tidak dipungut biaya dari korban.',
 'Pendampingan', 2),
('Apa yang terjadi setelah saya melaporkan kasus?',
 'Setelah laporan diterima, UPTD PPA akan melakukan asesmen dan menentukan langkah tindak lanjut yang tepat, termasuk pendampingan dan bantuan hukum jika diperlukan.',
 'Pelaporan', 3),
('Apakah identitas saya akan dijaga kerahasiaannya?',
 'Ya, semua data dan identitas pelapor serta korban dijaga kerahasiaannya sesuai dengan peraturan perundang-undangan yang berlaku.',
 'Umum', 4),
('Bagaimana cara mendapatkan bantuan hukum?',
 'Bantuan hukum dapat diperoleh dengan menghubungi UPTD PPA atau lembaga bantuan hukum setempat. Layanan ini tidak dipungut biaya dari korban.',
 'Hukum', 5);

-- Kontak darurat awal
INSERT INTO kontak_darurat (nama, nomor, keterangan, is_utama, urutan) VALUES
('UPTD PPA',           '119 ext 8',  'Unit Pelaksana Teknis Perlindungan Perempuan dan Anak', 1, 1),
('Polisi',             '110',        'Layanan darurat keamanan',                              1, 2),
('Ambulans',           '119',        'Layanan darurat kesehatan',                             1, 3),
('Hotline Perlindungan Anak', '119', 'Hotline nasional perlindungan anak',                    0, 4);
