<?php

/**
 * AboutController
 * Xử lý trang Giới thiệu (About Us)
 */
class AboutController extends BaseController
{
    private $db;
    private $dataModel;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->dataModel = new Data();
    }

    public function index()
    {
        // 1. Lấy thông tin user
        $user = Auth::check() ? Auth::user() : null;

        // 2. Truy vấn lấy dữ liệu trang About
        $this->db->query("SELECT * FROM pages WHERE slug = 'about'");
        $page = $this->db->single();

        // Fix lỗi trang trắng: Nếu không tìm thấy trang trong DB, tạo mảng rỗng để View không crash
        if (!$page) {
            $page = [
                'title' => 'Giới thiệu',
                'description' => '',
                'content' => '<p>Nội dung đang được cập nhật...</p>'
            ];
        }

        // 3. Lấy thông tin Hero Video
        $heroVideo = $this->dataModel->content_value('about.hero_video', 'assets/videos/about/about-hero.m3u8');
        if ($heroVideo === 'assets/videos/about/about.m3u8') {
            $heroVideo = 'assets/videos/about/about-hero.m3u8';
        }

        // 4. Lấy thông tin công ty (Địa chỉ, SĐT...) cho phần bản đồ ở cuối trang
        $company = $this->dataModel->site_content_all();
        $testimonials = $this->dataModel->get_testimonials();
        // 5. Render View và truyền đầy đủ data
        $this->view('pages/about', [
            'user'            => $user,
            'page'            => $page,
            'company'         => $company,
            'heroVideo'       => $heroVideo,
            'testimonials'    => $testimonials,
            'pageTitle'       => 'Giới thiệu | Plantify Co',
            'pageDescription' => 'Tìm hiểu Plantify Co, công ty thiết kế decor cây xanh.'
        ]);
    }
}
