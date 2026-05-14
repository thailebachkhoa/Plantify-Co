<?php

/**
 * Shop Controller (Phiên bản MVC Chuẩn với Model)
 */
class ShopController extends BaseController
{
    public function index()
    {
        // 1. Khởi tạo Model
        require_once BASE_PATH . '/app/Models/Product.php';
        $productModel = new Product();
        $user = Auth::check() ? Auth::user() : null;

        // 2. Tính toán phân trang
        $limit = 8;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($page - 1) * $limit;

        // 3. Gọi Model để lấy Data thay vì viết SQL trực tiếp
        $totalProducts = $productModel->countAll();
        $totalPages = $totalProducts > 0 ? ceil($totalProducts / $limit) : 1;

        $products = $productModel->getPaginated($limit, $offset);

        // Đảm bảo là mảng
        if (!is_array($products)) $products = [];

        $this->view('pages/shop', [
            'user' => $user,
            'products' => $products,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function detail($id = null)
    {
        if (!$id) {
            $this->redirect('shop');
            return;
        }

        require_once BASE_PATH . '/app/Models/Product.php';
        $productModel = new Product();
        $user = Auth::check() ? Auth::user() : null;

        // Gọi Model để tìm sản phẩm
        $product = $productModel->findById($id);

        if (empty($product)) {
            $this->redirect('shop');
            return;
        }

        // Gọi Model để lấy sản phẩm liên quan
        $relatedProducts = $productModel->getRelated($id, 4);
        if (!is_array($relatedProducts)) $relatedProducts = [];

        $this->view('pages/product-detail', [
            'user' => $user,
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }

    /**
     * Thêm vào giỏ hàng (Action trung gian)
     * Thường dùng để nhận POST từ trang Product Detail
     */
    public function addToCart()
    {
        // 1. Kiểm tra đăng nhập
        if (!Auth::check()) {
            $_SESSION['error'] = "Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.";
            $this->redirect('auth');
            return;
        }

        // 2. Xử lý dữ liệu
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)($_POST['product_id'] ?? 0);
            $quantity = (int)($_POST['quantity'] ?? 1);

            if ($productId > 0 && $quantity > 0) {
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                // Nếu đã có thì tăng số lượng
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['quantity'] += $quantity;
                } else {
                    // Nếu chưa có thì thêm mới
                    $_SESSION['cart'][$productId] = [
                        'id' => $productId,
                        'quantity' => $quantity
                    ];
                }
                $_SESSION['success'] = "Đã thêm sản phẩm vào giỏ hàng!";
            }

            // Trở về trang chi tiết sản phẩm
            $this->redirect('shop/detail/' . $productId);
            return;
        }

        $this->redirect('shop');
    }
}
