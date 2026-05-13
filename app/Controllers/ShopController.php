<?php

/**
 * Shop Controller
 * Handle product listing, product details, and cart logic
 */
class ShopController extends BaseController
{
    /**
     * Giả lập dữ liệu mảng (Mock Data). 
     * Khi có Database, bạn sẽ thay thế bằng Model (VD: ProductModel::getAll())
     */
    private function getProducts()
    {
        return [
            1 => ['id' => 1, 'name' => 'Cây Hạnh Phúc', 'price' => 150000, 'category' => 'Lọc không khí', 'image' => 'https://images.unsplash.com/photo-1599598425947-3300262b32ee?auto=format&fit=crop&w=800&q=80', 'desc' => 'Mang lại may mắn, sung túc và tạo điểm nhấn sang trọng cho phòng khách. Dễ chăm sóc, ưa sáng tán xạ.'],
            2 => ['id' => 2, 'name' => 'Cây Lưỡi Hổ', 'price' => 120000, 'category' => 'Phòng ngủ', 'image' => 'https://images.unsplash.com/photo-1620127813580-5a3d078170c0?auto=format&fit=crop&w=800&q=80', 'desc' => 'Khả năng lọc sạch độc tố, nhả oxy vào ban đêm, lý tưởng cho không gian nghỉ ngơi. Chịu hạn cực tốt.'],
            3 => ['id' => 3, 'name' => 'Hoa Lan Ý', 'price' => 250000, 'category' => 'Có hoa', 'image' => 'https://images.unsplash.com/photo-1597558661625-f09db324b172?auto=format&fit=crop&w=800&q=80', 'desc' => 'Vẻ đẹp thanh tao, tinh khiết, giúp cân bằng độ ẩm không khí cực tốt. Phù hợp để bàn làm việc.'],
            4 => ['id' => 4, 'name' => 'Cây Kim Tiền', 'price' => 200000, 'category' => 'Phong thủy', 'image' => 'https://images.unsplash.com/photo-1628157748443-bd21568c0dd4?auto=format&fit=crop&w=800&q=80', 'desc' => 'Biểu tượng của tài lộc, phát triển mạnh mẽ và rất dễ chăm sóc tại văn phòng. Ít sâu bệnh.'],
            5 => ['id' => 5, 'name' => 'Trầu Bà Nam Mỹ', 'price' => 350000, 'category' => 'Trang trí', 'image' => 'https://images.unsplash.com/photo-1614594975525-e45190c55d0b?auto=format&fit=crop&w=800&q=80', 'desc' => 'Cây Monstera với lá xẻ độc đáo, mang phong cách nhiệt đới hiện đại cho không gian nhà bạn.'],
            6 => ['id' => 6, 'name' => 'Bàng Singapore', 'price' => 450000, 'category' => 'Cây nội thất lớn', 'image' => 'https://images.unsplash.com/photo-1610419356020-00d38101a052?auto=format&fit=crop&w=800&q=80', 'desc' => 'Dáng cây thẳng, lá to bản xanh mướt, tạo vẻ sang trọng và thanh lọc bụi bẩn hiệu quả.']
        ];
    }

    /**
     * Shop index page - list all products
     */
    public function index()
    {
        $user = Auth::check() ? Auth::user() : null;
        $products = $this->getProducts();

        $this->view('pages/shop', [
            'user' => $user,
            'products' => $products
        ]);
    }

    /**
     * Product detail page
     */
    public function detail($id = null)
    {
        if (!$id) {
            $this->redirect('shop');
            return;
        }

        $products = $this->getProducts();

        // Kiểm tra xem sản phẩm có tồn tại không
        if (!isset($products[$id])) {
            $this->redirect('shop');
            return;
        }

        $user = Auth::check() ? Auth::user() : null;
        $product = $products[$id];

        // Lấy 4 sản phẩm ngẫu nhiên/đầu tiên làm "Sản phẩm liên quan"
        $relatedProducts = array_slice($products, 0, 4);

        $this->view('pages/product-detail', [
            'user' => $user,
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }

    /**
     * Add product to cart (POST action)
     */
    public function addToCart()
    {
        // 1. Kiểm tra đăng nhập (Yêu cầu User)
        if (!Auth::check()) {
            $_SESSION['error'] = "Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.";
            $this->redirect('auth'); // Hoặc 'login' tùy vào route của bạn
            return;
        }

        // 2. Xử lý form POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $quantity = (int)($_POST['quantity'] ?? 1);

            if ($productId && $quantity > 0) {
                // Khởi tạo giỏ hàng trong session nếu chưa có
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                // Nếu sản phẩm đã có, cộng dồn số lượng. Nếu chưa, tạo mới
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['quantity'] += $quantity;
                } else {
                    $_SESSION['cart'][$productId] = [
                        'id' => $productId,
                        'quantity' => $quantity
                    ];
                }

                $_SESSION['success'] = "Đã thêm sản phẩm vào giỏ hàng thành công!";
            }

            // Redirect quay lại đúng trang chi tiết sản phẩm vừa thêm
            $this->redirect('shop/detail/' . $productId);
            return;
        }

        // Truy cập trái phép qua GET, đẩy về trang chủ cửa hàng
        $this->redirect('shop');
    }
}
