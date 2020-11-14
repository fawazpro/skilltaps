<?php
    function title($sex)
    {
        if($sex == 'm'){
            return 'Mr';
        }elseif($sex == 'f'){
            return 'Mrs';
        }
    }
?>
    <!-- Begin page content -->
    <main class="flex-shrink-0 main-container">
        <!-- page content goes here -->
        <div class="container my-4">
            <div class="card  border-0 shadow-sm ">
                <div class="card-body position-relative">
                    <div class="media">
                        <figure class="avatar avatar-50 mr-3">
                            <img src="assets/img/user3.png" alt="Generic placeholder image">
                        </figure>
                        <div class="media-body">
                            <h5 class="mb-1"><?=title($user['sex']).' '.$user['fname'].' '.$user['lname'] ?></h5>
                            <p class="small text-mute"><?=$user['user_id']?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <h6 class="mb-1">&#x20a6;<?=$user['c_wallet']?></h6>
                            <p class="small text-mute">Transferable Amount</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mb-4">
            <h6 class="page-subtitle">Personal Details <span class="float-right"><a href=""  data-toggle="modal" data-target="#infoedit">Edit<i class="material-icons">edit</i></a></span></h6>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="text-mute">Phone Number</label>
                        <p><?=$user['phone']?></p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="text-mute">Referrer ID</label>
                        <p><?=$user['ref_id']?></p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="text-mute">Email Address</label>
                        <p><?=$user['email']?></p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="text-mute">Bank</label>
                        <p><?=$user['bank']?></p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="text-mute">Account Number</label>
                        <p><?=$user['acc_num']?></p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="text-mute">Account Name</label>
                        <p><?=$user['acc_name']?></p>
                    </div>
                </div>
            </div>
            <!-- <h6 class="page-subtitle"><span>About</span></h6>
            <p class="text-mute">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut labore et dolore magna aliqua.</p> -->

        </div>
    </main>
    <!-- End of page content -->
    <!-- Modal -->
    <div class="modal fade" id="infoedit" tabindex="-1" role="dialog" aria-labelledby="infoEdit" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Edit Personal Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                    <form action="personalinfo" method="post">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="text-mute">Phone Number</label>
                                <input type="number" name="phone" class="form-control" value="<?=$user['phone']?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="text-mute">Bank</label>
                                <select name="bank" class="form-control" required>
                                    <option value="">Select a Bank</option>
                                    <?php foreach ($banks as $key => $bank): ?>
                                    <option value="<?=$bank['name']?>"><?=$bank['name']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="text-mute">Account Number</label>
                                <input type="number" name="acc_num" class="form-control" value="<?=$user['acc_num']?>">
                                
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="text-mute">Account Name</label>
                                <input type="text" name="acc_name" class="form-control" value="<?=$user['acc_name']?>">
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        $('#exampleModal').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var modal = $(this);
            // Use above variables to manipulate the DOM
            
        });
    </script>

