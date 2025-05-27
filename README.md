<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Xây dựng trang web thuyện nguyện theo Repository Design Pattern (Laravel)

## Ngôn ngữ và Kỹ năng

Dưới đây là một số ngôn ngữ lập trình và kỹ năng mà chúng tôi đã dùng để phát triển dự án:
- **Back-end:**
  - Laravel
 
- **Front-end:**
  - HTML
  - CSS
  - SCSS
  - Bootstrap
  - Javascript
  - JQuery
  - Livewire
  - Alpine.js
    
- **Cơ sở dữ liệu:**
  - MySQL

- **Công cụ và thư viện:**
  - Git
  - Datatable (server-side)
  - Spatie Media Library
  - Spatie Laravel Permission
  - CKeditor

## Tính Năng Chính
  - **Quản lý người dùng:**
    - Tạo, đọc, cập nhật, khóa tài khoản người dùng, phân quyền và vai trò
    - Tìm kiếm, lọc và sắp xếp người dùng theo trạng thái, vai trò

  - **Quản lý chiến dịch:**
    - Tạo, chỉnh sửa chiến dịch
    - Tìm kiếm nâng cao, lọc và sắp xếp theo ngày, địa điểm, trạng thái, danh mục
    - Theo dõi tiến độ, tình trạng, thiết lập mốc thời gian

  - **Quản lý quyên góp:**
    - Ghi nhận và theo dõi các khoản quyên góp cùng thông tin người quyên góp
    - Tìm kiếm, lọc và xuất dữ liệu quyên góp
    - Tự động xác nhận quyên góp

  - **Quản lý tình nguyện viên:**
    - Quản lý hồ sơ và lịch sẵn sàng của tình nguyện viên
    - Đánh giá tình nguyện viên

  - **Thanh toán tích hợp:**
    - Kết nối VNPay, Momo và mã QR để xử lý thanh toán tự động
    - Xác nhận và đối soát giao dịch tự động

  - **Báo cáo & Thống kê:**
    - Bảng điều khiển trực quan theo thời gian thực: tiến độ chiến dịch, tổng số quyên góp, mức độ tham gia của tình nguyện viên
    - Xuất báo cáo Excel theo ngày, tháng, quý hoặc khoảng thời gian tùy chọn
    
  - **Phát triển API:**
    - Thiết kế và triển khai API RESTful cho các module: người dùng, chiến dịch, quyên góp, tình nguyện viên, thanh toán
    - Phiên bản hóa endpoint và định dạng phản hồi nhất quán (JSON) cho frontend
    - Giao diện dễ tương tác và kiểm thử api (Scramble – Laravel OpenAPI (Swagger) Documentation Generator)

## Hướng Dẫn Cài Đặt
1. Clone repository: `git clone https://github.com/tienhai488/kltn-backend` 
2. composer install
3. yarn install
4. php artisan migration (Cài đặt DB trong .env và chỉnh APP_URL=http://localhost:8000)
5. php artisan db:seed (Chạy dữ liệu db, xem thông tin đăng nhập tại database/seeders/UserSeeder.php)
6. Chạy chương trình (php artisan serve && yarn dev)

