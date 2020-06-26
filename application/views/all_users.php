
<?php $descLength = 50; ?>
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-header">
            <h1>
              All Users
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
                            <th> First Name </th>                                                       
                            <th> Last Name </th>                           
                            <th> DOB </th>							         
                            <th> Action </th>
                        </tr>  
                    </thead>
                    <tbody>

                        <?php if(!empty($all_users)){ 

                              $i = 1;
                              foreach($all_users as $annc){ ?>
                            
                                <tr class="view_items" >

                                  <td><?= $i; ?></td>

                                  <td><?= $annc['first_name'] ?></td>
                                  <td><?= $annc['last_name'] ?></td>
                                  <td><?= $annc['dob'] ?></td>
                                  <td>

                                    <?php $monthdate = date("m-d", strtotime($annc['dob'])) ;

                                         if($monthdate == date("m-d")){ ?>

                                           <button type="button" class="btn btn-xs btn-primary" title="Decline" data-toggle="modal" data-target="#myModal<?php echo $i; ?>">Wish Him/Her</button> 
                                           

                                     <?php } ?>  

                                     <div id="myModal<?php echo $i ?>" class="modal fade" role="dialog">
                                          <div class="modal-dialog">
                                              <!-- Modal content-->
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  <h4 class="modal-title">Message</h4>
                                                </div>
                                                  <form action="<?= base_url("send-message/").$annc['user_id']; ?>" method="post">                                                                                
                                                        <div class="modal-body">
                                                          <textarea name="message"  placeholder="Type message here..." required="" style ="width:100%" class="decline-class" cols="25" rows="4"></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                          <button type="submit" class="btn btn-default" name="submit" value="submit">Submit</button>
                                                        </div>
                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                   
                                  </td>

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
