<!DOCTYPE html>
<html>
<head>
    <title>Enregistrement d'Arrivée</title>
</head>
<body>
    <h1>Télécharger votre QR Code</h1>
    <form action="<?= site_url('arrival/upload') ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="qr_code_image" accept="image/*" required>
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
