# Hệ Thống Đăng Nhập Bằng Google và Facebook


**Họ và tên:** Lê Minh Quân  Lớp: D18CNPM2

**Mã sinh viên:** 23810310115  

**Lớp:** D18CNPM2 

MSV: 23810310115

**Ngày thực hành:** 20/04/2026 (N2)

Thực hành 20/04/2026(N2): Xây dựng chức năng đăng nhập bằng Google và Facebook sử dụng Laravel

## Yêu Cầu Hệ Thống

- PHP >= 8.2
- Composer
- Node.js & npm
- Laravel 12.x
- SQLite hoặc MySQL

---

## Cài Đặt

### 1. Clone Repository

```bash
git clone https://github.com/Milkoi/LoginGoogleFacebook.git
cd LoginGoogleFacebook
```

### 2. Cài Đặt Dependencies

```bash
# Cài đặt PHP dependencies
composer install

# Cài đặt Node dependencies
npm install
```

### 3. Cấu Hình Environment

```bash
# Tạo file .env từ .env.example
cp .env.example .env

# Tạo Application Key
php artisan key:generate
```

### 4. Chạy Migration

```bash
# Tạo các bảng trong database
php artisan migrate
```

### 5. Build Frontend

```bash
# Build Tailwind CSS & Vite
npm run build

# Hoặc chạy dev server
npm run dev
```

### 6. Chạy Ứng Dụng

```bash
php artisan serve
```

Ứng dụng sẽ chạy tại: `http://localhost:8000`

---

## 🔐 Cấu Hình Google OAuth 2.0

### Bước 1: Tạo Google Project

1. Truy cập [Google Cloud Console](https://console.cloud.google.com/)
2. Tạo một project mới hoặc chọn project hiện có
3. Vào **APIs & Services** → **Credentials**
4. Nhấp **Create Credentials** → **OAuth 2.0 Client ID**
5. Chọn **Web Application**

### Bước 2: Cấu Hình URI Callback

Thêm authorized redirect URIs:
```
http://localhost:8000/auth/google/callback
http://yourdomain.com/auth/google/callback
```

### Bước 3: Lấy Client ID và Secret

- Sao chép **Client ID**
- Sao chép **Client Secret**

### Bước 4: Cập Nhật File .env

```env
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

---

## Cấu Hình Facebook OAuth 2.0

### Bước 1: Tạo Facebook App

1. Truy cập [Facebook Developers](https://developers.facebook.com/)
2. Đăng nhập hoặc tạo tài khoản
3. Vào **My Apps** → **Create App**
4. Chọn loại ứng dụng **Consumer** 
5. Điền thông tin và tạo app

### Bước 2: Cấu Hình Facebook Login

1. Vào **Settings** → **Basic** để lấy **App ID** và **App Secret**
2. Trong menu, chọn **Facebook Login** → **Settings**
3. Thêm OAuth Redirect URI:
```
http://localhost:8000/auth/facebook/callback
http://yourdomain.com/auth/facebook/callback
```

### Bước 3: Cấu Hình Valid OAuth Redirect URIs

1. Vào **Settings** → **Basic**
2. Cuộn xuống **App Domains** và thêm domain của bạn
3. Vào **Facebook Login** → **Settings** → **Valid OAuth Redirect URIs** và thêm callback URL

### Bước 4: Cập Nhật File .env

```env
FACEBOOK_CLIENT_ID=your_facebook_app_id_here
FACEBOOK_CLIENT_SECRET=your_facebook_app_secret_here
FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/facebook/callback
```

---

## Cấu Trúc Dự Án

```
LoginGoogleFacebook/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── Auth/
│   │           └── SocialAuthController.php
│   ├── Models/
│   │   └── User.php
│   └── Services/
│       └── SocialAuthService.php
├── config/
│   └── services.php
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   └── 2026_04_20_001541_add_student_id_to_users_table.php
│   └── seeders/
├── resources/
│   └── views/
│       ├── auth/
│       │   └── login.blade.php
│       └── dashboard.blade.php
├── routes/
│   └── web.php
└── ...
```

---

##  Hướng Dẫn Sử Dụng

### 1. Truy Cập Trang Đăng Nhập

```
http://localhost:8000/login
```

### 2. Nhấp Nút Đăng Nhập

- **Google**: Đăng nhập bằng tài khoản Google
- **Facebook**: Đăng nhập bằng tài khoản Facebook

### 3. Xác Nhận Quyền

Cho phép ứng dụng truy cập thông tin cơ bản (tên, email, avatar)

### 4. Xem Thông Tin Cá Nhân

Dashboard sẽ hiển thị:
- Avatar người dùng
- Tên tài khoản
- Email
- Nhà cung cấp (Provider)
- Họ tên sinh viên
- Mã sinh viên

### 5. Đăng Xuất

Nhấp nút **Đăng xuất** để kết thúc phiên

---

## Database Schema

### Bảng Users

| Cột | Kiểu | Mô Tả |
|-----|------|-------|
| id | bigint | ID duy nhất |
| name | string | Tên người dùng |
| student_id | string | Mã sinh viên |
| email | string | Email (unique) |
| avatar | string | URL ảnh đại diện |
| provider | string | Nhà cung cấp (google/facebook) |
| provider_id | string | ID từ nhà cung cấp |
| email_verified_at | timestamp | Thời gian xác minh email |
| password | string | Mật khẩu (được hash) |
| remember_token | string | Token "Remember me" |
| created_at | timestamp | Thời gian tạo |
| updated_at | timestamp | Thời gian cập nhật |

---

## Luồng Xác Thực

```
┌─────────────────┐
│  Người dùng     │
└────────┬────────┘
         │ Nhấp "Đăng nhập Google/Facebook"
         ▼
┌─────────────────────────────────────┐
│ SocialAuthController::redirect()     │ ← Chuyển hướng đến Google/Facebook
└────────┬────────────────────────────┘
         │ OAuth Provider xác thực
         ▼
┌─────────────────────────────────────┐
│ SocialAuthController::callback()     │ ← Nhận response từ Provider
└────────┬────────────────────────────┘
         │ Lấy dữ liệu người dùng
         ▼
┌─────────────────────────────────────┐
│ SocialAuthService::loginOrCreateUser │ ← Kiểm tra/tạo user trong DB
└────────┬────────────────────────────┘
         │ Đăng nhập người dùng
         ▼
┌─────────────────┐
│   /dashboard    │ ← Hiển thị thông tin
└─────────────────┘
```

---

## 🛡️ Xử Lý Lỗi

Ứng dụng xử lý các lỗi sau:

- **Nhà cung cấp không hợp lệ** → Chuyển hướng đến login với thông báo lỗi
- **Người dùng từ chối quyền** → Thông báo và yêu cầu thử lại
- **Token lỗi/hết hạn** → Thông báo lỗi xác thực
- **Email không được cấp** → Sử dụng email placeholder

---

## 📝 Code Overview

### SocialAuthController.php

```php
// Chuyển hướng đến Google/Facebook
public function redirect(string $provider): RedirectResponse

// Nhận callback từ Provider
public function callback(string $provider): RedirectResponse

// Đăng xuất người dùng
public function logout(): RedirectResponse
```

### SocialAuthService.php

```php
// Đăng nhập hoặc tạo người dùng mới
public function loginOrCreateUser($socialUser, string $provider): User
```

--

- Kiểm tra `GOOGLE_CLIENT_ID` và `FACEBOOK_CLIENT_ID` trong `.env`
- Đảm bảo không có khoảng trắng thừa

### Lỗi: "Redirect URI mismatch"

- Kiểm tra `GOOGLE_REDIRECT_URI` và `FACEBOOK_REDIRECT_URI`
- Đảm bảo khớp với cấu hình trên Google Console/Facebook Developers

### Lỗi: "TokenMismatchException"

- Xóa cookie và cache
- Chạy `php artisan cache:clear`

### Chưa nhận được avatar

- Facebook có thể không cấp avatar mặc định
- Kiểm tra quyền `public_profile` trong cấu hình

---


