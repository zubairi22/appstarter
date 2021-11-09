<?= $this->extend('templates/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h3 class="text-dark mb-4"><?= $title; ?></h3>
    <div class="row mb-3">
        <div class="col-lg-5">
            <div class="card mb-4">
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
                        <button class="btn btn-primary btn-user" type="submit">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <h6 class="card-header">List Pekerjaan</h6>
                        <div class="card-body p-3">
                            <?php if ($list != NULL) {
                                foreach ($list as $l) { ?>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row align-items-center no-gutters">
                                                <div class="col me-2">
                                                    <h6 class="mb-0"><strong><?= $l['pekerjaan_judul']; ?></strong></h6><span class="text-xs">Tanggal Mulai : <?= $l['pekerjaan_tgl']; ?></span>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="btn btn-info btn-circle" onclick="teruskan('<?= $l['pekerjaan_id'] ?>');">
                                                        <i class="fas fa-angle-double-right"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger btn-circle" onclick="hapus('<?= $l['pekerjaan_id'] ?>');">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <hr class="sidebar-divider">
                                <?php  }
                            } else { ?>
                                <div class="text-center">
                                    <h5>Belum ada yang ditambahkan</h5>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function teruskan(id) {
        var id = id;
        Swal.fire({
            title: 'Diteruskan ke Atasan',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            $.ajax({
                url: "<?= base_url('user/update'); ?>",
                type: "POST",
                data: {
                    id: id
                },
                success: function(res) {
                    location.reload();
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Gagal meneruskan',
                        icon: 'warning',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        })
    }

    function hapus(id) {
        var id = id;
        Swal.fire({
            title: 'Apakah Anda yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus Data'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?= base_url('user/hapus'); ?>",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function(res) {
                        Swal.fire({
                                title: 'Pekerjaan',
                                text: 'Berhasil dihapus',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            .then(() => {
                                location.reload();
                            })
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Gagal menghapus data',
                            icon: 'warning',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                });
            }
        })
    }
</script>

<?= $this->endSection(); ?>