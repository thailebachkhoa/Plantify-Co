<?php

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Tìm 1 sản phẩm theo ID (Dùng cho Trang chi tiết và Giỏ hàng)
     */
    public function findById($id)
    {
        $this->db->query("SELECT * FROM products WHERE id = :id LIMIT 1");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Lấy danh sách sản phẩm phân trang (Dùng cho trang Cửa hàng)
     */
    public function getPaginated($limit, $offset)
    {
        // Ép kiểu int để nối chuỗi trực tiếp an toàn (Tránh lỗi PDO bindParam với LIMIT)
        $limit = (int)$limit;
        $offset = (int)$offset;

        $this->db->query("SELECT * FROM products ORDER BY id DESC LIMIT $limit OFFSET $offset");
        return $this->db->resultSet();
    }

    /**
     * Đếm tổng số sản phẩm (Dùng để tính số trang)
     */
    public function countAll()
    {
        $this->db->query("SELECT COUNT(id) as total FROM products");
        $row = $this->db->single();
        return $row ? (int)$row['total'] : 0;
    }

    /**
     * Lấy các sản phẩm liên quan (Random, trừ sản phẩm hiện tại)
     */
    public function getRelated($exclude_id, $limit = 4)
    {
        $limit = (int)$limit;
        $this->db->query("SELECT * FROM products WHERE id != :id ORDER BY RAND() LIMIT $limit");
        $this->db->bind(':id', $exclude_id);
        return $this->db->resultSet();
    }

    /**
     * Lấy sản phẩm nổi bật (is_featured = 1) dùng cho Trang Chủ
     */
    public function getFeatured($limit = 4)
    {
        $limit = (int)$limit;
        $this->db->query("SELECT * FROM products WHERE is_featured = 1 ORDER BY id DESC LIMIT $limit");
        return $this->db->resultSet();
    }

    /**
     * Lấy TOÀN BỘ sản phẩm (Dùng cho Admin Dashboard)
     */
    public function getAllProducts()
    {
        $this->db->query("SELECT * FROM products ORDER BY id DESC");
        return $this->db->resultSet();
    }

    /**
     * Thêm sản phẩm mới (Admin)
     */
    public function create($data)
    {
        $this->db->query("INSERT INTO products (name, category, price, image, description, is_featured) 
                          VALUES (:name, :category, :price, :image, :description, :is_featured)");

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':is_featured', $data['is_featured'] ?? 0);

        return $this->db->execute();
    }

    /**
     * Cập nhật sản phẩm (Admin)
     */
    public function update($id, $data)
    {
        $this->db->query("UPDATE products 
                          SET name = :name, category = :category, price = :price, 
                              image = :image, description = :description, is_featured = :is_featured 
                          WHERE id = :id");

        $this->db->bind(':id', $id);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':is_featured', $data['is_featured'] ?? 0);

        return $this->db->execute();
    }

    /**
     * Xóa sản phẩm (Admin)
     */
    public function delete($id)
    {
        $this->db->query("DELETE FROM products WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
