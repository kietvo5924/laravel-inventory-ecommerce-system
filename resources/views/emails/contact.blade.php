<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ Mới</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-primary">Thông Tin Liên Hệ</h2>
        <div class="card">
            <div class="card-body">
                <p><strong>Tên:</strong> {{ $data['name'] }}</p>
                <p><strong>Email:</strong> {{ $data['email'] }}</p>
                <p><strong>Tin Nhắn:</strong></p>
                <p class="border p-2">{{ $data['message'] }}</p>
            </div>
        </div>
    </div>
</body>

</html>
