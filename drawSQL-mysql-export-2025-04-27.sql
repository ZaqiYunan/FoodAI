CREATE TABLE `Pengguna`(
    `ID_Pengguna` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Nama_Pengguna` VARCHAR(255) NOT NULL,
    `Email_Pengguna` VARCHAR(255) NOT NULL,
    `Password_Pengguna` VARCHAR(255) NOT NULL,
    `Role_Pengguna` ENUM('') NOT NULL,
    `Tgl_Pembuatan` DATETIME NOT NULL
);
CREATE TABLE `Bahan_Pengguna`(
    `ID_Bahan` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `ID_Pengguna` BIGINT NOT NULL,
    `Nama_Bahan` VARCHAR(255) NOT NULL,
    `Kategori_Bahan` ENUM('') NOT NULL,
    `Jumlah_Bahan` BIGINT NOT NULL,
    `Satuan_Bahan` FLOAT(53) NOT NULL,
    `Tipe_Satuan` ENUM('') NOT NULL,
    `Tgl_Kadaluarsa` DATE NOT NULL,
    `Tipe_Penyimpanan` ENUM('') NOT NULL,
    `Tgl_Pembuatan` DATETIME NOT NULL,
    PRIMARY KEY(`ID_Pengguna`)
);
CREATE TABLE `Resep`(
    `ID_Resep` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `ID_BahanResep` BIGINT NOT NULL,
    `ID_Pengguna` BIGINT NOT NULL,
    `Nama_Resep` VARCHAR(255) NOT NULL,
    `Kalori` BIGINT NOT NULL,
    `Langkah_Langkah` TEXT NOT NULL,
    `Image_Resep` VARCHAR(255) NOT NULL,
    `new_column` BIGINT NOT NULL,
    PRIMARY KEY(`ID_BahanResep`)
);
ALTER TABLE
    `Resep` ADD PRIMARY KEY(`ID_Pengguna`);
CREATE TABLE `Bahan_Resep`(
    `ID_BahanResep` BIGINT NOT NULL,
    `ID_Bahan` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `Nama_Bahan` VARCHAR(255) NOT NULL,
    `Jumlah_Bahan` BIGINT NOT NULL,
    `Satuan_Bahan` FLOAT(53) NOT NULL,
    `Tipe_Satuan` ENUM('') NOT NULL,
    `Kalori` BIGINT NOT NULL,
    `Image_Bahan` VARCHAR(255) NOT NULL,
    PRIMARY KEY(`ID_BahanResep`)
);
CREATE TABLE `Notifikasi`(
    `ID_Notifikasi` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `ID_Pengguna` BIGINT NOT NULL,
    `Isi_Notifikasi` TEXT NOT NULL,
    `Status_Notifikasi` ENUM('') NOT NULL,
    `Tgl_Pembuatan` DATETIME NOT NULL,
    PRIMARY KEY(`ID_Pengguna`)
);
ALTER TABLE
    `Pengguna` ADD CONSTRAINT `pengguna_id_pengguna_foreign` FOREIGN KEY(`ID_Pengguna`) REFERENCES `Bahan_Pengguna`(`ID_Pengguna`);
ALTER TABLE
    `Pengguna` ADD CONSTRAINT `pengguna_id_pengguna_foreign` FOREIGN KEY(`ID_Pengguna`) REFERENCES `Bahan_Pengguna`(`ID_Bahan`);
ALTER TABLE
    `Bahan_Pengguna` ADD CONSTRAINT `bahan_pengguna_id_bahan_foreign` FOREIGN KEY(`ID_Bahan`) REFERENCES `Bahan_Resep`(`ID_Bahan`);
ALTER TABLE
    `Bahan_Resep` ADD CONSTRAINT `bahan_resep_id_bahanresep_foreign` FOREIGN KEY(`ID_BahanResep`) REFERENCES `Resep`(`ID_BahanResep`);
ALTER TABLE
    `Pengguna` ADD CONSTRAINT `pengguna_id_pengguna_foreign` FOREIGN KEY(`ID_Pengguna`) REFERENCES `Resep`(`ID_Pengguna`);
ALTER TABLE
    `Notifikasi` ADD CONSTRAINT `notifikasi_id_pengguna_foreign` FOREIGN KEY(`ID_Pengguna`) REFERENCES `Pengguna`(`ID_Pengguna`);