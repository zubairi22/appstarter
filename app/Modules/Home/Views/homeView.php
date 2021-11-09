<?= $this->extend('templates/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary   h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Diproses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $proses; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-right fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $setuju; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tolak; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card">
        <div class="card-header py-3 ">
            <h6 class="text-black m-0">Urutan Kinerja Pegawai Bulan : <?= date('F'); ?></h6>
        </div>
        <div id="laporan" class="card-body pt-0">
            <table class="table m-0 table-hover nowrap" id="dataTables" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NIP Pegawai</th>
                        <th>Nama Pegawai</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($nilai as $row) {
                    ?>
                        <tr>
                            <td><?= $row['pegawai_id'] ?></td>
                            <td><?= $row['pegawai_nama'] ?></td>
                            <td><?= $row['nilai'] >= 100 ? 100 : $row['nilai']  ?></td>
                        </tr>
                          <?php
                        } ?>
                </tbody>
            </table>
        </div>

    </div>
    <!-- Content Row -->

</div>

<script>
    $(document).ready(function() {
        $('#dataTables').DataTable({
            responsive: true,
            order: [
                [2, "desc"]
            ], //or asc 
        });
    });
</script>

<?= $this->endSection(); ?>