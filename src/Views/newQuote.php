<?= $this->include('julio101290\boilerplate\Views\load\select2') ?>
<?= $this->include('julio101290\boilerplate\Views\load\datatables') ?>
<?= $this->include('julio101290\boilerplate\Views\load\nestable') ?>
<!-- Extend from layout index -->
<?= $this->extend('julio101290\boilerplate\Views\layout\index') ?>

<!-- Section content -->
<?= $this->section('content') ?>

<?= $this->include('julio101290\boilerplatequotes\Views\modulesQuotes/dataHeadQuotes') ?>
<?= $this->include('julio101290\boilerplatequotes\Views\modulesQuotes/productosModalQuotes') ?>
<?= $this->include('julio101290\boilerplatequotes\Views\modulesSells/moreInfoRow') ?>
<?= $this->include('julio101290\boilerplatequotes\Views\modulesProducts/modalCaptureProducts') ?>
<?= $this->include('julio101290\boilerplatequotes\Views\modulesCustumers/modalCaptureCustumers') ?>





<?= $this->endSection() ?>
