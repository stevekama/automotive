<?php require_once('../init/initialization.php');
$title = "Admin || Dashboard";
$page = 'dashboad';
require_once(PUBLIC_PATH  . DS . "layouts" . DS . "admin" . DS . "header.php"); ?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard </li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="numMebersRequest"></h3>

                        <p>Member Requests</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="<?php echo base_url(); ?>admin/members/requests.php" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="numMembers"></h3>

                        <p>Active Members</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="<?php echo base_url(); ?>admin/members/index.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="numVehicleRequests"></h3>

                        <p>Vehicle Requests</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="<?php echo base_url(); ?>admin/vehicles/request.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="numActiveVehicles"></h3>

                        <p>Vehicles</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="<?php echo base_url(); ?>admin/vehicles/index.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Active Members</h3>
                    </div>
                    <div id="loadMembers" class="card-body table-responsive p-0">
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->

    <div class="modal fade" id="viewMemberModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">View Member</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div id="memberProfileVal" class="col-md-3 col-sm-12">
                        </div>
                        <div class="col-md-9 col-sm-12 table-responsive p-0">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Full Names</th>
                                        <td id="memberFullNames"></td>
                                    </tr>
                                    <tr>
                                        <th>Phone Number</th>
                                        <td id="memberPhone"></td>
                                    </tr>
                                    <tr>
                                        <th>Email Address</th>
                                        <td id="memberEmail"></td>
                                    </tr>
                                    <tr>
                                        <th>Date of birth</th>
                                        <td id="memberDOB"></td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td id="memberGender"></td>
                                    </tr>
                                    <tr>
                                        <th>Location</th>
                                        <td id="memberLocation"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</section>
<!-- /.content -->

<?php require_once(PUBLIC_PATH . DS . "layouts" . DS . "admin" . DS . "footer.php"); ?>

<script>
    $(document).ready(function() {

        find_active_members();
        find_requests_members();
        find_active_vehicles();
        find_requests_vehicles();

        function find_active_members() {
            var status = 'ACTIVE';
            $.ajax({
                url: "<?php echo base_url(); ?>api/members/fetch_dashboard.php",
                type: "POST",
                data: {
                    status: status
                },
                dataType: "json",
                success: function(data) {
                    $('#numMembers').html(data.num_members);
                    $('#loadMembers').html(data.members);
                }
            });
        }

        function find_requests_members() {
            var status = 'REQUEST';
            $.ajax({
                url: "<?php echo base_url(); ?>api/members/fetch_dashboard.php",
                type: "POST",
                data: {
                    status: status
                },
                dataType: "json",
                success: function(data) {
                    $('#numMebersRequest').html(data.num_members);
                }
            });
        }

        // view member 
        $(document).on('click', '.view', function() {
            var member_id = $(this).attr('id');
            var action = 'FETCH_MEMBER';
            $.ajax({
                url: "<?php echo base_url(); ?>api/members/members.php",
                type: "POST",
                data: {
                    action: action,
                    member_id: member_id
                },
                dataType: "json",
                success: function(data) {
                    $('#memberProfileVal').html('<img class="profile-user-img img-fluid img-circle" src="<?php echo public_url(); ?>storage/users/' + data.image + '" alt="User profile picture">');
                    $('#memberFullNames').html(data.fullnames);
                    $('#memberPhone').html(data.phone);
                    $('#memberEmail').html(data.email);
                    $('#memberDOB').html(data.dob);
                    $('#memberGender').html(data.gender);
                    $('#memberLocation').html(data.location);
                    $('#viewMemberModal').modal('show');
                }
            });
        });


        function find_active_vehicles() {
            var status = 'ACTIVE';
            $.ajax({
                url: "<?php echo base_url(); ?>api/vehicles/fetch_for_admin_dashboard.php",
                type: "POST",
                data: {
                    status: status
                },
                dataType: "json",
                success: function(data) {
                    $('#numActiveVehicles').html(data.num_vehicles);
                }
            });
        }

        function find_requests_vehicles() {
            var status = 'REQUEST';
            $.ajax({
                url: "<?php echo base_url(); ?>api/vehicles/fetch_for_admin_dashboard.php",
                type: "POST",
                data: {
                    status: status
                },
                dataType: "json",
                success: function(data) {
                    $('#numVehicleRequests').html(data.num_vehicles);
                }
            });
        }

    });
</script>