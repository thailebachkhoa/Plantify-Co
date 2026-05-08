<?php

/**
 * ============================================================================
 * ENTRY POINT - Điểm khởi đầu của ứng dụng web
 * ============================================================================
 * File này là router chính của ứng dụng, xử lý:
 * 1. Khởi tạo session và environment
 * 2. Parse URL để trích xuất controller và method
 * 3. Tự động load các class cần thiết
 * 4. Gọi controller và method tương ứng
 */

// ========== KIỂM TRA MÔI TRƯỜNG CHẠY ==========
// Kiểm tra xem ứng dụng đang chạy qua web (HTTP) hay command line (CLI)
// Nếu là web: $is_web = true, nếu là CLI: $is_web = false
$is_web = php_sapi_name() !== 'cli';

// ========== KHỞI TẠO SESSION (CHỈ CHO WEB) ==========
// Session chỉ cần khởi tạo khi chạy qua HTTP, không cần cho CLI scripts
// session_start() tạo session ID và lưu dữ liệu người dùng
if ($is_web) {
    session_start();
}

// ========== LOAD ENVIRONMENT VARIABLES ==========
// Require file Env.php để có sẵn các phương thức load biến môi trường
require_once __DIR__ . '/../app/Core/Env.php';
// Load các biến từ file .env (.env chứa các giá trị nhạy cảm như:
// DATABASE_HOST, DATABASE_USER, API_KEY, MAIL_PASSWORD, v.v.)
// Nên tuyệt đối không commit file .env lên repository
Env::load(__DIR__ . '/../.env');

// ========== ĐỊNH NGHĨA BASE URL (CHỈ CHO WEB) ==========
// BASE_URL là URL gốc của ứng dụng, dùng để tạo các link và redirect
// Ví dụ: BASE_URL = "http://localhost/btl" hoặc "https://example.com"
if ($is_web) {
    // Xác định giao thức: HTTPS nếu kết nối bảo mật, HTTP nếu thường
    // $_SERVER['HTTPS'] chỉ tồn tại nếu kết nối qua HTTPS
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    
    // Lấy tên miền từ request (ví dụ: localhost, example.com, subdomain.example.com)
    // Sử dụng ?? để có giá trị mặc định nếu HTTP_HOST không tồn tại
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    
    // Lấy đường dẫn thư mục của script (ví dụ: / hoặc /btl hoặc /projects/btl)
    // dirname() lấy phần đường dẫn từ đường dẫn đầy đủ
    // Ví dụ: /var/www/html/btl/public/index.php => /btl/public
    $script = dirname($_SERVER['SCRIPT_NAME']);
    
    // Ghép lại thành BASE_URL hoàn chỉnh
    // Nếu script là "/" hoặc "\\" (root) thì không thêm vào URL
    // Ví dụ: "http://localhost" + "" = "http://localhost"
    // Ví dụ: "http://localhost" + "/btl" = "http://localhost/btl"
    $base_url = $protocol . '://' . $host . ($script === '\\' || $script === '/' ? '' : $script);
    
    // Định nghĩa hằng số BASE_URL để toàn ứng dụng có thể sử dụng
    // rtrim(..., '/') loại bỏ dấu "/" cuối cùng để tránh "//" trong URL
    define('BASE_URL', rtrim($base_url, '/'));
} else {
    // Nếu chạy qua CLI thì không có URL, đặt BASE_URL rỗng
    // CLI không có HTTP_HOST hay SCRIPT_NAME
    define('BASE_URL', '');
}

// ========== PARSE URL VÀ EXTRACT ROUTING INFORMATION ==========
// Lấy giá trị tham số 'url' từ GET request (ví dụ: ?url=product/detail/5)
// Ví dụ:
//   - ?url=product/detail/5 => "product/detail/5"
//   - Không có ?url => "" (rỗng)
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';

// Vệ sinh dữ liệu URL để tránh các kiểu tấn công:
// - XSS (Cross-Site Scripting): <script>alert('xss')</script>
// - Injection: ../../../etc/passwd
// FILTER_SANITIZE_URL loại bỏ các ký tự không hợp lệ trong URL
$url = filter_var($url, FILTER_SANITIZE_URL);

// Tách URL thành mảng theo dấu "/"
// Ví dụ: "product/detail/5" => ["product", "detail", "5"]
// Ví dụ: "" => [""] (mảng có một phần tử rỗng)
$url = explode('/', $url);

// ========== TRÍCH XUẤT CONTROLLER VÀ METHOD TỪ URL ==========
// Quy ước routing:
// - Phần tử [0]: tên controller (ví dụ: "product" => "ProductController")
// - Phần tử [1]: tên method (ví dụ: "detail" => detail())
// - Phần tử [2+]: các tham số (ví dụ: "5" => $id = 5)

// Lấy tên controller từ phần tử đầu tiên của URL
// Nếu URL trống hoặc không có controller, mặc định là "HomeController"
// ucfirst() viết hoa ký tự đầu tiên (product => Product)
// Cộng thêm "Controller" để tạo tên class (Product => ProductController)
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'HomeController';

// VALIDATE controller name: chỉ cho phép chữ cái, số, dấu gạch dưới
// Ngăn chặn các kí tự đặc biệt như: <, >, ", ', etc.
// Ví dụ: "product<script>" => "productscript"
$controllerName = preg_replace('/[^a-zA-Z0-9_]/', '', $controllerName);

// Lấy tên method từ phần tử thứ hai của URL
// Nếu không có method, mặc định là "index"
// Ví dụ: ?url=product => ProductController->index()
// Ví dụ: ?url=product/detail => ProductController->detail()
$methodName = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

// VALIDATE method name: chỉ cho phép chữ cái, số, dấu gạch dưới
// Ngăn chặn các kí tự đặc biệt
$methodName = preg_replace('/[^a-zA-Z0-9_]/', '', $methodName);

// ========== AUTOLOADER - TỰ ĐỘNG LOAD CLASS ==========
// spl_autoload_register() đăng ký một hàm để tự động load class
// Khi dùng "new ProductController()", PHP sẽ tự động gọi hàm này
// Tránh phải require_once từng class một
spl_autoload_register(function ($class) {
    // Nếu class đã được load rồi, không cần load lại
    // Kiểm tra này tránh việc load lặp lại
    if (class_exists($class)) {
        return;
    }

    // Định nghĩa các thư mục nơi class có thể nằm
    // Thứ tự tìm kiếm: Controllers => Core => Models
    $paths = [
        __DIR__ . '/../app/Controllers/' . $class . '.php',    // Controller classes
        __DIR__ . '/../app/Core/' . $class . '.php',           // Core/Library classes
        __DIR__ . '/../app/Models/' . $class . '.php'          // Model/Database classes
    ];

    // Duyệt từng đường dẫn để tìm file chứa class
    foreach ($paths as $path) {
        // Kiểm tra xem file có tồn tại không
        if (file_exists($path)) {
            // Nếu tìm thấy, require file để load class
            require_once $path;
            // Dừng tìm kiếm vì đã tìm thấy
            return;
        }
    }
    
    // Nếu không tìm thấy file ở bất kì đâu, class sẽ gây lỗi
    // (PHP sẽ throw một Fatal error: Class not found)
});

// ========== THỰC THI CONTROLLER & METHOD (CHỈ CHO WEB) ==========
// Chỉ thực thi routing khi chạy qua HTTP, không chạy cho CLI scripts
// Điều này tránh việc thực thi code không cần thiết khi chạy command line
if ($is_web) {
    try {
        // ========== Kiểm tra Controller có tồn tại ==========
        // class_exists() kiểm tra xem class đã được define hay chưa
        // Nếu không tìm thấy, autoloader sẽ không load được
        if (!class_exists($controllerName)) {
            // Controller không tồn tại, ghi log lỗi
            error_log("Controller not found: $controllerName");
            // Trả về status code 404 (Not Found)
            http_response_code(404);
            // Hiển thị thông báo lỗi
            echo "Lỗi 404: Controller '$controllerName' không tồn tại.";
            exit;
        }

        // ========== Khởi tạo instance của Controller ==========
        // new $controllerName() tạo một đối tượng controller
        // Tương đương với: new ProductController()
        $controller = new $controllerName();

        // ========== Kiểm tra Method có tồn tại trong Controller ==========
        // method_exists($object, $method) kiểm tra xem object có method không
        if (!method_exists($controller, $methodName)) {
            // Method không tồn tại trong controller, ghi log lỗi
            error_log("Method not found: $methodName in $controllerName");
            // Trả về status code 404 (Not Found)
            http_response_code(404);
            // Hiển thị thông báo lỗi
            echo "Lỗi 404: Method '$methodName' không tồn tại trong '$controllerName'.";
            exit;
        }

        // ========== EXTRACT CÁC THAM SỐ TỪ URL ==========
        // Các phần tử [0] và [1] của $url là controller và method
        // Các phần tử còn lại [2, 3, 4...] là các tham số
        // Xóa 2 phần tử đầu tiên khỏi mảng $url
        // Ví dụ: ["product", "detail", "5"] => ["detail", "5"] => ["5"]
        unset($url[0]);
        unset($url[1]);

        // Giữ lại các phần tử còn lại làm các tham số truyền vào method
        // array_values() reset lại index của mảng (0, 1, 2... thay vì 2, 3, 4...)
        // Ví dụ: [2 => "5"] => [0 => "5"]
        // Nếu $url rỗng (không có tham số), $params = []
        $params = $url ? array_values($url) : [];

        // ========== GỌI CONTROLLER METHOD VỚI CÁC THAM SỐ ==========
        // call_user_func_array() gọi một hàm/method với các tham số từ mảng
        // Tương đương với: $controller->$methodName($param1, $param2, ...)
        // Ví dụ: ProductController->detail(5)
        // [$controller, $methodName] là một callable (array callback)
        call_user_func_array([$controller, $methodName], $params);

    } catch (Exception $e) {
        // ========== XỬ LÝ EXCEPTION ==========
        // Nếu có lỗi bất kì xảy ra, catch exception để xử lý
        // Ghi lỗi vào log file
        error_log($e->getMessage());
        // Trả về status code 500 (Internal Server Error)
        http_response_code(500);
        // Hiển thị thông báo lỗi (nên hiển thị thông báo user-friendly)
        echo "Lỗi 500: Đã xảy ra lỗi trên server. Vui lòng thử lại sau.";
        exit;
    }
}
