<?= $this->extend('templates/template'); ?>

<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="text-dark mb-4"><?= $title ?></h3>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div id="laporan" class="card-body pt-0">
                    <div class="table-responsive" id="dataTable" role="grid" aria-describedby="dataTable_info">
                        <table class="table my-0 table-hover nowrap " id="dataTables" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width=330>Judul</th>
                                    <th width=330>Deskripsi</th>
                                    <th>Tanggal</th>
                                    <th></th>
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
                                            <?php if ($row['pekerjaan_setuju'] == 3) { ?>
                                                <a class="btn btn-success btn-icon-split p-0 pl-3">
                                                    <i class="fas fa-check-double"></i>
                                                    <span class="text">Disetujui</span>
                                                </a>
                                            <?php
                                            } else if ($row['pekerjaan_setuju'] == 2) { ?>
                                                <a class="btn btn-success btn-icon-split p-0 pl-3" onclick="catatan('<?= $row['catatan'] ?>')">
                                                    <i class="fas fa-check"></i>
                                                    <span class="text">Disetujui dengan Catatan</span>
                                                </a>
                                            <?php
                                            } else if ($row['pekerjaan_setuju'] == 1) { ?>
                                                <a class="btn btn-danger btn-icon-split p-0 pl-3" onclick="catatan('<?= $row['catatan'] ?>')">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <span class="text">Tertolak
                                                    </span>
                                                </a>
                                            <?php
                                            } else { ?>
                                                <a class="btn btn-primary btn-icon-split p-0 pl-3">
                                                    <i class="fas fa-arrow-right"></i>
                                                    <span class="text">Diproses</span>
                                                </a>
                                            <?php } ?>
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

    function catatan(ct) {
        if (ct == "") {
            ct = 'Tidak ada catatan yang diberikan'
        }
        Swal.fire({
            title: 'Catatan',
            text: ct,
        })
    }
</script>

<?= $this->endSection(); ?>