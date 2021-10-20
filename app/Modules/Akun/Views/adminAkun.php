<?= $this->extend('templates/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <h3 class="text-dark mb-4"> <?= $title ?> </h3>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <a href="#" class="btn btn-success btn-icon-split p-0 pl-3 ml-2 " onclick="tambah();">
                    <i class="fas fa-user-plus"></i>
                    <span class="text">Tambah Pengguna</span>
                </a>
                <div class="card-body pt-3">
                    <table class="table my-0 table-hover nowrap" id="dataTables" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Username</th>
                                <th>Role Akun</th>
                                <th>Tanggal Registrasi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($user as $row) {
                            ?>
                                <tr>
                                    <td><img class="img-profile" src=" <?= base_url('/assets/img/foto/' . $row['pegawai_foto']); ?>" width="80px" alt=""></td>
                                    <td><?= $row['user_name'] ?></td>
                                    <td><?= $row['user_level_id'] == 1 ? 'Administrator' : 'User' ?></td>
                                    <td><?= $row['created_at'] ?></td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-circle" onclick="edit('<?= $row['user_id'] ?>');">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger btn-circle <?= $row['user_level_id'] == 1 ? 'disabled' : '' ?>" onclick="hapus('<?= $row['user_id'] ?>' , '<?= $row['user_name'] ?>');">
                                            <i class="fas fa-trash"></i>
                                        </a>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Tambah Pengguna</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="<?= base_url('akun/tambah') ?>" method="post" id="form-tambah">
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <select class="selectpicker form-control" id="user_name" name="user_name" required data-live-search="true">
                            <option value="">Pilih Pegawai</option>
                            <?php foreach ($tersedia as $row) : ?>
                                <option><?= $row['pegawai_id']; ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input class="form-control form-control-user <?= ($validation->hasError('user_password')) ? 'is-invalid' : ''; ?>" type="password" id="user_password" aria-describedby="passwordHelp" placeholder="Masukan Password" name="user_password" value="<?= old('user_password'); ?>">
                        <div class=" invalid-feedback">
                            <?= $validation->getError('user_password'); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <select class="form-control" id="user_level" name="user_level" required>
                            <option value="">Pilih Level Akun</option>
                            <?php foreach ($list as $row) : ?>
                                <option value="<?= $row['user_level_id']; ?> "><?= $row['user_level_nama']; ?> </option>
                            <?php endforeach; ?>
                        </select>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Pengguna</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="<?= base_url('akun/update/') ?>" method="post" id="form-update">
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <input name="id" hidden>
                    <div class="mb-3">
                        <input class="form-control form-control-user" type="text" id="user_name" aria-describedby="userHelp" placeholder="Masukan NIP" name="user_name" value="<?= old('user_name'); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <input class="form-control form-control-user <?= ($validation->hasError('user_password')) ? 'is-invalid' : ''; ?>" type="password" id="user_password" name="user_password" value="<?= old('user_password'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('user_password'); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <select class="form-control" id="user_level" name="user_level">
                            <?php foreach ($list as $row) : ?>
                                <option <?= old('user_level') == $row['user_level_id'] ? 'selected' : '' ?> value="<?= $row['user_level_id']; ?>"><?= $row['user_level_nama']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Ubah Data</button>
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
                title: 'Data Pengguna',
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
    });


    function tambah() {
        $("#form-tambah")[0].reset();
        $("#ModalAdd").modal('show');
    }

    function edit(id) {
        let modal = $("#ModalEdit").modal();
        var id = id;
        $.ajax({
            url: "<?= base_url('akun/getDataUpdate'); ?>",
            type: "POST",
            dataType: "JSON",
            cache: false,
            data: {
                id: id
            },
            success: function(res) {
                $("#form-update")[0].reset();
                modal.find('[name="id"]').val(id);
                modal.find('[name="user_name"]').val(res.user_name);
                modal.find('[name="user_password"]').val(res.user_password);
                modal.find('[name="user_level"]').val(res.user_level_id);
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
        console.log(id);
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Akun " + name + " akan dihapus.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus Data'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?= base_url('akun/hapus'); ?>",
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