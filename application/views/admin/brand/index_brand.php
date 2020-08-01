<?php
$id = $this->session->userdata('id');
$user = $this->user_model->user_detail($id);
?>

<!-- Progress Table start -->
<div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                            <?php
//Notifikasi
if ($this->session->flashdata('message')) {
    echo '<div class="alert alert-success alert-dismissable fade show">';
    echo '<button class="close" data-dismiss="alert" aria-label="Close">×</button>';
    echo $this->session->flashdata('message');
    echo '</div>';
}
echo validation_errors('<div class="alert alert-warning">', '</div>');

?>
                            <?php echo form_open('admin/brand');?>
                           
                                            <div class="form-row d-flex justify-content-between align-items-center ">
                                            
                                                <div class="col-sm-7 my-1 row">
                                                
                                                    <div class="col-6">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i class="ti-user"></i></div>
                                                        </div>
                                                        <input type="text" class="form-control" name="keyword" placeholder="Cari Brand">
                                                    </div>
                                                    </div>
                                                    <div class="col-auto">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                   
                                                </div>
                                                
                                                </div>
                                                <?php echo form_close();?>
                                               
                                                
                                                <?php include "create_brand.php";?>

                                            </div>
                                    
                                        <hr>
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center">
                                            <thead class="text-uppercase">
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Nama Brand</th>
                                                    <th scope="col">action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; foreach ($brand as $brand) :?>
                                                  
                                                <tr>
                                                    <th scope="row"><?php echo $no;?></th>
                                                    <td><?php echo $brand->brand_name;?></td> 
                                                    <td>
                                                        <?php include "update_brand.php";?>
                                                        <?php include "delete_brand.php";?>
                                                    </td>
                                                </tr>
                                                
                                                <?php $no++; endforeach;  ?>
                                               
                                            </tbody>
                                        </table>

                                        <div class="pagination col-md-12 text-center mt-3">
        <?php if (isset($pagination)) {
            echo $pagination;
        } ?>
    </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Progress Table end -->