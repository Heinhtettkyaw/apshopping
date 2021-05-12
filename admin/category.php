<?php
session_start();
 require '../config/config.php';
require '../config/common.php';
if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
	header('Location: login.php');
}
if($_SESSION['role']!=1){
		header('Location: login.php');
}
?>

<?php include 'header.php';?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-">AP_Shopping</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>-->
				<a href="cat_add.php" type="button" class="btn btn-success"><i class="fa fa-plus">   </i>New Category</a>
            </ol>
          </div> <!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
         <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Category  Table</h3>
              </div>
              <?php
				if (!empty($_GET['pageno'])){
          $pageno= $_GET['pageno'];
        }else{
			$pageno=1;
		}
				$numOfrecs=5;
				$offset= ($pageno-1)* $numOfrecs;
        if(empty($_POST['search'])){
			
				$stmt= $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
				$stmt->execute();
				$rawResult= $stmt->fetchAll();
				$total_pages= ceil(count($rawResult)/ $numOfrecs);
				
				$stmt= $pdo->prepare("SELECT * FROM categories ORDER BY id DESC LIMIT $offset,$numOfrecs");
				$stmt->execute();
				$result= $stmt->fetchAll();

		}else
		{
				$searchKey=$_POST['search'];
				$stmt= $pdo->prepare("SELECT * FROM categories WHERE name LIKE '%$searchKey%' ORDER BY id DESC");
				$stmt->execute();
				$rawResult= $stmt->fetchAll();
				$total_pages= ceil(count($rawResult)/ $numOfrecs);
				
				$stmt= $pdo->prepare("SELECT * FROM categories WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
				$stmt->execute();
				$result= $stmt->fetchAll();
		}
				?>
 


              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th style="width: 130px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
					  if ($result){
						  $i=1;
						  foreach ($result as $value){?>
					   <tr>

                      <td><?php echo $i; ?></td>
                      <td><?php echo escape($value['name']); ?></td>
                      <td> <?php echo escape($value['description']); ?></td>
                      <td>
						  <div >
						<a href="cat_edit.php?id=<?php echo $value['id']; ?>" type="button" class="btn btn-warning">
					  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
  						<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  						<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
						</svg>

							</a>
							  <a href="cat_delete.php?id=<?php echo $value['id']; ?>" onClick="return confirm('Are you sure you want to delete?')" type="button" class="btn btn-danger">
							  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  								<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
  								<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
							  </svg>

							  </a>
							  </div>
					  </td>
                    </tr>

							  <?php
							  $i++;
						  }
					  }
                      ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                <li class="page-item">
                    <a class="page-link" href="?pageno=1">First</a>
                  </li>
                  <li class="page-item"<?php if($pageno <=1){echo 'disabled';} ?>>
               <a class="page-link" href="<?php if($pageno<=1){ echo '#';} else {echo "?pageno=".($pageno-1);}?>">Previous</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#"><?php echo $pageno; ?></a>
                  </li>
                  <li class="page-item"<?php if($pageno >= $total_pages){echo 'disabled';} ?>>
                    <a class="page-link" href="<?php if ($pageno>= $total_pages){echo '#';}else {echo "?pageno=".($pageno+1);} ?>">Next</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="?pageno=<?php echo $total_pages;?>">Last</a>
                  </li> 
                </ul>
              </div>
            </div>
            <!-- /.card -->


            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->

  <footer class="main-footer">

<div class="float-right d-none d-sm-inline">
   <a href="logout.php" type="button" class="btn btn-danger">
       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
<path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
<path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
</svg>Logout
       </a>
   </div>
 <!-- Default to the left -->
 <strong>Copyright &copy; 2021-2022<a href="https://www.facebook.com/jeremie7577"> HeinHtetKyaw</a>.</strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
 