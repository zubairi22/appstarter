<?= $this->extend('templates/template'); ?>

<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="text-dark mb-4"><?= $title ?></h3>
    </div>

    <div class="container-fluid">
        <div class="card-body pt-0">
            <form class="user" id="user_form" action="#" method="get">
                <div class="pt-2">
                    <div class="form-row">
                        <div class="col">
                            <select class="form-control" id="user_id" name="user_id">
                                <option value="">Pilih Pegawai</option>
                                <?php foreach ($pegawai as $row) : ?>
                                    <option <?= $selected == $row['user_id'] ? 'selected' : '' ?> value="<?= $row['user_id']; ?>"><?= $row['pegawai_nama']; ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control " type="date" id="tanggal_mulai" name="tanggal_mulai">
                        </div>
                        <div class="col-md-3">
                            <input class="form-control " type="date" id="tanggal_akhir" name="tanggal_akhir">
                        </div>
                    </div>
                    <div class="pl-5 pr-5 pt-3">
                        <button class="btn btn-primary btn-user w-100" type="submit">Lihat Laporan</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 fw-bold">Laporan Pegawai</p>
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
                                        <button class="btn btn-success" id="setuju" value="2" onclick="setuju(<?php echo $row['pekerjaan_id']; ?>)">Setuju</button>
                                        <button class="btn btn-danger" id="tolak" value="1" onclick="tolak(<?php echo $row['pekerjaan_id']; ?>)">Tolak</button>
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
    });

    function setuju(id) {
        $.ajax({
            url: "<?php echo base_url('laporan/update') ?>/" + id + "/" +
                $('#setuju').val(),
            type: "POST",
            success: function(data) {
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Gagal');
            }
        });
    }

    function tolak(id) {
        $.ajax({
            url: "<?php echo base_url('laporan/update') ?>/" + id + "/" +
                $('#tolak').val(),
            type: "POST",
            success: function(data) {
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Gagal');
            }
        });
    }
</script>

<?= $this->endSection(); ?>