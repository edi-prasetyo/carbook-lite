<div class="mb-4">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $title;?></h6>
                </div>
                <div class="col-md-3">
                    <!-- <a class="m-0 float-right btn btn-primary btn-md btn-block bg-gradient-primary" href="<?php echo base_url('admin/kas/filter_kas'); ?>"> Filter per Asrama <i class="fas fa-store ml-3"></i></a> -->

                </div>
                <div class="col-md-3">
                    <a class="m-0 float-right btn btn-primary btn-md btn-block bg-gradient-primary" href="<?php echo base_url('admin/kas/filter_alkas'); ?>"> Filter Data Per tanggal <i class="fa fa-calendar ml-3"></i></a>
                </div>
            </div>
        </div>



        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Tipe</th>
                        <th>Pemasukan</th>
                        <th>Pengeluaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($kas as $kas) : ?>
                        <tr>
                            <td class="text-info"><?php echo $no; ?></td>
                            <td><?php echo $kas->kas_tanggal; ?></td>
                            <td>
                              <?php if ($kas->kas_description == NULL): ?>
                                <?php echo $kas->kode_transaksi; ?>
                              <?php else:?>
                            <?php echo $kas->kas_description; ?>
                              <?php endif;?>

                            </td>
                            <td>
                                <?php if ($kas->tipe_transaksi == 'Pemasukan') : ?>
                                    <span class="badge badge-success bg-gradient-success"><?php echo $kas->tipe_transaksi; ?></span>
                                <?php else : ?>
                                    <span class="badge badge-danger bg-gradient-danger"><?php echo $kas->tipe_transaksi; ?></span>
                                <?php endif; ?>

                            </td>
                            <td>
                                <?php if ($kas->kas_masuk == NULL) : ?>
                                    Rp. <?php echo '0'; ?>
                                <?php else : ?>
                                    Rp. <?php echo number_format($kas->kas_masuk, '0', ',', '.') ?>
                                <?php endif; ?>
                            </td>
                            <td><?php if ($kas->kas_keluar == NULL) : ?>
                                    Rp. <?php echo '0'; ?>
                                <?php else : ?>
                                    Rp. <?php echo number_format($kas->kas_keluar, '0', ',', '.') ?>
                                <?php endif; ?></td>

                        </tr>
                    <?php $no++;
                    endforeach; ?>

                </tbody>
                <tfoot>
                    <tr>
                        <th width="5%"></th>

                        <th></th>
                        <th></th>
                        <th>Jumlah</th>

                        <th>Rp. <?php echo number_format($total_pemasukan, '0', ',', '.'); ?></th>
                        <th>Rp. <?php echo number_format($total_pengeluaran, '0', ',', '.'); ?></th>
                    </tr>
                    <tr>

                        <td></>
                        <td></td>
                        <td></td>
                        <td style="font-size:30px;"><b>SALDO</b></td>
                        <td colspan="2" style="font-size:30px;">
                            <?php $saldo = $total_pemasukan - $total_pengeluaran; ?>
                            <b> Rp. <?php echo number_format($saldo, '0', ',', '.'); ?></b>
                        </td>

                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footer">



        </div>



    </div>

    <div class="pagination col-md-12 text-center mt-3">
        <?php if (isset($pagination)) {
            echo $pagination;
        } ?>
    </div>
</div>
