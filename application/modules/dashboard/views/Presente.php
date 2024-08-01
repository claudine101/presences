<!DOCTYPE html>
<html>
<head>
    <title>Upload QR Code</title>
</head>
<body>
    <h1>Upload Your QR Code</h1>
    <form action="<?= base_url('dashboard/Arrival/upload') ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="qr_code_image" accept="image/*" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
