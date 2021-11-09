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
            <form id="bulan" action="#" method="get">
                <div class="pt-2">
                    <div class="form-row">
                        <div class="col-md-3">
                            <input class="form-control" type="month" id="bulan" name="bulan" value="<?= $bulan ?>">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary  w-100" type="submit">Lihat Laporan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php if ($nilai != NULL) { ?>
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="text-black m-0 fw-bold">Laporan Pegawai</h6>
                </div>
                <div id="laporan" class="card-body pl-4 pr-4 pt-0">
                    <div class="table-responsive" id="dataTable" role="grid" aria-describedby="dataTable_info">
                        <table class="table my-0 table-hover nowrap" id="dataTables" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($nilai as $row) {
                                ?>
                                    <tr>
                                        <td><img class="img-profile" src=" <?= base_url('/assets/img/foto/' . $row['pegawai_foto']); ?>" width="80px" alt=""></td>
                                        <td><?= $row['pegawai_id'] ?></td>
                                        <td><?= $row['pegawai_nama'] ?></td>
                                        <td><?= $row['jabatan_nama'] ?></td>
                                        <td><?= $row['nilai'] >= 100 ? 100 : $row['nilai']  ?></td>
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

<!-- End of Main Content -->
<script>
    $(document).ready(function() {
        $('#dataTables').DataTable({
            responsive: true,
            order: [
                [4, "desc"]
            ], //or asc 
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
</script>

<?= $this->endSection(); ?>