<?= $this->extend('templates/template'); ?>

<?= $this->section('content'); ?>
<div class="d-flex flex-column" id="content-wrapper">
    <div id="content">
        <div class="container-fluid">
            <h3 class="text-dark mb-4"> <?= $title ?> </h3>
            <div class="row mb-3">
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <form method="post" action="<?= base_url('profile/updateFoto/' . $pegawai['pegawai_id']) ?>" enctype="multipart/form-data">
                            <div class="card-body text-center">
                                <img class="rounded-circle mb-3 mt-4" src=" <?= base_url('/assets/img/foto/' . $pegawai['pegawai_foto']) ?>" width="160" height="160">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file_upload" name="file_upload" accept="image/*">
                                    <label class="custom-file-label" for="file">Pilih File..</label>
                                </div>
                                <div class="mb-3 p-3">
                                    <button class="btn btn-primary btn-sm" type="submit">Ganti Foto</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="text-dark m-0 fw-bold">Data Diri</h6>
                                </div>
                                <div class="card-body">
                                    <form action="<?= base_url('profile/updateProfile/' . $pegawai['pegawai_id']) ?>" method="post">
                                        <?= csrf_field(); ?>
                                        <div class="mb-3">
                                            <label>NIP : </label>
                                            <input class="form-control form-control-user" type="text" id="pegawai_id" aria-describedby="userHelp" name="pegawai_id" autofocus value="<?= $pegawai['pegawai_id']; ?>" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label>Nama : </label>
                                            <input class="form-control form-control-user " type="text" id="pegawai_nama" aria-describedby="userHelp" name="pegawai_nama" value="<?= $pegawai['pegawai_nama']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Tempat Lahir : </label>
                                            <input class="form-control form-control-user " type="text" id="pegawai_tempat_lahir" aria-describedby="userHelp" name="pegawai_tempat_lahir" value="<?= $pegawai['pegawai_tempat_lahir']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="tanggal_lahir">Tanggal Lahir</label>
                                            <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="<?= $pegawai['pegawai_tanggal_lahir']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Jenis Kelamin : </label>
                                            <select class="form-control" id="pegawai_kelamin" name="pegawai_kelamin" aria-valuenow="<?= $pegawai['pegawai_kelamin']; ?>">
                                                <option value="L" <?= ($pegawai['pegawai_kelamin'] == "L" ? "selected" : ""); ?>>Laki-Laki</option>
                                                <option value="P" <?= ($pegawai['pegawai_kelamin'] == "P" ? "selected" : ""); ?>>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="agama">Agama</label>
                                            <select class="form-control" id="agama" name="agama">
                                                <option value="">Pilih Agama</option>
                                                <?php foreach ($agama as $row) : ?>
                                                    <option <?= $pegawai['pegawai_agama'] == $row ? 'selected' : ''; ?>>
                                                        <?= $row; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>E-mail : </label>
                                            <input class="form-control form-control-user " type="text" id="pegawai_email" aria-describedby="userHelp" name="pegawai_email" value="<?= $pegawai['pegawai_email']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Alamat : </label>
                                            <textarea class="form-control" id="pegawai_alamat" aria-describedby="userHelp" name="pegawai_alamat"><?= $pegawai['pegawai_alamat']; ?></textarea>
                                        </div>
                                        <button class="btn btn-primary d-block btn-user " type="submit">Ubah Data</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<?= $this->endSection(); ?>