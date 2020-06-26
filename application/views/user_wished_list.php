
<?php $descLength = 50; ?>
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-header">
            <h1>
              All Users List Who Wished You on your Birthday
            </h1>

            <?php if($this->session->flashdata('category_success')) { ?>
                <div class="alert alert-success"> <?= $this->session->flashdata('category_success') ?> </div>
            <?php } ?>
            <?php if ($this->session->flashdata('category_error')) { ?>
                <div class="alert alert-danger"> <?= $this->session->flashdata('category_error') ?> </div>
            <?php } ?>

        </div> <!-- Page Header -->


            <div class="table-wrapper">
              <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th> S.NO </th>
                            <th> Sent By </th>                                                       
                            <th> Message </th>                           
                            <th> Date </th>							         
                        </tr>  
                    </thead>
                    <tbody>

                        <?php if(!empty($all_wishes)){ 

                              $i = 1;
                              foreach($all_wishes as $annc){ ?>
                            
                                <tr class="view_items" >

                                  <td><?= $i; ?></td>

                                  <td><?= $annc['first_name']." ".$annc['last_name'] ?></td>
                                  <td><?= $annc['message'] ?></td>
                                  <td><?= $annc['created_date'] ?></td>
                               

                                </tr> 
                        <?php $i++;  }  }  ?> 
                                                 
                    </tbody>
              </table>
          </div>

  <!-- ==================================================================================================================== -->

        

        <!-- PAGE CONTENT ENDS -->  
    </div>
</div> <!-- /.main-content ends -->



<!-- jQuery -->
<!-- <script src="assets/js/jquery.js"></script> -->
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>



<script>
  $(document).ready(function() {

    $('#dynamic-table').DataTable({
        dom: 'lBfrtip',
        buttons: [
            //'csv', 'excel', 'pdf'//, 'print'
        ]
    });
 });

// ======================================================================================



  // common validations 
  var timeout = 3000; // in miliseconds (3*1000)
  $('.alert').delay(timeout).fadeOut(300);




</script>
