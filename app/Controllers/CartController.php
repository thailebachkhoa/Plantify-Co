<?php

/**
 * Cart Controller
 * Quản lý giỏ hàng và liên kết dữ liệu với bảng `products` trong DB
 */
class CartController extends BaseController
{
    public function index()
    {
        $db = Database::getInstance();
        $user = Auth::check() ? Auth::user() : null;

        $cartSession = $_SESSION['cart'] ?? [];
        $cartItems = [];
        $totalPrice = 0;

        if (!empty($cartSession)) {
            // Duyệt qua từng item trong giỏ hàng để lấy thông tin từ DB
            foreach ($cartSession as $id => $item) {
                $result = $db->query("SELECT id, name, category, price, image FROM products WHERE id = :id", ['id' => $id]);

                if (!empty($result)) {
                    $productDetail = $result[0];
                    $productDetail['quantity'] = $item['quantity'];
                    $productDetail['subtotal'] = $productDetail['price'] * $item['quantity'];

                    $cartItems[$id] = $productDetail;
                    $totalPrice += $productDetail['subtotal'];
                } else {
                    // Nếu sản phẩm đã bị xóa khỏi DB, tự động gỡ khỏi giỏ hàng
                    unset($_SESSION['cart'][$id]);
                }
            }
        }

        $this->view('pages/cart', [
            'user' => $user,
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice
        ]);
    }

    public function add()
    {
        if (!Auth::check()) {
            $_SESSION['error'] = "Vui lòng đăng nhập để mua hàng.";
            $this->redirect('auth');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)($_POST['product_id'] ?? 0);
            $quantity = (int)($_POST['quantity'] ?? 1);

            if ($productId > 0 && $quantity > 0) {
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['quantity'] += $quantity;
                } else {
                    $_SESSION['cart'][$productId] = [
                        'id' => $productId,
                        'quantity' => $quantity
                    ];
                }
                $_SESSION['success'] = "Đã thêm sản phẩm vào giỏ hàng!";
            }
            $this->redirect('shop/detail/' . $productId);
            return;
        }
        $this->redirect('shop');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)($_POST['product_id'] ?? 0);
            $action = $_POST['action'] ?? '';

            if (isset($_SESSION['cart'][$productId])) {
                if ($action === 'increase') {
                    $_SESSION['cart'][$productId]['quantity']++;
                } elseif ($action === 'decrease') {
                    $_SESSION['cart'][$productId]['quantity']--;

                    if ($_SESSION['cart'][$productId]['quantity'] <= 0) {
                        unset($_SESSION['cart'][$productId]);
                    }
                }
            }
        }
        $this->redirect('cart');
    }

    public function remove($id = null)
    {
        $id = (int)$id;
        if ($id > 0 && isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
            $_SESSION['success'] = "Đã xóa sản phẩm khỏi giỏ hàng.";
        }
        $this->redirect('cart');
    }
}
