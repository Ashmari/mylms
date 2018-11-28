<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href=<?php echo base_url('public/semantic/dist/semantic.css'); ?>>
  <style>
    body > .grid {
      height: 100%;
    }
    .column {
      max-width: 450px;
    }
    .panels {
      display: grid;
    }
    .panel {
      display: none;
      grid-column: 1;
      grid-row: 1;
      margin: 0 !important;
    }
    .activated {
      display: block !important;
    }
    .deactivated {
      display: none !important;
    }
  </style>
  <script src=<?php echo base_url('public/jquery/jquery-3.1.1.min.js'); ?>></script>
  <script src=<?php echo base_url('public/semantic/dist/semantic.js'); ?>></script>
<?php if (isset($result)): ?>
  <script>
    var result = <?= $result; ?>;
  </script>
<?php endif; ?>
</head>
<body>