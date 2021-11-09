<?= $this->extend('templates/template'); ?>

<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="text-black mb-4"><?= $title ?></h3>
    </div>

    <div class="container-fluid">
        <div class="card-body pt-0">
            <form class="user" id="user_form" action="#" method="get">
                <div class="pt-2">
                    <div class="form-row">
                        <div class="col">
                            <select class="form-control" id="pegawai_id" name="pegawai_id">
                                <option value="">Pilih Pegawai</option>
                                <?php foreach ($pegawai as $row) : ?>
                                    <option <?= $selected == $row['pegawai_id'] ? 'selected' : '' ?> value="<?= $row['pegawai_id']; ?>"><?= $row['pegawai_nama']; ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control " type="date" id="tanggal_mulai" name="tanggal_mulai" value="<?= old('tanggal_mulai') ?>">
                        </div>
                        <div class="col-md-3">
                            <input class="form-control " type="date" id="tanggal_akhir" name="tanggal_akhir" value="<?= old('tanggal_akhir') ?>">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary  w-100" type="submit">Lihat Laporan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php if ($list != NULL) { ?>
            <div class="card shadow">
                <div class="card-header py-3">
                    <p class="text-black m-0 fw-bold">Laporan Pegawai</p>
                </div>
                <div id="laporan" class="card-body pl-4 pr-4">
                    <div class="table-responsive" id="dataTable" role="grid" aria-describedby="dataTable_info">
                        <table class="table my-0 table-hover nowrap" id="dataTables" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($list as $row) {
                                ?>
                                    <tr>
                                        <td><?= $row['pekerjaan_judul'] ?></td>
                                        <td><?= $row['pekerjaan_deskripsi'] ?></td>
                                        <td><?= $row['pekerjaan_tgl'] ?></td>
                                        <td>
                                            <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Tindakan
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" onclick="setuju(<?= $row['pekerjaan_id']; ?>)">
                                                    <i class="fas fa-check-double"></i>
                                                    Setuju</a>
                                                <a class="dropdown-item" onclick="aksi(<?= $row['pekerjaan_id']; ?> , 2 )">
                                                    <i class="fas fa-check"></i>
                                                    Setuju dengan Catatan </a>
                                                <a class="dropdown-item" onclick="aksi(<?= $row['pekerjaan_id']; ?> , 1)">
                                                    <i class="fas fa-ban"></i>
                                                    Tolak</a>
                                            </div>

                                        </td>
                                    </tr>
                                      <?php
                                    } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        <?php } ?>
    </div>
</div>

<div id="ModalCatatan" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Ajukan Surat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <form action="#" method="post" id="form-catatan">
                <div class="modal-body m-2">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="st" id="st">
                    <div class="form-group">
                        <label for="Catatan">Catatan</label>
                        <textarea class="form-control" id="catatan" name="catatan" placeholder="Masukan Catatan Pengajuan jika ada" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnCatatan" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->
<script>
    $(document).ready(function() {
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

        $('#form-catatan').on('submit', function(e) {
            e.preventDefault();
            if ($('#st').val() == 2) {
                var title = 'Disetujui dengan Catatan'
            } else {
                var title = 'Ditolak'
            }
            $.ajax({
                type: "POST",
                url: " <?= base_url('laporan/update') ?>",
                data: $(this).serialize(),
                success: function(res) {
                    $("#ModalCatatan").modal('hide');
                    Swal.fire({
                        title: title,
                        icon: icon = 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    })
                }
            });

        });
    });

    function setuju(id) {
        $.ajax({
            url: " <?= base_url('laporan/setuju') ?>",
            type: "POST",
            data: {
                id: id,
            },
            success: function() {
                Swal.fire({
                    title: 'Disetujui',
                    icon: icon = 'success',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload();
                })
            },
            error: function() {
                Swal.fire({
                    title: 'Gagal',
                    text: 'Proses Verifikasi Gagal',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload();
                })
            }
        });
    }

    function aksi(id, st) {
        $("#form-catatan")[0].reset();
        $('#id').val(id)
        $('#st').val(st)
        if (st == 2) {
            $('#myModalLabel').html('Catatan Persetujuan')
            $('#btnCatatan').html('Setujui')
        } else {
            $('#myModalLabel').html('Catatan Penolakan')
            $('#btnCatatan').html('Tolak')
        }
        $("#ModalCatatan").modal('show');
    }
</script>

<?= $this->endSection(); ?>