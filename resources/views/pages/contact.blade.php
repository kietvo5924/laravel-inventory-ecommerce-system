@extends('layouts.main')

@section('title', 'Liên Hệ')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container mt-4">
        <h2 class="mb-4">Liên Hệ Với Chúng Tôi</h2>
        <div class="row">
            <div class="col-md-6">
                <h4>Thông Tin Liên Hệ</h4>
                <p><strong>Địa Chỉ:</strong> 123 Đường XYZ, Quận ABC, TP. Hồ Chí Minh</p>
                <p><strong>Điện Thoại:</strong> (84) 123 456 789</p>
                <p><strong>Email:</strong> StockManager@gmail.com</p>
                <p><strong>Giờ Làm Việc:</strong> Thứ Hai - Thứ Sáu: 8:00 AM - 6:00 PM</p>
            </div>
            <div class="col-md-6">
                <h4>Gửi Tin Nhắn</h4>
                @auth
                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ Auth::user()->name }}" readonly>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ Auth::user()->email }}" readonly>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Tin Nhắn</label>
                            <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
                            @error('message')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi Tin Nhắn</button>
                    </form>
                @else
                    <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để gửi tin nhắn liên hệ.</p>
                @endauth
            </div>
        </div>
    </div>
@endsection
