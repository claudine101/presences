<!DOCTYPE HTML>

<html>

<head>
<title>Virtual Payment Client Example</title>

 <?php include VIEWPATH.'templates/header.php'; ?>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>

</head>

<body>
    
</body>
</html>

<script type="text/javascript">

    sucess_alert();

    function sucess_alert(){

    Swal.fire({
        // position: 'top-end',
        icon: 'success',
        title: 'Paiment effectuer avec succès',
        showConfirmButton: false,
        timer: 6000,
        
       })

  }


</script>