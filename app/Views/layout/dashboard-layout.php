<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- csrf -->
  <meta name="csrf-token" content="<?= csrf_hash() ?>" class="csrf" />
  <link href="<?= base_url('dataTables/css/dataTables.bootstrap.min.css'); ?>" rel="stylesheet" />
  <link href="<?= base_url('dataTables/css/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet" />
  <title><?= $this->renderSection('title') ?></title>
  <base href="/">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
<?= view('components/navbar-dashboard-layout') ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?= view('components/aside-dashboard-layout') ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?= $this->renderSection('breadcrumb') ?>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
       <?= $this->renderSection('content') ?>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- footer -->
<?= view('components/footer-dashboard-layout') ?>
  <!-- ./footer -->

</div>
<!-- ./wrapper -->


<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<!-- datatable -->
<script src="<?= base_url('datatables/js/jquery.dataTables.js'); ?>" ></script>
<script src="<?= base_url('datatables/js/dataTables.bootstrap4.min.js'); ?>" ></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> -->

<!-- sweetalert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script> -->

<?= $this->renderSection('script') ?>

</body>
</html>
