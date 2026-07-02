HƯỚNG DẪN CÀI ĐẶT VÀ SỬ DỤNG HỆ THỐNG QUẢN LÝ THIẾT BỊ QR

1. MÔ TẢ CHUNG

Đây là hệ thống quản lý thiết bị công nghệ thông tin trên mạng nội bộ (LAN), sử dụng PHP, MySQL và QR code.
Hệ thống hỗ trợ: đăng nhập, quản lý thiết bị, xem chi tiết, tạo QR, xuất dữ liệu Excel/CSV, dashboard thống kê.

2. YÊU CẦU HỆ THỐNG

- Windows
- XAMPP hoặc PHP và MySQL cài sẵn
- Trình duyệt web hiện đại

3. CÀI ĐẶT

Bước 1: Sao chép mã nguồn vào thư mục máy chủ
- Đặt toàn bộ thư mục dự án vào `C:\xampp\htdocs\qlthietbi`

Bước 2: Khởi động XAMPP
- Mở `XAMPP Control Panel`
- Bật Apache và MySQL

Bước 3: Chuẩn bị cơ sở dữ liệu
- Mở phpMyAdmin hoặc dùng MySQL client
- Tạo database tên `ql_thietbi`
- Nếu cần, import cấu trúc bảng từ mã nguồn (hoặc để hệ thống tự tạo bảng `users` và thêm các cột thiết bị khi truy cập)

Bước 4: Khởi động server
- Mở file `Start.bat` trong thư mục dự án
- File sẽ mở địa chỉ `http://localhost:3000/`

4. CẤU TRÚC DỰ ÁN

- `index.php`: trang chủ sau khi đăng nhập
- `login.php`: trang đăng nhập
- `logout.php`: đăng xuất
- `dashboard.php`: trang thống kê thiết bị
- `add.php`: thêm thiết bị mới
- `list.php`: danh sách thiết bị, tìm kiếm, sửa, xóa
- `info.php`: chi tiết thiết bị
- `taoqr.php`: tạo QR code động
- `export_excel.php`: xuất danh sách thiết bị Excel/CSV
- `auth.php`: kiểm tra đăng nhập và phân quyền
- `db.php`: kết nối MySQL
- `assets/style.css`: giao diện CSS

5. TÀI KHOẢN MẶC ĐỊNH

- Quản trị viên:
  + Username: admin
  + Password: admin123
- Cán bộ:
  + Username: staff
  + Password: staff123

6. HƯỚNG DẪN SỬ DỤNG

Bước 1: Truy cập `http://localhost:3000/login.php`
Bước 2: Đăng nhập bằng tài khoản đã có
Bước 3: Sử dụng menu để chuyển tới:
- Trang chủ
- Dashboard thống kê
- Thêm thiết bị
- Danh sách thiết bị
- Đăng xuất

Bước 4: Quản lý thiết bị
- Thêm thiết bị: nhập thông tin chi tiết và lưu
- Danh sách: tìm kiếm, sửa, xóa thiết bị
- Chi tiết: xem thông tin đầy đủ và QR
- Xuất Excel/CSV: tải về báo cáo thiết bị

7. LƯU Ý KHI SỬ DỤNG

- Hệ thống hoạt động trên mạng nội bộ, không cần Internet
- QR code trình duyệt tạo động và liên kết tới trang `info.php?id=...`
- Nếu cần thêm chức năng, mở rộng theo module: báo hỏng, sửa chữa, kiểm kê, quản lý người dùng

8. KHẮC PHỤC LỖI THƯỜNG GẶP

- Nếu không đăng nhập được: kiểm tra database `ql_thietbi` và bảng `users`
- Nếu không kết nối được MySQL: kiểm tra cấu hình `db.php`
- Nếu không truy cập được `http://localhost:3000/`: đảm bảo `Start.bat` chạy đúng và cổng 3000 chưa bị chặn

9. MỞ RỘNG TƯƠNG LAI

- Thêm chức năng đăng ký người dùng
- Thêm phân quyền chi tiết
- Thêm báo hỏng và quản lý sửa chữa
- Thêm kiểm kê và báo cáo nâng cao
- Thêm upload ảnh trực tiếp
