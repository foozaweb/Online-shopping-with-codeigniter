<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $this->db->get('chb_settings')->row_array()['sitename']; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo $this->db->get('chb_settings')->row_array()['logo']; ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo $this->db->get('chb_settings')->row_array()['logo']; ?>" type="image/x-icon">

    <!-- Google Fonts -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet"> -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,400italic,300italic,300,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo base_url() ?>css/assets/bootstrap.min.css">

    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="<?php echo base_url() ?>css/assets/font-awesome.min.css">

    <!-- Animate Css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>css/assets/animate.css">

    <!-- Owl Slider -->
    <link rel="stylesheet" href="<?php echo base_url() ?>css/assets/owl.carousel.min.css">

    <!-- Custom Style -->
    <link rel="stylesheet" href="<?php echo base_url() ?>css/assets/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>css/style.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>css/assets/responsive.css">

</head>

<?php $this->load->view('template/functions'); ?>