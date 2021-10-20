<?= $this->extend('templates/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h3 class="text-dark mb-4"> <?= $title ?> </h3>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <a href="#" class="btn btn-success btn-icon-split p-0 pl-3 ml-2" onclick="tambah();">
                    <i class="fas fa-user-plus"></i>
                    <span class="text">Tambah Pegawai</span>
                </a>
                <div class="card-body pt-0">
                    <table class="table my-0 table-hover nowrap" id="dataTables" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Foto</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Golongan</th>
                                <th>Tempat Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Email</th>
                                <th>Status Pegawai</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($pegawai as $row) {
                            ?>
                                <tr>
                                    <td></td>
                                    <td><img class="img-profile" src=" <?= base_url('/assets/img/foto/' . $row['pegawai_foto']); ?>" width="80px" alt=""></td>
                                    <td><?= $row['pegawai_id'] ?></td>
                                    <td><?= $row['pegawai_nama'] ?></td>
                                    <td><?= $row['golongan_id'] == '' ? '-' : $row['golongan_id'] ?> </td>
                                    <td><?= $row['pegawai_tempat_lahir'] ?></td>
                                    <td><?= $row['pegawai_kelamin'] == 'L' ? 'Laki-Laki' : 'Perempuan' ?></td>
                                    <td><?= $row['pegawai_email'] ?></td>
                                    <td><?= $row['pegawai_status'] ?></td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-circle" onclick="edit('<?= $row['pegawai_id'] ?>');">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger btn-circle" onclick="hapus('<?= $row['pegawai_id'] ?>' , '<?= $row['pegawai_nama'] ?>' );">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                    </td>
                                </tr>
                                  <?php
                                } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<div id="ModalAdd" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Tambah Pegawai</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <form action="<?= base_url('pegawai/tambah') ?>" method="post" id="form-tambah" enctype="multipart/form-data">
                <div class="modal-body m-2">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="pegawai_id">NIP</label>
                        <input type="text" class="form-control <?= ($validation->hasError('pegawai_id')) ? 'is-invalid' : ''; ?>" name="pegawai_id" id="pegawai_id" placeholder="Masukan NIP" value="<?= old('pegawai_id'); ?>">
                        <div class=" invalid-feedback">
                            <?= $validation->getError('pegawai_id'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pegawai_nama">Nama</label>
                        <input type="text" class="form-control <?= ($validation->hasError('pegawai_nama')) ? 'is-invalid' : ''; ?>" id="pegawai_nama" name="pegawai_nama" placeholder="Masukan Nama" value="<?= old('pegawai_nama'); ?>">
                        <div class=" invalid-feedback">
                            <?= $validation->getError('pegawai_nama'); ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" class="form-control <?= ($validation->hasError('tempat_lahir')) ? 'is-invalid' : ''; ?>" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir" value="<?= old('tempat_lahir'); ?>">
                            <div class=" invalid-feedback">
                                <?= $validation->getError('tempat_lahir'); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="<?= old('tanggal_lahir'); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="agama">Agama</label>
                            <select class="form-control" id="agama" name="agama">
                                <option value="">Pilih Agama</option>
                                <?php foreach ($agama as $row) : ?>
                                    <option <?= old('agama') == $row ? 'selected' : ''; ?>>
                                        <?= $row; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="jk">Jenis Kelamin</label>
                            <select class="form-control" id="jk" name="jk">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option <?= old('jk') == "L" ? 'selected' : ''; ?>>L</option>
                                <option <?= old('jk') == "P" ? 'selected' : ''; ?>>P</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="status">Status Pegawai</label>
                            <select class="form-control" id="statusA" name="status" required>
                                <option value="">Pilih Status</option>
                                <option <?= old('status') == "PNS" ? 'selected' : ''; ?>>PNS</option>
                                <option <?= old('status') == "NON" ? 'selected' : ''; ?>>NON</option>
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="golongan">Golongan</label>
                            <select class="form-control" id="golonganA" name="golongan">
                                <option value="">Pilih Gologan</option>
                                <?php foreach ($golongan as $row) : ?>
                                    <option <?= old('golongan') == $row['golongan_id'] ? 'selected' : ''; ?> value="<?= $row['golongan_id']; ?>"><?= $row['golongan_id']; ?> - <?= $row['golongan_nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= old('email'); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">NPWP</label>
                            <input type="text" class="form-control" id="npwp" name="npwp" placeholder="Masukkan NPWP Jika ada" value="<?= old('npwp'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" id="alamat" name="alamat" placeholder="Alamat Lengkap" value="<?= old('alamat'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('alamat'); ?>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnTambah" type="submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="ModalEdit" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Pegawai</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <form action="<?= base_url('pegawai/update') ?>" method="post" id="form-update" enctype="multipart/form-data">
                <div class="modal-body m-2">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="pegawai_id">NIP</label>
                        <input type="text" class="form-control <?= ($validation->hasError('pegawai_id')) ? 'is-invalid' : ''; ?>" name="pegawai_id" id="pegawai_id" placeholder="Masukan NIP" value="<?= old('pegawai_id'); ?>" readonly>
                        <div class=" invalid-feedback">
                            <?= $validation->getError('pegawai_id'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pegawai_nama">Nama</label>
                        <input type="text" class="form-control <?= ($validation->hasError('pegawai_nama')) ? 'is-invalid' : ''; ?>" id="pegawai_nama" name="pegawai_nama" placeholder="Masukan Nama">
                        <div class=" invalid-feedback">
                            <?= $validation->getError('pegawai_nama'); ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" class="form-control <?= ($validation->hasError('tempat_lahir')) ? 'is-invalid' : ''; ?>" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir">
                            <div class=" invalid-feedback">
                                <?= $validation->getError('tempat_lahir'); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="<?= old('tanggal_lahir'); ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="agama">Agama</label>
                            <select class="form-control" id="agama" name="agama" required>
                                <option value="">Pilih Agama</option>
                                <?php foreach ($agama as $row) : ?>
                                    <option <?= old('agama') == $row ? 'selected' : ''; ?>>
                                        <?= $row; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="jk">Jenis Kelamin</label>
                            <select class="form-control" id="jk" name="jk" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option <?= old('jk') == 'L' ? 'selected' : ''; ?> value="L">Laki-Laki</option>
                                <option <?= old('jk') == 'P' ? 'selected' : ''; ?>value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="status">Status Pegawai</label>
                            <select class="form-control" id="statusE" name="status" required>
                                <option value="">Pilih Status</option>
                                <option <?= old('status') == "PNS" ? 'selected' : ''; ?>>PNS</option>
                                <option <?= old('status') == "NON" ? 'selected' : ''; ?>>NON</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="golongan">Golongan</label>
                            <select class="form-control" id="golonganE" name="golongan">
                                <option value="">Pilih Gologan</option>
                                <?php foreach ($golongan as $row) : ?>
                                    <option <?= old('golongan') == $row['golongan_id'] ? 'selected' : ''; ?> value="<?= $row['golongan_id']; ?>"><?= $row['golongan_id']; ?> - <?= $row['golongan_nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">NPWP</label>
                            <input type="text" class="form-control" id="npwp" name="npwp" placeholder="Masukkan NPWP Jika ada">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" id="alamat" name="alamat" placeholder="Alamat Lengkap">
                        <div class="invalid-feedback">
                            <?= $validation->getError('alamat'); ?>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnTambah" type="submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        <?php if (session()->getFlashdata('gagal') == 'tambah') { ?>
            $('#ModalAdd').modal('show');
        <?php  } else if (session()->getFlashdata('gagal') == 'update') { ?>
            $('#ModalEdit').modal('show');
        <?php } ?>
        <?php if (session()->getFlashdata('pesan')) { ?>
            Swal.fire({
                title: 'Data Pegawai',
                text: 'Berhasil <?= session()->getFlashdata('pesan') ?>',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
            })
        <?php } ?>

        $('#dataTables').DataTable({
            responsive: true,
            columnDefs: [{
                    responsivePriority: 1,
                    targets: 0
                },
                {
                    responsivePriority: 2,
                    targets: 1
                },
                {
                    responsivePriority: 3,
                    targets: 2
                },
                {
                    responsivePriority: 4,
                    targets: -1
                }
            ]
        });

        $('#statusA').on("change", function() {
            if ($('#statusA').val() == "NON") {
                $('#golonganA').attr('disabled', true);
                $('#golonganA').val("");
            } else {
                $('#golonganA').attr('disabled', false);
            }
        });

        $('#statusE').on("change", function() {
            if ($('#statusE').val() == "NON") {
                $('#golonganE').attr('disabled', true);
                $('#golonganE').val("");
            } else {
                $('#golonganE').attr('disabled', false);
            }
        });

    });

    function tambah() {
        $("#form-tambah")[0].reset();
        $("#ModalAdd").modal('show');
    }

    function edit(id) {
        let modal = $("#ModalEdit").modal();
        var id = id;
        $.ajax({
            url: "<?= base_url('pegawai/getDataUpdate'); ?>",
            type: "POST",
            dataType: "JSON",
            cache: false,
            data: {
                id: id
            },
            success: function(res) {
                $("#form-update")[0].reset();
                modal.find('[name="pegawai_id"]').val(id);
                modal.find('[name="pegawai_nama"]').val(res.pegawai_nama);
                modal.find('[name="tempat_lahir"]').val(res.pegawai_tempat_lahir);
                modal.find('[name="tanggal_lahir"]').val(res.pegawai_tanggal_lahir);
                modal.find('[name="agama"]').val(res.pegawai_agama);
                modal.find('[name="jk"]').val(res.pegawai_kelamin);
                modal.find('[name="status"]').val(res.pegawai_status);
                if (res.pegawai_status == "NON") {
                    modal.find('[name="golongan"]').attr('disabled', true);
                }
                modal.find('[name="golongan"]').val(res.golongan_id);
                modal.find('[name="email"]').val(res.pegawai_email);
                modal.find('[name="npwp"]').val(res.pegawai_npwp);
                modal.find('[name="alamat"]').val(res.pegawai_alamat);

                modal.show();
            },
            error: function() {
                Swal.fire({
                        title: 'Error',
                        text: 'Gagal mengambil Data',
                        icon: 'warning',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    .then(() => {
                        $("#ModalEdit").modal('hide');
                    })
            }
        });
    }

    function hapus(id, name) {
        var id = id;
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Pegawai " + name + " akan dihapus.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus Data'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?= base_url('pegawai/hapus'); ?>",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function(res) {
                        Swal.fire({
                                title: 'Data Pengguna',
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