<?= $this->extend('layout/dashboard-layout') ?>

<?= $this->section('title') ?>
<?= $pageTitle ?>
<?= $this->endSection() ?>


<?= $this->section('breadcrumb') ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> <?= $pageTitle ?> </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href=" <?= route_to('dashboard.home') ?> ">Home</a></li>
              <li class="breadcrumb-item active"> <?= $pageTitle ?> </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    home content
<?= $this->endSection() ?>