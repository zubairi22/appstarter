<?= $this->extend('templates/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h3 class="text-dark mb-4"><?= $title; ?></h3>
    <div class="row mb-3">
        <div class="col-lg-5">
            <div class="card shadow mb-4">
                <h6 class="card-header">Tambah Pekerjaan</h6>
                <div class="card-body">
                    <form action="<?= base_url('user/prosesTambahPekerjaan') ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <input class="form-control form-control-user <?= ($validation->hasError('judul')) ? 'is-invalid' : ''; ?>" type="text" id="judul" placeholder="Masukkan Judul" name="judul" autofocus value="<?= old('judul'); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('judul'); ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input class="form-control form-control-user <?= ($validation->hasError('deskripsi')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Masukkan Deskripsi" id="deskripsi" name="deskripsi" value="<?= old('deskripsi'); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('deskripsi'); ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input class="form-control form-control-user <?= ($validation->hasError('tanggal')) ? 'is-invalid' : ''; ?>" type="date" id="tanggal" name="tanggal" value="<?= old('tanggal'); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('tanggal'); ?>
                            </div>
                        </div>
                        <button class="btn btn-primary d-block btn-user" type="submit">Tambah Pekerjaan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <h6 class="card-header">List Pekerjaan</h6>
                        <div class="card-body p-3">
                            <?php if ($list != NULL) {
                                foreach ($list as $l) { ?>
                                    <form action="<?= base_url('user/update/' . $l['pekerjaan_id']) ?>" method="post" id="form">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <div class="row align-items-center no-gutters">
                                                    <div class="col me-2">
                                                        <h6 class="mb-0"><strong><?= $l['pekerjaan_judul']; ?></strong></h6><span class="text-xs">Tanggal Mulai : <?= $l['pekerjaan_tgl']; ?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="status" id="status">
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <hr class="sidebar-divider">
                                    <?php  }
                            } else { ?>
                                    <p>Kosong</p>
                                <?php } ?>
                                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#status').change(function() {
            if (this.checked == true) {
                $('#form').submit();
            }
        });
    });
</script>

<?= $this->endSection(); ?>